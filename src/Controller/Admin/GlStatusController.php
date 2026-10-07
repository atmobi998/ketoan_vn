<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Service\GlPostingService;
use Cake\ORM\TableRegistry;

class GlStatusController extends AppController
{
    public function index()
    {
        $grTbl = $this->fetchTable('GoodsReceipts');
        $dnTbl = $this->fetchTable('DeliveryNotes');
        $piTbl = $this->fetchTable('PurchaseInvoices');
        $siTbl = $this->fetchTable('SalesInvoices');
        $jeTbl = $this->fetchTable('JournalEntries');

        // Đếm chưa hạch toán - dùng NOT IN subquery (tương thích CakePHP 5)
        $grPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'GoodsReceipt']);
        $grUnposted = $grTbl->find()->where(['GoodsReceipts.status' => 'approved', 'GoodsReceipts.id NOT IN' => $grPostedIds])->count();

        $dnPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'DeliveryNote']);
        $dnUnposted = $dnTbl->find()->where(['DeliveryNotes.status' => 'approved', 'DeliveryNotes.id NOT IN' => $dnPostedIds])->count();

        $piPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'PurchaseInvoice']);
        $piUnposted = $piTbl->find()->where(['PurchaseInvoices.status IN' => ['approved','paid'], 'PurchaseInvoices.id NOT IN' => $piPostedIds])->count();

        $siPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'SalesInvoice']);
        $siUnposted = $siTbl->find()->where(['SalesInvoices.status IN' => ['approved','paid'], 'SalesInvoices.id NOT IN' => $siPostedIds])->count();

        // Tổng đã hạch toán
        $postedCounts = [
            'GoodsReceipt' => $jeTbl->find()->where(['reference_type' => 'GoodsReceipt'])->count(),
            'DeliveryNote' => $jeTbl->find()->where(['reference_type' => 'DeliveryNote'])->count(),
            'PurchaseInvoice' => $jeTbl->find()->where(['reference_type' => 'PurchaseInvoice'])->count(),
            'SalesInvoice' => $jeTbl->find()->where(['reference_type' => 'SalesInvoice'])->count(),
        ];

        // 10 bút toán gần nhất
        $recentEntries = $jeTbl->find()
            ->orderBy(['JournalEntries.created' => 'DESC'])
            ->limit(10)
            ->toArray();

        // Thống kê tổng tiền chưa hạch toán (đơn giản: sum tất cả approved, trừ đi đã post sẽ tính sau)
        $grTotalQuery = $grTbl->find()->where(['GoodsReceipts.status' => 'approved', 'GoodsReceipts.id NOT IN' => $grPostedIds]);
        $grTotal = $grTotalQuery->select(['total' => $grTotalQuery->func()->sum('GoodsReceipts.grand_total')])->first();

        $dnTotalQuery = $dnTbl->find()->where(['DeliveryNotes.status' => 'approved', 'DeliveryNotes.id NOT IN' => $dnPostedIds]);
        $dnTotal = $dnTotalQuery->select(['total' => $dnTotalQuery->func()->sum('DeliveryNotes.total_amount')])->first();

        $this->set(compact('grUnposted','dnUnposted','piUnposted','siUnposted','postedCounts','recentEntries','grTotal','dnTotal'));
    }

    public function postAll()
    {
        $this->request->allowMethod(['post']);
        $service = new GlPostingService();
        $results = $service->postAllMissing();

        $success = 0;
        $skipped = 0;
        $errors = [];
        foreach ($results as $r) {
            if ($r['result']['status'] === 'ok') $success++;
            elseif ($r['result']['status'] === 'skipped') $skipped++;
            else $errors[] = $r['type'].'#'.$r['id'].': '.$r['result']['message'];
        }

        $msg = "Đã hạch toán thành công $success chứng từ, bỏ qua $skipped (đã hạch toán rồi).";
        if (!empty($errors)) {
            $msg .= " Lỗi: " . implode('; ', $errors);
            $this->Flash->error($msg);
        } else {
            $this->Flash->success($msg);
        }

        return $this->redirect(['action' => 'index']);
    }
}
