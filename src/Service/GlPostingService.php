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
        return $tbl->find()->where(['reference_type' => $refType, 'reference_id' => $refId])->count() > 0;
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
                $je->reference_id = (string)$grId;
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
                $je->reference_id = (string)$dnId;
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
        $cashReceiptTbl = TableRegistry::getTableLocator()->get('CashReceipts');
        $crs = $cashReceiptTbl->find()->where(['status' => 'approved'])->all();
        foreach ($crs as $cr) {
            $results[] = ['type' => 'CashReceipt', 'id' => $cr->id, 'result' => $this->postCashReceipt($cr->id)];
        }

        $cashPaymentTbl = TableRegistry::getTableLocator()->get('CashPayments');
        $cps = $cashPaymentTbl->find()->where(['status' => 'approved'])->all();
        foreach ($cps as $cp) {
            $results[] = ['type' => 'CashPayment', 'id' => $cp->id, 'result' => $this->postCashPayment($cp->id)];
        }

        $bankReceiptTbl = TableRegistry::getTableLocator()->get('BankReceipts');
        $brs = $bankReceiptTbl->find()->where(['status' => 'approved'])->all();
        foreach ($brs as $br) {
            $results[] = ['type' => 'BankReceipt', 'id' => $br->id, 'result' => $this->postBankReceipt($br->id)];
        }

        $bankPaymentTbl = TableRegistry::getTableLocator()->get('BankPayments');
        $bps = $bankPaymentTbl->find()->where(['status' => 'approved'])->all();
        foreach ($bps as $bp) {
            $results[] = ['type' => 'BankPayment', 'id' => $bp->id, 'result' => $this->postBankPayment($bp->id)];
        }

        $payrollTbl = TableRegistry::getTableLocator()->get('Payrolls');
        $payrolls = $payrollTbl->find()->where(['status IN' => ['approved','paid']])->all();
        foreach ($payrolls as $pr) {
            $results[] = ['type' => 'Payroll', 'id' => $pr->id, 'result' => $this->postPayroll($pr->id)];
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
                $je->reference_id = (string)$siId;
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
                $je->reference_id = (string)$piId;
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


    protected function getExpenseAccountByDepartment(?int $deptId): string
    {
        // Map phòng ban -> TK chi phí
        // 1: Ban Giám Đốc, 2: Hành chính -> 6421
        // 3: Kỹ thuật, 6,7,8: gián tiếp -> 6271 hoặc 642
        // 4: Sản xuất -> 622
        // 5: Kinh doanh -> 6411
        return match($deptId) {
            4 => '622',      // Sản xuất - CP NCTT
            5 => '6411',     // Bán hàng - CP nhân viên BH (fallback 641)
            1,2 => '6421',   // QLDN - CP nhân viên QLDN
            3,6,7,8 => '6271', // SXC - CP nhân viên PB (fallback 627)
            default => '6421',
        };
    }

    /**
     * POST BẢNG LƯƠNG - Payrolls
     * Nợ 622/627/641/642 : total_amount (tổng lương gross)
     * Có 334 : total_net (thực lĩnh)
     * Có 3383, 3384, 3386 : insurance_deduction (phân bổ)
     * Có 3335 : tax_deduction
     */
    public function postPayroll(int $payrollId, bool $force = false): array
    {
        if (!$force && $this->hasPosted('Payroll', $payrollId)) {
            return ['status' => 'skipped', 'message' => 'Đã hạch toán lương rồi'];
        }

        $cashReceiptTbl = TableRegistry::getTableLocator()->get('CashReceipts');
        $crs = $cashReceiptTbl->find()->where(['status' => 'approved'])->all();
        foreach ($crs as $cr) {
            $results[] = ['type' => 'CashReceipt', 'id' => $cr->id, 'result' => $this->postCashReceipt($cr->id)];
        }

        $cashPaymentTbl = TableRegistry::getTableLocator()->get('CashPayments');
        $cps = $cashPaymentTbl->find()->where(['status' => 'approved'])->all();
        foreach ($cps as $cp) {
            $results[] = ['type' => 'CashPayment', 'id' => $cp->id, 'result' => $this->postCashPayment($cp->id)];
        }

        $bankReceiptTbl = TableRegistry::getTableLocator()->get('BankReceipts');
        $brs = $bankReceiptTbl->find()->where(['status' => 'approved'])->all();
        foreach ($brs as $br) {
            $results[] = ['type' => 'BankReceipt', 'id' => $br->id, 'result' => $this->postBankReceipt($br->id)];
        }

        $bankPaymentTbl = TableRegistry::getTableLocator()->get('BankPayments');
        $bps = $bankPaymentTbl->find()->where(['status' => 'approved'])->all();
        foreach ($bps as $bp) {
            $results[] = ['type' => 'BankPayment', 'id' => $bp->id, 'result' => $this->postBankPayment($bp->id)];
        }

        $payrollTbl = TableRegistry::getTableLocator()->get('Payrolls');
        $payroll = $payrollTbl->get($payrollId);

        if ($payroll->status !== 'approved' && $payroll->status !== 'paid') {
            return ['status' => 'error', 'message' => 'Bảng lương chưa duyệt'];
        }

        // Xác định kỳ kế toán từ tháng/năm bảng lương
        $dateStr = sprintf('%04d-%02d-01', $payroll->payroll_year, $payroll->payroll_month);
        $periodId = $this->getPeriodIdByDate($dateStr);
        $entryNumber = $this->genEntryNumber('LUONG', $dateStr);

        // TK chi phí theo phòng ban
        $expenseCode = $this->getExpenseAccountByDepartment($payroll->department_id);
        $accExpense = $this->getAccountIdByCode($expenseCode);
        // Fallback nếu TK chi tiết không có
        if (!$accExpense) {
            $fallback = match($expenseCode) {
                '6411' => '641',
                '6271' => '627',
                '6421' => '642',
                default => '642',
            };
            $accExpense = $this->getAccountIdByCode($fallback);
        }

        $acc334 = $this->getAccountIdByCode('3341') ?? $this->getAccountIdByCode('334');
        $acc3383 = $this->getAccountIdByCode('3383');
        $acc3384 = $this->getAccountIdByCode('3384');
        $acc3386 = $this->getAccountIdByCode('3386');
        $acc338 = $this->getAccountIdByCode('338');
        $acc3335 = $this->getAccountIdByCode('3335');

        if (!$accExpense || !$acc334) {
            return ['status' => 'error', 'message' => "Thiếu TK chi phí $expenseCode hoặc 334"];
        }

        $jeTbl = TableRegistry::getTableLocator()->get('JournalEntries');
        $jelTbl = TableRegistry::getTableLocator()->get('JournalEntryLines');
        $conn = $jeTbl->getConnection();

        try {
            return $conn->transactional(function ($conn) use ($jeTbl, $jelTbl, $payroll, $periodId, $entryNumber, $accExpense, $acc334, $acc3383, $acc3384, $acc3386, $acc338, $acc3335, $payrollId) {
                $je = $jeTbl->newEmptyEntity();
                $je->entry_number = $entryNumber;
                $je->entry_date = sprintf('%04d-%02d-%02d', $payroll->payroll_year, $payroll->payroll_month, 28);
                $je->accounting_date = $je->entry_date;
                $je->description = "Lương T{$payroll->payroll_month}/{$payroll->payroll_year} - {$payroll->payroll_code} ({$payroll->total_employees} NV)";
                $je->total_debit = $payroll->total_amount;
                $je->total_credit = $payroll->total_amount;
                $je->status = 'posted';
                $je->accounting_period_id = $periodId;
                $je->reference_type = 'Payroll';
                $je->reference_id = (string)$payrollId;
                $je->created_by = 1;

                $jeTbl->saveOrFail($je);

                // Nợ chi phí
                $lineDr = $jelTbl->newEntity([
                    'journal_entry_id' => $je->id,
                    'chart_of_account_id' => $accExpense,
                    'debit' => $payroll->total_amount,
                    'credit' => 0,
                    'description' => "Chi phí lương {$payroll->payroll_code}",
                ]);
                $jelTbl->saveOrFail($lineDr);

                // Có 334 - thực lĩnh
                if ($payroll->total_net > 0) {
                    $line334 = $jelTbl->newEntity([
                        'journal_entry_id' => $je->id,
                        'chart_of_account_id' => $acc334,
                        'debit' => 0,
                        'credit' => $payroll->total_net,
                        'description' => "Lương phải trả {$payroll->payroll_code}",
                    ]);
                    $jelTbl->saveOrFail($line334);
                }

                // Có BHXH - phân bổ 70/20/10 nếu có chi tiết, không thì gộp vào 3383
                if ($payroll->insurance_deduction > 0) {
                    if ($acc3383 && $acc3384 && $acc3386) {
                        // Tỉ lệ VN: BHXH 17.5% DN, BHYT 3%, BHTN 1% - nhưng ở đây chỉ có phần trừ NLĐ
                        // Tạm chia: 3383 70%, 3384 20%, 3386 10% cho phần khấu trừ NLĐ
                        $ins = (float)$payroll->insurance_deduction;
                        $l3383 = $jelTbl->newEntity([
                            'journal_entry_id' => $je->id,
                            'chart_of_account_id' => $acc3383,
                            'debit' => 0,
                            'credit' => round($ins * 0.70, 2),
                            'description' => "BHXH trừ lương {$payroll->payroll_code}",
                        ]);
                        $l3384 = $jelTbl->newEntity([
                            'journal_entry_id' => $je->id,
                            'chart_of_account_id' => $acc3384,
                            'debit' => 0,
                            'credit' => round($ins * 0.20, 2),
                            'description' => "BHYT trừ lương {$payroll->payroll_code}",
                        ]);
                        $l3386 = $jelTbl->newEntity([
                            'journal_entry_id' => $je->id,
                            'chart_of_account_id' => $acc3386,
                            'debit' => 0,
                            'credit' => round($ins * 0.10, 2),
                            'description' => "BHTN trừ lương {$payroll->payroll_code}",
                        ]);
                        $jelTbl->saveOrFail($l3383);
                        $jelTbl->saveOrFail($l3384);
                        $jelTbl->saveOrFail($l3386);
                    } else {
                        $acc = $acc3383 ?? $acc338 ?? $acc334;
                        $line338 = $jelTbl->newEntity([
                            'journal_entry_id' => $je->id,
                            'chart_of_account_id' => $acc,
                            'debit' => 0,
                            'credit' => $payroll->insurance_deduction,
                            'description' => "Bảo hiểm trừ lương {$payroll->payroll_code}",
                        ]);
                        $jelTbl->saveOrFail($line338);
                    }
                }

                // Có thuế TNCN
                if ($payroll->tax_deduction > 0 && $acc3335) {
                    $lineTax = $jelTbl->newEntity([
                        'journal_entry_id' => $je->id,
                        'chart_of_account_id' => $acc3335,
                        'debit' => 0,
                        'credit' => $payroll->tax_deduction,
                        'description' => "Thuế TNCN {$payroll->payroll_code}",
                    ]);
                    $jelTbl->saveOrFail($lineTax);
                }

                return ['status' => 'ok', 'entry_id' => $je->id, 'entry_number' => $entryNumber];
            });
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Hạch toán tổng hợp lương theo tháng (gộp tất cả phòng ban)
     */
    public function postPayrollMonth(int $month, int $year, bool $force = false): array
    {
        $cashReceiptTbl = TableRegistry::getTableLocator()->get('CashReceipts');
        $crs = $cashReceiptTbl->find()->where(['status' => 'approved'])->all();
        foreach ($crs as $cr) {
            $results[] = ['type' => 'CashReceipt', 'id' => $cr->id, 'result' => $this->postCashReceipt($cr->id)];
        }

        $cashPaymentTbl = TableRegistry::getTableLocator()->get('CashPayments');
        $cps = $cashPaymentTbl->find()->where(['status' => 'approved'])->all();
        foreach ($cps as $cp) {
            $results[] = ['type' => 'CashPayment', 'id' => $cp->id, 'result' => $this->postCashPayment($cp->id)];
        }

        $bankReceiptTbl = TableRegistry::getTableLocator()->get('BankReceipts');
        $brs = $bankReceiptTbl->find()->where(['status' => 'approved'])->all();
        foreach ($brs as $br) {
            $results[] = ['type' => 'BankReceipt', 'id' => $br->id, 'result' => $this->postBankReceipt($br->id)];
        }

        $bankPaymentTbl = TableRegistry::getTableLocator()->get('BankPayments');
        $bps = $bankPaymentTbl->find()->where(['status' => 'approved'])->all();
        foreach ($bps as $bp) {
            $results[] = ['type' => 'BankPayment', 'id' => $bp->id, 'result' => $this->postBankPayment($bp->id)];
        }

        $payrollTbl = TableRegistry::getTableLocator()->get('Payrolls');
        $payrolls = $payrollTbl->find()->where(['payroll_month' => $month, 'payroll_year' => $year, 'status IN' => ['approved','paid']])->all();

        if ($payrolls->isEmpty()) {
            return ['status' => 'error', 'message' => "Không có bảng lương T$month/$year"];
        }

        $results = [];
        foreach ($payrolls as $p) {
            $results[] = ['id' => $p->id, 'code' => $p->payroll_code, 'result' => $this->postPayroll($p->id, $force)];
        }

        $success = count(array_filter($results, fn($r) => $r['result']['status'] === 'ok'));
        return ['status' => 'ok', 'message' => "Đã hạch toán $success/".count($results)." bảng lương T$month/$year", 'details' => $results];
    }



    // ==================== VỐN BẰNG TIỀN - 111, 112 ====================

    /**
     * Phiếu thu tiền mặt - PT
     * Nợ 1111 / Có TK đối ứng (chi tiết)
     */
    public function postCashReceipt(int $id, bool $force = false): array
    {
        if (!$force && $this->hasPosted('CashReceipt', $id)) {
            return ['status' => 'skipped', 'message' => 'Đã hạch toán PT rồi'];
        }
        $tbl = TableRegistry::getTableLocator()->get('CashReceipts');
        $detailsTbl = TableRegistry::getTableLocator()->get('CashReceiptDetails');
        $pt = $tbl->get($id);
        
        if ($pt->status !== 'approved') {
            return ['status' => 'error', 'message' => 'Phiếu thu chưa duyệt'];
        }

        $periodId = $this->getPeriodIdByDate($pt->voucher_date->format('Y-m-d') ?? $pt->accounting_date->format('Y-m-d'));
        $entryNumber = $this->genEntryNumber('PT', $pt->voucher_date->format('Y-m-d'));

        $acc1111 = $this->getAccountIdByCode('1111') ?? $this->getAccountIdByCode('111');
        if (!$acc1111) {
            return ['status' => 'error', 'message' => 'Thiếu TK 1111'];
        }

        $details = $detailsTbl->find()->where(['cash_receipt_id' => $id])->all();
        
        $jeTbl = TableRegistry::getTableLocator()->get('JournalEntries');
        $jelTbl = TableRegistry::getTableLocator()->get('JournalEntryLines');
        $conn = $jeTbl->getConnection();

        try {
            return $conn->transactional(function () use ($jeTbl, $jelTbl, $pt, $periodId, $entryNumber, $acc1111, $details, $id) {
                $je = $jeTbl->newEmptyEntity();
                $je->entry_number = $entryNumber;
                $je->entry_date = $pt->voucher_date;
                $je->accounting_date = $pt->accounting_date;
                $je->description = "Thu tiền mặt {$pt->voucher_number} - {$pt->payer_name}: {$pt->reason}";
                $je->total_debit = $pt->amount_vnd;
                $je->total_credit = $pt->amount_vnd;
                $je->status = 'posted';
                $je->accounting_period_id = $periodId;
                $je->reference_type = 'CashReceipt';
                $je->reference_id = (string)$id;
                $je->created_by = $pt->created_by ?? 1;
                $jeTbl->saveOrFail($je);

                // Nợ 1111
                $dr = $jelTbl->newEntity([
                    'journal_entry_id' => $je->id,
                    'chart_of_account_id' => $acc1111,
                    'debit' => $pt->amount_vnd,
                    'credit' => 0,
                    'description' => $pt->reason ?? 'Thu tiền mặt',
                ]);
                $jelTbl->saveOrFail($dr);

                // Có TK đối ứng - từ chi tiết hoặc header
                if (!$details->isEmpty()) {
                    foreach ($details as $d) {
                        if ($d->amount <= 0) continue;
                        $acc = $d->chart_of_account_id;
                        if (!$acc) continue;
                        $cr = $jelTbl->newEntity([
                            'journal_entry_id' => $je->id,
                            'chart_of_account_id' => $acc,
                            'debit' => 0,
                            'credit' => $d->amount,
                            'description' => $d->description ?? $pt->reason,
                        ]);
                        $jelTbl->saveOrFail($cr);
                    }
                } else {
                    $accCo = $pt->chart_of_account_id;
                    if ($accCo) {
                        $cr = $jelTbl->newEntity([
                            'journal_entry_id' => $je->id,
                            'chart_of_account_id' => $accCo,
                            'debit' => 0,
                            'credit' => $pt->amount_vnd,
                            'description' => $pt->reason,
                        ]);
                        $jelTbl->saveOrFail($cr);
                    }
                }

                return ['status' => 'ok', 'entry_id' => $je->id, 'entry_number' => $entryNumber];
            });
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Phiếu chi tiền mặt - PC
     * Nợ TK đối ứng / Có 1111
     */
    public function postCashPayment(int $id, bool $force = false): array
    {
        if (!$force && $this->hasPosted('CashPayment', $id)) {
            return ['status' => 'skipped', 'message' => 'Đã hạch toán PC rồi'];
        }
        $tbl = TableRegistry::getTableLocator()->get('CashPayments');
        $detailsTbl = TableRegistry::getTableLocator()->get('CashPaymentDetails');
        $pc = $tbl->get($id);

        if ($pc->status !== 'approved') {
            return ['status' => 'error', 'message' => 'Phiếu chi chưa duyệt'];
        }

        $periodId = $this->getPeriodIdByDate($pc->voucher_date->format('Y-m-d') ?? $pc->accounting_date->format('Y-m-d'));
        $entryNumber = $this->genEntryNumber('PC', $pc->voucher_date->format('Y-m-d'));

        $acc1111 = $this->getAccountIdByCode('1111') ?? $this->getAccountIdByCode('111');
        if (!$acc1111) {
            return ['status' => 'error', 'message' => 'Thiếu TK 1111'];
        }

        $details = $detailsTbl->find()->where(['cash_payment_id' => $id])->all();
        $jeTbl = TableRegistry::getTableLocator()->get('JournalEntries');
        $jelTbl = TableRegistry::getTableLocator()->get('JournalEntryLines');
        $conn = $jeTbl->getConnection();

        try {
            return $conn->transactional(function () use ($jeTbl, $jelTbl, $pc, $periodId, $entryNumber, $acc1111, $details, $id) {
                $je = $jeTbl->newEmptyEntity();
                $je->entry_number = $entryNumber;
                $je->entry_date = $pc->voucher_date;
                $je->accounting_date = $pc->accounting_date;
                $je->description = "Chi tiền mặt {$pc->voucher_number} - {$pc->payee_name}: {$pc->reason}";
                $je->total_debit = $pc->amount_vnd;
                $je->total_credit = $pc->amount_vnd;
                $je->status = 'posted';
                $je->accounting_period_id = $periodId;
                $je->reference_type = 'CashPayment';
                $je->reference_id = (string)$id;
                $je->created_by = $pc->created_by ?? 1;
                $jeTbl->saveOrFail($je);

                // Có 1111
                $cr = $jelTbl->newEntity([
                    'journal_entry_id' => $je->id,
                    'chart_of_account_id' => $acc1111,
                    'debit' => 0,
                    'credit' => $pc->amount_vnd,
                    'description' => $pc->reason ?? 'Chi tiền mặt',
                ]);
                $jelTbl->saveOrFail($cr);

                // Nợ TK đối ứng
                if (!$details->isEmpty()) {
                    foreach ($details as $d) {
                        if ($d->amount <= 0) continue;
                        $acc = $d->chart_of_account_id;
                        if (!$acc) continue;
                        $dr = $jelTbl->newEntity([
                            'journal_entry_id' => $je->id,
                            'chart_of_account_id' => $acc,
                            'debit' => $d->amount,
                            'credit' => 0,
                            'description' => $d->description ?? $pc->reason,
                        ]);
                        $jelTbl->saveOrFail($dr);
                    }
                } else {
                    $accNo = $pc->chart_of_account_id;
                    if ($accNo) {
                        $dr = $jelTbl->newEntity([
                            'journal_entry_id' => $je->id,
                            'chart_of_account_id' => $accNo,
                            'debit' => $pc->amount_vnd,
                            'credit' => 0,
                            'description' => $pc->reason,
                        ]);
                        $jelTbl->saveOrFail($dr);
                    }
                }

                return ['status' => 'ok', 'entry_id' => $je->id, 'entry_number' => $entryNumber];
            });
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Giấy báo Có ngân hàng - BC
     * Nợ 1121 / Có TK đối ứng
     */
    public function postBankReceipt(int $id, bool $force = false): array
    {
        if (!$force && $this->hasPosted('BankReceipt', $id)) {
            return ['status' => 'skipped', 'message' => 'Đã hạch toán BC rồi'];
        }
        $tbl = TableRegistry::getTableLocator()->get('BankReceipts');
        $br = $tbl->get($id);
        if ($br->status !== 'approved') {
            return ['status' => 'error', 'message' => 'Giấy báo Có chưa duyệt'];
        }

        $periodId = $this->getPeriodIdByDate($br->voucher_date->format('Y-m-d'));
        $entryNumber = $this->genEntryNumber('BC', $br->voucher_date->format('Y-m-d'));

        // TK 112 từ bank_accounts
        $bankAccTbl = TableRegistry::getTableLocator()->get('BankAccounts');
        $bankAcc = $bankAccTbl->get($br->bank_account_id);
        $acc112 = $bankAcc->chart_of_account_id ?? $this->getAccountIdByCode('1121') ?? $this->getAccountIdByCode('112');

        if (!$acc112) {
            return ['status' => 'error', 'message' => 'Thiếu TK 1121'];
        }

        $jeTbl = TableRegistry::getTableLocator()->get('JournalEntries');
        $jelTbl = TableRegistry::getTableLocator()->get('JournalEntryLines');
        $conn = $jeTbl->getConnection();

        try {
            return $conn->transactional(function () use ($jeTbl, $jelTbl, $br, $periodId, $entryNumber, $acc112, $id) {
                $je = $jeTbl->newEmptyEntity();
                $je->entry_number = $entryNumber;
                $je->entry_date = $br->voucher_date;
                $je->accounting_date = $br->accounting_date;
                $je->description = "Báo Có {$br->voucher_number} - {$br->payer_name}: {$br->reason}";
                $je->total_debit = $br->amount_vnd;
                $je->total_credit = $br->amount_vnd;
                $je->status = 'posted';
                $je->accounting_period_id = $periodId;
                $je->reference_type = 'BankReceipt';
                $je->reference_id = (string)$id;
                $je->created_by = $br->created_by ?? 1;
                $jeTbl->saveOrFail($je);

                // Nợ 1121
                $dr = $jelTbl->newEntity([
                    'journal_entry_id' => $je->id,
                    'chart_of_account_id' => $acc112,
                    'debit' => $br->amount_vnd,
                    'credit' => 0,
                    'description' => $br->reason,
                ]);
                $jelTbl->saveOrFail($dr);

                // Có TK đối ứng
                if ($br->chart_of_account_id) {
                    $cr = $jelTbl->newEntity([
                        'journal_entry_id' => $je->id,
                        'chart_of_account_id' => $br->chart_of_account_id,
                        'debit' => 0,
                        'credit' => $br->amount_vnd,
                        'description' => $br->reason,
                    ]);
                    $jelTbl->saveOrFail($cr);
                }

                return ['status' => 'ok', 'entry_id' => $je->id, 'entry_number' => $entryNumber];
            });
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Giấy báo Nợ / UNC - BN
     * Nợ TK đối ứng / Có 1121
     */
    public function postBankPayment(int $id, bool $force = false): array
    {
        if (!$force && $this->hasPosted('BankPayment', $id)) {
            return ['status' => 'skipped', 'message' => 'Đã hạch toán BN rồi'];
        }
        $tbl = TableRegistry::getTableLocator()->get('BankPayments');
        $bp = $tbl->get($id);
        if ($bp->status !== 'approved') {
            return ['status' => 'error', 'message' => 'Giấy báo Nợ chưa duyệt'];
        }

        $periodId = $this->getPeriodIdByDate($bp->voucher_date->format('Y-m-d'));
        $entryNumber = $this->genEntryNumber('BN', $bp->voucher_date->format('Y-m-d'));

        $bankAccTbl = TableRegistry::getTableLocator()->get('BankAccounts');
        $bankAcc = $bankAccTbl->get($bp->bank_account_id);
        $acc112 = $bankAcc->chart_of_account_id ?? $this->getAccountIdByCode('1121') ?? $this->getAccountIdByCode('112');

        if (!$acc112) {
            return ['status' => 'error', 'message' => 'Thiếu TK 1121'];
        }

        $jeTbl = TableRegistry::getTableLocator()->get('JournalEntries');
        $jelTbl = TableRegistry::getTableLocator()->get('JournalEntryLines');
        $conn = $jeTbl->getConnection();

        try {
            return $conn->transactional(function () use ($jeTbl, $jelTbl, $bp, $periodId, $entryNumber, $acc112, $id) {
                $je = $jeTbl->newEmptyEntity();
                $je->entry_number = $entryNumber;
                $je->entry_date = $bp->voucher_date;
                $je->accounting_date = $bp->accounting_date;
                $je->description = "Báo Nợ {$bp->voucher_number} - {$bp->payee_name}: {$bp->reason}";
                $je->total_debit = $bp->amount_vnd;
                $je->total_credit = $bp->amount_vnd;
                $je->status = 'posted';
                $je->accounting_period_id = $periodId;
                $je->reference_type = 'BankPayment';
                $je->reference_id = (string)$id;
                $je->created_by = $bp->created_by ?? 1;
                $jeTbl->saveOrFail($je);

                // Có 1121
                $cr = $jelTbl->newEntity([
                    'journal_entry_id' => $je->id,
                    'chart_of_account_id' => $acc112,
                    'debit' => 0,
                    'credit' => $bp->amount_vnd,
                    'description' => $bp->reason,
                ]);
                $jelTbl->saveOrFail($cr);

                // Nợ TK đối ứng
                if ($bp->chart_of_account_id) {
                    $dr = $jelTbl->newEntity([
                        'journal_entry_id' => $je->id,
                        'chart_of_account_id' => $bp->chart_of_account_id,
                        'debit' => $bp->amount_vnd,
                        'credit' => 0,
                        'description' => $bp->reason,
                    ]);
                    $jelTbl->saveOrFail($dr);
                }

                return ['status' => 'ok', 'entry_id' => $je->id, 'entry_number' => $entryNumber];
            });
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


    public function postAllMissing(): array
    {
        $results = [];

        $payrollTbl = TableRegistry::getTableLocator()->get('Payrolls');
        $payrolls = $payrollTbl->find()->where(['status IN' => ['approved','paid']])->orderBy(['Payrolls.accounting_period_id' => 'ASC'])->all();
        foreach ($payrolls as $pr) {
            $results[] = ['type' => 'Payroll', 'id' => $pr->id, 'result' => $this->postPayroll($pr->id)];
        }
        
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

        $cashReceiptTbl = TableRegistry::getTableLocator()->get('CashReceipts');
        $crs = $cashReceiptTbl->find()->where(['status' => 'approved'])->all();
        foreach ($crs as $cr) {
            $results[] = ['type' => 'CashReceipt', 'id' => $cr->id, 'result' => $this->postCashReceipt($cr->id)];
        }

        $cashPaymentTbl = TableRegistry::getTableLocator()->get('CashPayments');
        $cps = $cashPaymentTbl->find()->where(['status' => 'approved'])->all();
        foreach ($cps as $cp) {
            $results[] = ['type' => 'CashPayment', 'id' => $cp->id, 'result' => $this->postCashPayment($cp->id)];
        }

        $bankReceiptTbl = TableRegistry::getTableLocator()->get('BankReceipts');
        $brs = $bankReceiptTbl->find()->where(['status' => 'approved'])->all();
        foreach ($brs as $br) {
            $results[] = ['type' => 'BankReceipt', 'id' => $br->id, 'result' => $this->postBankReceipt($br->id)];
        }

        $bankPaymentTbl = TableRegistry::getTableLocator()->get('BankPayments');
        $bps = $bankPaymentTbl->find()->where(['status' => 'approved'])->all();
        foreach ($bps as $bp) {
            $results[] = ['type' => 'BankPayment', 'id' => $bp->id, 'result' => $this->postBankPayment($bp->id)];
        }

        return $results;
    }
}
