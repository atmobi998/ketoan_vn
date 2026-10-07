<?php
namespace App\Controller;
class DashboardController extends AppController
{
    public function index()
    {
        $stats = [];
        try {
            $tables = ['Users','Employees','Departments','Suppliers','Customers','Products','PurchaseOrders','SalesOrders','JournalEntries','Payrolls','FixedAssets','JournalEntries'];
            foreach ($tables as $t) {
                $tbl = $this->fetchTable($t);
                $stats[$t] = $tbl->find()->count();
            }
        } catch (\Exception $e) { $stats['error'] = $e->getMessage(); }
        $totalSupplierDebt = 0;
        $totalCustomerDebt = 0;
        try {
            $sd = $this->fetchTable('SupplierDebts')->find()->select(['total' => 'SUM(remaining_amount)'])->first();
            $totalSupplierDebt = $sd->total ?? 0;
            $cd = $this->fetchTable('CustomerDebts')->find()->select(['total' => 'SUM(remaining_amount)'])->first();
            $totalCustomerDebt = $cd->total ?? 0;
        } catch (\Exception $e) {}
        $this->set(compact('stats','totalSupplierDebt','totalCustomerDebt'));
    }
}
