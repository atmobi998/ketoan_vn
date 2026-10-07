<?php
namespace App\Service;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;
use Cake\Datasource\ConnectionManager;

class GlPostingService
{
    protected $chartCache = [];

    protected function getAccountIdByCode(string $code): ?int
    {
        if (isset($this->chartCache[$code])) {
            return $this->chartCache[$code];
        }
        $tbl = TableRegistry::getTableLocator()->get('ChartOfAccounts');
        $rec = $tbl->find()->where(['code' => $code])->first();
        if ($rec) {
            $this->chartCache[$code] = $rec->id;
            return $rec->id;
        }
        return null;
    }

    protected function getPeriodIdByDate(FrozenDate|string $date): ?int
    {
        $tbl = TableRegistry::getTableLocator()->get('AccountingPeriods');
        $d = $date instanceof FrozenDate ? $date : new FrozenDate($date);
        $period = $tbl->find()->where([
            'start_date <=' => $d,
            'end_date >=' => $d,
        ])->first();
        if ($period) return $period->id;
        $period = $tbl->find()->where(['status' => 'open'])->orderBy(['start_date' => 'DESC'])->first();
        return $period?->id;
    }

    protected function genEntryNumber(string $prefix, $date): string
    {
        $tbl = TableRegistry::getTableLocator()->get('JournalEntries');
        $d = $date instanceof FrozenDate ? $date : new FrozenDate($date);
        $like = $prefix . '-' . $d->format('Y-m') . '-%';
        $count = $tbl->find()->where(['entry_number LIKE' => $like])->count();
        $seq = $count + 1;
        return sprintf('%s-%s-%03d', $prefix, $d->format('Y-m'), $seq);
    }

    protected function hasPosted(string $refType, $refId): bool
    {
        $tbl = TableRegistry::getTableLocator()->get('JournalEntries');
        return $tbl->find()->where(['reference_type' => $refType, 'reference_id like' => $refId.' %'])->count() > 0;
    }

    protected function getInventoryAccountCodeByCategory(int $catId): string
    {
        return match($catId) {
            1 => '152',
            2 => '155',
            3 => '1561',
            4 => '153',
            default => '1561',
        };
    }

