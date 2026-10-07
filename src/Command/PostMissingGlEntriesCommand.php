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
            'choices' => ['all', 'gr', 'dn', 'pinv', 'sinv', 'payroll'],
            'help' => 'Loại chứng từ cần hạch toán: all, gr, dn, pinv, sinv, payroll'
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

        // 5. Payrolls - Bảng lương (MỚI)
        if (in_array($type, ['all', 'payroll'])) {
            $prTbl = $this->fetchTable('Payrolls');
            $prs = $prTbl->find()->where(['status IN' => ['approved','paid']])->orderBy(['Payrolls.accounting_period_id' => 'ASC'])->all();
            $io->out("\n-- Bảng lương (Payroll) --");
            $io->out("Định khoản: Nợ 622/627/641/642 / Có 334, 3383, 3384, 3386, 3335");
            foreach ($prs as $pr) {
                $res = $service->postPayroll($pr->id, $force);
                $io->out("PAYROLL #{$pr->id} {$pr->payroll_code} (T{$pr->payroll_month}/{$pr->payroll_year} - Dept {$pr->department_id}): {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
        }

        // 1. Goods Receipts - Nhập kho
        if (in_array($type, ['all', 'gr'])) {
            $grTbl = $this->fetchTable('GoodsReceipts');
            $grs = $grTbl->find()->where(['status' => 'approved'])->all();
            $io->out("\n-- Phiếu nhập kho (GR) --");
            foreach ($grs as $gr) {
                $res = $service->postGoodsReceipt($gr->id, $force);
                $io->out("GR #{$gr->id} {$gr->gr_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
        }

        // 2. Delivery Notes - Xuất kho giá vốn
        if (in_array($type, ['all', 'dn'])) {
            $dnTbl = $this->fetchTable('DeliveryNotes');
            $dns = $dnTbl->find()->where(['status' => 'approved'])->all();
            $io->out("\n-- Phiếu xuất kho (DN) - Giá vốn --");
            foreach ($dns as $dn) {
                $res = $service->postDeliveryNote($dn->id, $force);
                $io->out("DN #{$dn->id} {$dn->dn_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
        }

        // 3. Purchase Invoices - Mua hàng
        if (in_array($type, ['all', 'pinv'])) {
            $piTbl = $this->fetchTable('PurchaseInvoices');
            $pis = $piTbl->find()->where(['status IN' => ['approved','paid']])->all();
            $io->out("\n-- Hóa đơn mua hàng (PINV) --");
            foreach ($pis as $pi) {
                $res = $service->postPurchaseInvoice($pi->id, $force);
                $io->out("PINV #{$pi->id} {$pi->invoice_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
        }

        // 4. Sales Invoices - Bán hàng
        if (in_array($type, ['all', 'sinv'])) {
            $siTbl = $this->fetchTable('SalesInvoices');
            $sis = $siTbl->find()->where(['status IN' => ['approved','paid']])->all();
            $io->out("\n-- Hóa đơn bán hàng (SINV) - Doanh thu --");
            foreach ($sis as $si) {
                $res = $service->postSalesInvoice($si->id, $force);
                $io->out("SINV #{$si->id} {$si->invoice_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
            }
        }

        $io->out("\n=== Hoàn tất ===");
        $io->out("Kiểm tra sổ cái: SELECT * FROM journal_entries ORDER BY id DESC LIMIT 10;");
        return static::CODE_SUCCESS;
    }
}
