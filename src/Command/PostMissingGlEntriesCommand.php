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
        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
        $service = new GlPostingService();
        $force = $args->getOption('force') ?? false;

        $io->out('=== Bắt đầu hạch toán các chứng từ chưa vào sổ cái ===');

        $grTbl = $this->fetchTable('GoodsReceipts');
        $grs = $grTbl->find()->where(['status' => 'approved'])->all();
        foreach ($grs as $gr) {
            $res = $service->postGoodsReceipt($gr->id, $force);
            $io->out("GR #{$gr->id} {$gr->gr_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
        }

        $dnTbl = $this->fetchTable('DeliveryNotes');
        $dns = $dnTbl->find()->where(['status' => 'approved'])->all();
        foreach ($dns as $dn) {
            $res = $service->postDeliveryNote($dn->id, $force);
            $io->out("DN #{$dn->id} {$dn->dn_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
        }

        $piTbl = $this->fetchTable('PurchaseInvoices');
        $pis = $piTbl->find()->where(['status IN' => ['approved','paid']])->all();
        foreach ($pis as $pi) {
            $res = $service->postPurchaseInvoice($pi->id, $force);
            $io->out("PINV #{$pi->id} {$pi->invoice_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
        }

        $siTbl = $this->fetchTable('SalesInvoices');
        $sis = $siTbl->find()->where(['status IN' => ['approved','paid']])->all();
        foreach ($sis as $si) {
            $res = $service->postSalesInvoice($si->id, $force);
            $io->out("SINV #{$si->id} {$si->invoice_number}: {$res['status']} - ".($res['message'] ?? $res['entry_number'] ?? ''));
        }

        $io->out('=== Hoàn tất ===');
        return static::CODE_SUCCESS;
    }
}