    public function postGoodsReceipt(int $grId, bool $force = false): array
    {
        if (!$force && $this->hasPosted('GoodsReceipt', $grId)) {
            return ['status' => 'skipped', 'message' => 'Đã hạch toán rồi'];
        }
        $grTbl = TableRegistry::getTableLocator()->get('GoodsReceipts');
        $gr = $grTbl->get($grId, contain: ['GoodsReceiptDetails' => ['Products']]);

        if ($gr->status !== 'approved') {
            return ['status' => 'error', 'message' => 'Phiếu chưa duyệt'];
        }

        $periodId = $this->getPeriodIdByDate($gr->receipt_date);
        $entryNumber = $this->genEntryNumber('NK', $gr->receipt_date);

        $firstDetail = $gr->goods_receipt_details[0] ?? null;
        $invCode = '1561';
        if ($firstDetail && $firstDetail->product) {
            $invCode = $this->getInventoryAccountCodeByCategory((int)$firstDetail->product->product_category_id);
        }

        $accInv = $this->getAccountIdByCode($invCode);
        $accVat = $this->getAccountIdByCode('1331');
        $acc331 = $this->getAccountIdByCode('331');

        if (!$accInv || !$accVat || !$acc331) {
            return ['status' => 'error', 'message' => "Thiếu TK: inv=$invCode, 1331, 331"];
        }

        $jeTbl = TableRegistry::getTableLocator()->get('JournalEntries');
        $jelTbl = TableRegistry::getTableLocator()->get('JournalEntryLines');
        $conn = $jeTbl->getConnection();

        try {
            return $conn->transactional(function ($conn) use ($jeTbl, $jelTbl, $gr, $periodId, $entryNumber, $accInv, $accVat, $acc331, $grId) {
                $je = $jeTbl->newEmptyEntity();
                $je->entry_number = $entryNumber;
                $je->entry_date = $gr->receipt_date;
                $je->accounting_date = $gr->receipt_date;
                $je->description = "Nhập kho {$gr->gr_number} - NCC {$gr->supplier_id}";
                $je->total_debit = $gr->grand_total;
                $je->total_credit = $gr->grand_total;
                $je->status = 'posted';
                $je->accounting_period_id = $periodId;
                $je->reference_type = 'GoodsReceipt';
                $je->reference_id = (string)$grId.' ('.$gr->gr_number.')';
                $je->created_by = 1;

                if (!$jeTbl->save($je)) {
                    throw new \Exception('Không lưu được bút toán: '.json_encode($je->getErrors()));
                }

                $lines = [];
                if ($gr->total_amount > 0) {
                    $lines[] = $jelTbl->newEntity([
                        'journal_entry_id' => $je->id,
                        'chart_of_account_id' => $accInv,
                        'debit' => $gr->total_amount,
                        'credit' => 0,
                        'description' => "Nhập kho {$gr->gr_number}",
                        'supplier_id' => $gr->supplier_id,
                    ]);
                }
                if ($gr->vat_amount > 0) {
                    $lines[] = $jelTbl->newEntity([
                        'journal_entry_id' => $je->id,
                        'chart_of_account_id' => $accVat,
                        'debit' => $gr->vat_amount,
                        'credit' => 0,
                        'description' => "VAT nhập kho {$gr->gr_number}",
                        'supplier_id' => $gr->supplier_id,
                    ]);
                }
                $lines[] = $jelTbl->newEntity([
                    'journal_entry_id' => $je->id,
                    'chart_of_account_id' => $acc331,
                    'debit' => 0,
                    'credit' => $gr->grand_total,
                    'description' => "Phải trả NCC - {$gr->gr_number}",
                    'supplier_id' => $gr->supplier_id,
                ]);

                foreach ($lines as $line) {
                    $jelTbl->saveOrFail($line);
                }

                return ['status' => 'ok', 'entry_id' => $je->id, 'entry_number' => $entryNumber];
            });
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function postDeliveryNote(int $dnId, bool $force = false): array
    {
        if (!$force && $this->hasPosted('DeliveryNote', $dnId)) {
            return ['status' => 'skipped', 'message' => 'Đã hạch toán giá vốn rồi'];
        }
        $dnTbl = TableRegistry::getTableLocator()->get('DeliveryNotes');
        $dn = $dnTbl->get($dnId, contain: ['DeliveryNoteDetails' => ['Products']]);

        if ($dn->status !== 'approved') {
            return ['status' => 'error', 'message' => 'Phiếu chưa duyệt'];
        }

        $periodId = $this->getPeriodIdByDate($dn->delivery_date);
        $entryNumber = $this->genEntryNumber('XK', $dn->delivery_date);

        $firstDetail = $dn->delivery_note_details[0] ?? null;
        $invCode = '1561';
        if ($firstDetail && $firstDetail->product) {
            $invCode = $this->getInventoryAccountCodeByCategory((int)$firstDetail->product->product_category_id);
        }

        $accInv = $this->getAccountIdByCode($invCode);
        $acc632 = $this->getAccountIdByCode('632');

        if (!$accInv || !$acc632) {
            return ['status' => 'error', 'message' => "Thiếu TK: $invCode, 632"];
        }

        $jeTbl = TableRegistry::getTableLocator()->get('JournalEntries');
        $jelTbl = TableRegistry::getTableLocator()->get('JournalEntryLines');
        $conn = $jeTbl->getConnection();

        try {
            return $conn->transactional(function ($conn) use ($jeTbl, $jelTbl, $dn, $periodId, $entryNumber, $accInv, $acc632, $dnId) {
                $je = $jeTbl->newEmptyEntity();
                $je->entry_number = $entryNumber;
                $je->entry_date = $dn->delivery_date;
                $je->accounting_date = $dn->delivery_date;
                $je->description = "Xuất kho giá vốn {$dn->dn_number}";
                $je->total_debit = $dn->total_amount;
                $je->total_credit = $dn->total_amount;
                $je->status = 'posted';
                $je->accounting_period_id = $periodId;
                $je->reference_type = 'DeliveryNote';
                $je->reference_id = (string)$dnId.' ('.$dn->dn_number.')';
                $je->created_by = 1;

                $jeTbl->saveOrFail($je);

                $line1 = $jelTbl->newEntity([
                    'journal_entry_id' => $je->id,
                    'chart_of_account_id' => $acc632,
                    'debit' => $dn->total_amount,
                    'credit' => 0,
                    'description' => "Giá vốn {$dn->dn_number}",
                    'customer_id' => $dn->customer_id,
                ]);
                $line2 = $jelTbl->newEntity([
                    'journal_entry_id' => $je->id,
                    'chart_of_account_id' => $accInv,
                    'debit' => 0,
                    'credit' => $dn->total_amount,
                    'description' => "Xuất kho {$dn->dn_number}",
                    'customer_id' => $dn->customer_id,
                ]);

                $jelTbl->saveOrFail($line1);
                $jelTbl->saveOrFail($line2);

                return ['status' => 'ok', 'entry_id' => $je->id, 'entry_number' => $entryNumber];
            });
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function postSalesInvoice(int $siId, bool $force = false): array
    {
        if (!$force && $this->hasPosted('SalesInvoice', $siId)) {
            return ['status' => 'skipped', 'message' => 'Đã hạch toán rồi'];
        }
        $siTbl = TableRegistry::getTableLocator()->get('SalesInvoices');
        $si = $siTbl->get($siId);

        if ($si->status === 'draft' || $si->status === 'cancelled') {
            return ['status' => 'error', 'message' => 'Hóa đơn chưa duyệt'];
        }

        $periodId = $this->getPeriodIdByDate($si->invoice_date);
        $entryNumber = $this->genEntryNumber('BH', $si->invoice_date);

        $acc131 = $this->getAccountIdByCode('131');
        $acc5111 = $this->getAccountIdByCode('5111');
        $acc33311 = $this->getAccountIdByCode('33311');

        if (!$acc131 || !$acc5111 || !$acc33311) {
            return ['status' => 'error', 'message' => 'Thiếu TK 131/5111/33311'];
        }

        $jeTbl = TableRegistry::getTableLocator()->get('JournalEntries');
        $jelTbl = TableRegistry::getTableLocator()->get('JournalEntryLines');
        $conn = $jeTbl->getConnection();

        try {
            return $conn->transactional(function ($conn) use ($jeTbl, $jelTbl, $si, $periodId, $entryNumber, $acc131, $acc5111, $acc33311, $siId) {
                $je = $jeTbl->newEmptyEntity();
                $je->entry_number = $entryNumber;
                $je->entry_date = $si->invoice_date;
                $je->accounting_date = $si->invoice_date;
                $je->description = "Doanh thu {$si->invoice_number}";
                $je->total_debit = $si->grand_total;
                $je->total_credit = $si->grand_total;
                $je->status = 'posted';
                $je->accounting_period_id = $periodId;
                $je->reference_type = 'SalesInvoice';
                $je->reference_id = (string)$siId.' ('.$si->invoice_number.')';
                $je->created_by = 1;

                $jeTbl->saveOrFail($je);

                $lines = [];
                $lines[] = $jelTbl->newEntity([
                    'journal_entry_id' => $je->id,
                    'chart_of_account_id' => $acc131,
                    'debit' => $si->grand_total,
                    'credit' => 0,
                    'description' => "Phải thu KH {$si->invoice_number}",
                    'customer_id' => $si->customer_id,
                ]);
                if ($si->total_amount > 0) {
                    $lines[] = $jelTbl->newEntity([
                        'journal_entry_id' => $je->id,
                        'chart_of_account_id' => $acc5111,
                        'debit' => 0,
                        'credit' => $si->total_amount,
                        'description' => "Doanh thu {$si->invoice_number}",
                        'customer_id' => $si->customer_id,
                    ]);
                }
                if ($si->vat_amount > 0) {
                    $lines[] = $jelTbl->newEntity([
                        'journal_entry_id' => $je->id,
                        'chart_of_account_id' => $acc33311,
                        'debit' => 0,
                        'credit' => $si->vat_amount,
                        'description' => "VAT đầu ra {$si->invoice_number}",
                        'customer_id' => $si->customer_id,
                    ]);
                }
                foreach ($lines as $l) $jelTbl->saveOrFail($l);

                return ['status' => 'ok', 'entry_id' => $je->id, 'entry_number' => $entryNumber];
            });
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function postPurchaseInvoice(int $piId, bool $force = false): array
    {
        if (!$force && $this->hasPosted('PurchaseInvoice', $piId)) {
            return ['status' => 'skipped', 'message' => 'Đã hạch toán rồi'];
        }
        $piTbl = TableRegistry::getTableLocator()->get('PurchaseInvoices');
        $pi = $piTbl->get($piId, contain: ['PurchaseInvoiceDetails' => ['Products']]);

        if ($pi->status === 'draft' || $pi->status === 'cancelled') {
            return ['status' => 'error', 'message' => 'Hóa đơn chưa duyệt'];
        }

        if (!empty($pi->goods_receipt_id) && $this->hasPosted('GoodsReceipt', $pi->goods_receipt_id) && !$force) {
            return ['status' => 'skipped', 'message' => 'Đã hạch toán qua phiếu nhập kho GR#'.$pi->goods_receipt_id];
        }

        $periodId = $this->getPeriodIdByDate($pi->invoice_date);
        $entryNumber = $this->genEntryNumber('MH', $pi->invoice_date);

        $firstDetail = $pi->purchase_invoice_details[0] ?? null;
        $invCode = '1561';
        if ($firstDetail && $firstDetail->product) {
            $invCode = $this->getInventoryAccountCodeByCategory((int)$firstDetail->product->product_category_id);
        }

        $accInv = $this->getAccountIdByCode($invCode);
        $acc1331 = $this->getAccountIdByCode('1331');
        $acc331 = $this->getAccountIdByCode('331');

        if (!$accInv || !$acc1331 || !$acc331) {
            return ['status' => 'error', 'message' => "Thiếu TK $invCode/1331/331"];
        }

        $jeTbl = TableRegistry::getTableLocator()->get('JournalEntries');
        $jelTbl = TableRegistry::getTableLocator()->get('JournalEntryLines');
        $conn = $jeTbl->getConnection();

        try {
            return $conn->transactional(function ($conn) use ($jeTbl, $jelTbl, $pi, $periodId, $entryNumber, $accInv, $acc1331, $acc331, $piId) {
                $je = $jeTbl->newEmptyEntity();
                $je->entry_number = $entryNumber;
                $je->entry_date = $pi->invoice_date;
                $je->accounting_date = $pi->invoice_date;
                $je->description = "Mua hàng {$pi->invoice_number}";
                $je->total_debit = $pi->grand_total;
                $je->total_credit = $pi->grand_total;
                $je->status = 'posted';
                $je->accounting_period_id = $periodId;
                $je->reference_type = 'PurchaseInvoice';
                $je->reference_id = (string)$piId.' ('.$pi->invoice_number.')';
                $je->created_by = 1;
                $jeTbl->saveOrFail($je);

                $lines = [];
                if ($pi->total_amount > 0) {
                    $lines[] = $jelTbl->newEntity([
                        'journal_entry_id' => $je->id,
                        'chart_of_account_id' => $accInv,
                        'debit' => $pi->total_amount,
                        'credit' => 0,
                        'description' => "Mua hàng {$pi->invoice_number}",
                        'supplier_id' => $pi->supplier_id,
                    ]);
                }
                if ($pi->vat_amount > 0) {
                    $lines[] = $jelTbl->newEntity([
                        'journal_entry_id' => $je->id,
                        'chart_of_account_id' => $acc1331,
                        'debit' => $pi->vat_amount,
                        'credit' => 0,
                        'description' => "VAT mua vào {$pi->invoice_number}",
                        'supplier_id' => $pi->supplier_id,
                    ]);
                }
                $lines[] = $jelTbl->newEntity([
                    'journal_entry_id' => $je->id,
                    'chart_of_account_id' => $acc331,
                    'debit' => 0,
                    'credit' => $pi->grand_total,
                    'description' => "Phải trả NCC {$pi->invoice_number}",
                    'supplier_id' => $pi->supplier_id,
                ]);
                foreach ($lines as $l) $jelTbl->saveOrFail($l);

                return ['status' => 'ok', 'entry_id' => $je->id, 'entry_number' => $entryNumber];
            });
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function postAllMissing(): array
    {
        $results = [];
        $grTbl = TableRegistry::getTableLocator()->get('GoodsReceipts');
        $grs = $grTbl->find()->where(['status' => 'approved'])->all();
        foreach ($grs as $gr) {
            $results[] = ['type' => 'GoodsReceipt', 'id' => $gr->id, 'result' => $this->postGoodsReceipt($gr->id)];
        }
        $dnTbl = TableRegistry::getTableLocator()->get('DeliveryNotes');
        $dns = $dnTbl->find()->where(['status' => 'approved'])->all();
        foreach ($dns as $dn) {
            $results[] = ['type' => 'DeliveryNote', 'id' => $dn->id, 'result' => $this->postDeliveryNote($dn->id)];
        }
        $piTbl = TableRegistry::getTableLocator()->get('PurchaseInvoices');
        $pis = $piTbl->find()->where(['status IN' => ['approved','paid']])->all();
        foreach ($pis as $pi) {
            $results[] = ['type' => 'PurchaseInvoice', 'id' => $pi->id, 'result' => $this->postPurchaseInvoice($pi->id)];
        }
        $siTbl = TableRegistry::getTableLocator()->get('SalesInvoices');
        $sis = $siTbl->find()->where(['status IN' => ['approved','paid']])->all();
        foreach ($sis as $si) {
            $results[] = ['type' => 'SalesInvoice', 'id' => $si->id, 'result' => $this->postSalesInvoice($si->id)];
        }
        return $results;
    }
}
