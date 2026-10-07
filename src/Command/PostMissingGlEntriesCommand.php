<?php
namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use App\Service\GlPostingService;

class PostMissingGlEntriesCommand extends Command
{
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->addOption('force', [
            'boolean' => true,
            'help' => 'Force re-post even if already posted'
        ]);
        $parser->addOption('type', [
            'default' => 'all',
            'choices' => ['all', 'gr', 'dn', 'pinv', 'sinv', 'payroll', 'cash', 'bank'],
            'help' => 'Loại chứng từ: all, gr, dn, pinv, sinv, payroll, cash (PT/PC), bank (BC/BN)'
        ]);
        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
        $service = new GlPostingService();
        $force = $args->getOption('force') ?? false;
        $type = $args->getOption('type') ?? 'all';

        $io->out('=== Bắt đầu hạch toán các chứng từ chưa vào sổ cái ===');
        $io->out("Loại: $type | Force: " . ($force ? 'YES' : 'NO'));

        if (in_array($type, ['all', 'gr'])) {
            $grTbl = $this->fetchTable('GoodsReceipts');
            $grs = $grTbl->find()->where(['status' => 'approved'])->all();
            $io->out("\n-- Nhập kho (GR) --");
            foreach ($grs as $gr) {
                $res = $service->postGoodsReceipt($gr->id, $force);
                $io->out("GR #{$gr->id} {$gr->gr_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
        }

        if (in_array($type, ['all', 'dn'])) {
            $dnTbl = $this->fetchTable('DeliveryNotes');
            $dns = $dnTbl->find()->where(['status' => 'approved'])->all();
            $io->out("\n-- Xuất kho (DN) --");
            foreach ($dns as $dn) {
                $res = $service->postDeliveryNote($dn->id, $force);
                $io->out("DN #{$dn->id} {$dn->dn_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
        }

        if (in_array($type, ['all', 'pinv'])) {
            $piTbl = $this->fetchTable('PurchaseInvoices');
            $pis = $piTbl->find()->where(['status IN' => ['approved','paid']])->all();
            $io->out("\n-- HĐ Mua (PINV) --");
            foreach ($pis as $pi) {
                $res = $service->postPurchaseInvoice($pi->id, $force);
                $io->out("PINV #{$pi->id} {$pi->invoice_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
        }

        if (in_array($type, ['all', 'sinv'])) {
            $siTbl = $this->fetchTable('SalesInvoices');
            $sis = $siTbl->find()->where(['status IN' => ['approved','paid']])->all();
            $io->out("\n-- HĐ Bán (SINV) --");
            foreach ($sis as $si) {
                $res = $service->postSalesInvoice($si->id, $force);
                $io->out("SINV #{$si->id} {$si->invoice_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
        }

        if (in_array($type, ['all', 'payroll'])) {
            $prTbl = $this->fetchTable('Payrolls');
            $prs = $prTbl->find()->where(['status IN' => ['approved','paid']])->orderBy(['payroll_year' => 'ASC', 'payroll_month' => 'ASC'])->all();
            $io->out("\n-- Bảng lương (Payroll) --");
            foreach ($prs as $pr) {
                $res = $service->postPayroll($pr->id, $force);
                $io->out("PAYROLL #{$pr->id} {$pr->payroll_code}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
        }

        if (in_array($type, ['all', 'cash'])) {
            $io->out("\n-- Vốn bằng tiền mặt (111) --");
            $crTbl = $this->fetchTable('CashReceipts');
            $crs = $crTbl->find()->where(['status' => 'approved'])->all();
            $io->out("Phiếu thu (PT):");
            foreach ($crs as $cr) {
                $res = $service->postCashReceipt($cr->id, $force);
                $io->out("PT #{$cr->id} {$cr->voucher_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
            $cpTbl = $this->fetchTable('CashPayments');
            $cps = $cpTbl->find()->where(['status' => 'approved'])->all();
            $io->out("Phiếu chi (PC):");
            foreach ($cps as $cp) {
                $res = $service->postCashPayment($cp->id, $force);
                $io->out("PC #{$cp->id} {$cp->voucher_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
        }

        if (in_array($type, ['all', 'bank'])) {
            $io->out("\n-- Vốn bằng tiền gửi NH (112) --");
            $brTbl = $this->fetchTable('BankReceipts');
            $brs = $brTbl->find()->where(['status' => 'approved'])->all();
            $io->out("Báo Có (BC):");
            foreach ($brs as $br) {
                $res = $service->postBankReceipt($br->id, $force);
                $io->out("BC #{$br->id} {$br->voucher_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
            $bpTbl = $this->fetchTable('BankPayments');
            $bps = $bpTbl->find()->where(['status' => 'approved'])->all();
            $io->out("Báo Nợ (BN):");
            foreach ($bps as $bp) {
                $res = $service->postBankPayment($bp->id, $force);
                $io->out("BN #{$bp->id} {$bp->voucher_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
        }

        $io->out("\n=== Hoàn tất ===");
        return static::CODE_SUCCESS;
    }
}
