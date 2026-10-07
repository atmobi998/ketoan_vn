<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Service\GlPostingService;

class GlStatusController extends AppController
{
    public function index()
    {
        $grTbl = $this->fetchTable('GoodsReceipts');
        $dnTbl = $this->fetchTable('DeliveryNotes');
        $piTbl = $this->fetchTable('PurchaseInvoices');
        $siTbl = $this->fetchTable('SalesInvoices');
        $prTbl = $this->fetchTable('Payrolls');
        $jeTbl = $this->fetchTable('JournalEntries');

        $grPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'GoodsReceipt']);
        $grUnposted = $grTbl->find()->where(['GoodsReceipts.status' => 'approved', 'GoodsReceipts.id NOT IN' => $grPostedIds])->count();

        $dnPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'DeliveryNote_COGS']);
        $dnUnposted = $dnTbl->find()->where(['DeliveryNotes.status' => 'approved', 'DeliveryNotes.id NOT IN' => $dnPostedIds])->count();

        $piPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'PurchaseInvoice']);
        $piUnposted = $piTbl->find()->where(['PurchaseInvoices.status IN' => ['approved','paid'], 'PurchaseInvoices.id NOT IN' => $piPostedIds])->count();

        $siPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'SalesInvoice']);
        $siUnposted = $siTbl->find()->where(['SalesInvoices.status IN' => ['approved','paid'], 'SalesInvoices.id NOT IN' => $siPostedIds])->count();

        $prPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'Payroll']);
        $prUnposted = $prTbl->find()->where(['Payrolls.status IN' => ['approved','paid'], 'Payrolls.id NOT IN' => $prPostedIds])->count();

        $postedCounts = [
            'GoodsReceipt' => $jeTbl->find()->where(['reference_type' => 'GoodsReceipt'])->count(),
            'DeliveryNote_COGS' => $jeTbl->find()->where(['reference_type' => 'DeliveryNote_COGS'])->count(),
            'PurchaseInvoice' => $jeTbl->find()->where(['reference_type' => 'PurchaseInvoice'])->count(),
            'SalesInvoice' => $jeTbl->find()->where(['reference_type' => 'SalesInvoice'])->count(),
            'Payroll' => $jeTbl->find()->where(['reference_type' => 'Payroll'])->count(),
        ];

        $recentEntries = $jeTbl->find()->orderBy(['JournalEntries.created' => 'DESC'])->limit(15)->toArray();

        $grTotalQuery = $grTbl->find()->where(['GoodsReceipts.status' => 'approved', 'GoodsReceipts.id NOT IN' => $grPostedIds]);
        $grTotal = $grTotalQuery->select(['total' => $grTotalQuery->func()->sum('GoodsReceipts.grand_total')])->first();

        $dnTotalQuery = $dnTbl->find()->where(['DeliveryNotes.status' => 'approved', 'DeliveryNotes.id NOT IN' => $dnPostedIds]);
        $dnTotal = $dnTotalQuery->select(['total' => $dnTotalQuery->func()->sum('DeliveryNotes.total_amount')])->first();

        $prTotalQuery = $prTbl->find()->where(['Payrolls.status IN' => ['approved','paid'], 'Payrolls.id NOT IN' => $prPostedIds]);
        $prTotal = $prTotalQuery->select(['total' => $prTotalQuery->func()->sum('Payrolls.total_amount')])->first();

        $this->set(compact('grUnposted','dnUnposted','piUnposted','siUnposted','prUnposted','postedCounts','recentEntries','grTotal','dnTotal','prTotal'));
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

    public function postPayrollMonth()
    {
        $this->request->allowMethod(['post']);
        $month = (int)$this->request->getData('month', date('n'));
        $year = (int)$this->request->getData('year', date('Y'));
        
        $service = new GlPostingService();
        $result = $service->postPayrollMonth($month, $year, false);
        
        if ($result['status'] === 'ok') {
            $this->Flash->success($result['message']);
        } else {
            $this->Flash->error($result['message']);
        }
        return $this->redirect(['action' => 'index']);
    }
}
