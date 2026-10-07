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
        $crTbl = $this->fetchTable('CashReceipts');
        $cpTbl = $this->fetchTable('CashPayments');
        $brTbl = $this->fetchTable('BankReceipts');
        $bpTbl = $this->fetchTable('BankPayments');
        $jeTbl = $this->fetchTable('JournalEntries');

        // Chưa hạch toán - dùng NOT IN subquery cho CakePHP 5
        $grPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'GoodsReceipt']);
        $grUnposted = $grTbl->find()->where(['GoodsReceipts.status' => 'approved', 'GoodsReceipts.id NOT IN' => $grPostedIds])->count();

        $dnPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'DeliveryNote']);
        $dnUnposted = $dnTbl->find()->where(['DeliveryNotes.status' => 'approved', 'DeliveryNotes.id NOT IN' => $dnPostedIds])->count();

        $piPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'PurchaseInvoice']);
        $piUnposted = $piTbl->find()->where(['PurchaseInvoices.status IN' => ['approved','paid'], 'PurchaseInvoices.id NOT IN' => $piPostedIds])->count();

        $siPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'SalesInvoice']);
        $siUnposted = $siTbl->find()->where(['SalesInvoices.status IN' => ['approved','paid'], 'SalesInvoices.id NOT IN' => $siPostedIds])->count();

        $prPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'Payroll']);
        $prUnposted = $prTbl->find()->where(['Payrolls.status IN' => ['approved','paid'], 'Payrolls.id NOT IN' => $prPostedIds])->count();

        $crPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'CashReceipt']);
        $crUnposted = $crTbl->find()->where(['CashReceipts.status' => 'approved', 'CashReceipts.id NOT IN' => $crPostedIds])->count();

        $cpPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'CashPayment']);
        $cpUnposted = $cpTbl->find()->where(['CashPayments.status' => 'approved', 'CashPayments.id NOT IN' => $cpPostedIds])->count();

        $brPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'BankReceipt']);
        $brUnposted = $brTbl->find()->where(['BankReceipts.status' => 'approved', 'BankReceipts.id NOT IN' => $brPostedIds])->count();

        $bpPostedIds = $jeTbl->find()->select(['reference_id'])->where(['reference_type' => 'BankPayment']);
        $bpUnposted = $bpTbl->find()->where(['BankPayments.status' => 'approved', 'BankPayments.id NOT IN' => $bpPostedIds])->count();

        // Tổng đã hạch toán
        $postedCounts = [
            'GoodsReceipt' => $jeTbl->find()->where(['reference_type' => 'GoodsReceipt'])->count(),
            'DeliveryNote' => $jeTbl->find()->where(['reference_type' => 'DeliveryNote'])->count(),
            'PurchaseInvoice' => $jeTbl->find()->where(['reference_type' => 'PurchaseInvoice'])->count(),
            'SalesInvoice' => $jeTbl->find()->where(['reference_type' => 'SalesInvoice'])->count(),
            'Payroll' => $jeTbl->find()->where(['reference_type' => 'Payroll'])->count(),
            'CashReceipt' => $jeTbl->find()->where(['reference_type' => 'CashReceipt'])->count(),
            'CashPayment' => $jeTbl->find()->where(['reference_type' => 'CashPayment'])->count(),
            'BankReceipt' => $jeTbl->find()->where(['reference_type' => 'BankReceipt'])->count(),
            'BankPayment' => $jeTbl->find()->where(['reference_type' => 'BankPayment'])->count(),
        ];

        $recentEntries = $jeTbl->find()->orderBy(['JournalEntries.created' => 'DESC'])->limit(20)->toArray();

        // Tổng tiền chưa HT
        $grTotalQuery = $grTbl->find()->where(['GoodsReceipts.status' => 'approved', 'GoodsReceipts.id NOT IN' => $grPostedIds]);
        $grTotal = $grTotalQuery->select(['total' => $grTotalQuery->func()->sum('GoodsReceipts.grand_total')])->first();

        $dnTotalQuery = $dnTbl->find()->where(['DeliveryNotes.status' => 'approved', 'DeliveryNotes.id NOT IN' => $dnPostedIds]);
        $dnTotal = $dnTotalQuery->select(['total' => $dnTotalQuery->func()->sum('DeliveryNotes.total_amount')])->first();

        $prTotalQuery = $prTbl->find()->where(['Payrolls.status IN' => ['approved','paid'], 'Payrolls.id NOT IN' => $prPostedIds]);
        $prTotal = $prTotalQuery->select(['total' => $prTotalQuery->func()->sum('Payrolls.total_amount')])->first();

        $crTotalQuery = $crTbl->find()->where(['CashReceipts.status' => 'approved', 'CashReceipts.id NOT IN' => $crPostedIds]);
        $crTotal = $crTotalQuery->select(['total' => $crTotalQuery->func()->sum('CashReceipts.amount_vnd')])->first();

        $cpTotalQuery = $cpTbl->find()->where(['CashPayments.status' => 'approved', 'CashPayments.id NOT IN' => $cpPostedIds]);
        $cpTotal = $cpTotalQuery->select(['total' => $cpTotalQuery->func()->sum('CashPayments.amount_vnd')])->first();

        $brTotalQuery = $brTbl->find()->where(['BankReceipts.status' => 'approved', 'BankReceipts.id NOT IN' => $brPostedIds]);
        $brTotal = $brTotalQuery->select(['total' => $brTotalQuery->func()->sum('BankReceipts.amount_vnd')])->first();

        $bpTotalQuery = $bpTbl->find()->where(['BankPayments.status' => 'approved', 'BankPayments.id NOT IN' => $bpPostedIds]);
        $bpTotal = $bpTotalQuery->select(['total' => $bpTotalQuery->func()->sum('BankPayments.amount_vnd')])->first();

        $totalUnposted = $grUnposted + $dnUnposted + $piUnposted + $siUnposted + $prUnposted + $crUnposted + $cpUnposted + $brUnposted + $bpUnposted;

        $this->set(compact('grUnposted','dnUnposted','piUnposted','siUnposted','prUnposted','crUnposted','cpUnposted','brUnposted','bpUnposted','totalUnposted','postedCounts','recentEntries','grTotal','dnTotal','prTotal','crTotal','cpTotal','brTotal','bpTotal'));
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
            $msg .= " Lỗi: " . implode('; ', array_slice($errors, 0, 5));
            if (count($errors) > 5) $msg .= " và " . (count($errors)-5) . " lỗi khác...";
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
