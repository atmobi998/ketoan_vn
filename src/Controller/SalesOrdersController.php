<?php
namespace App\Controller;
use Cake\I18n\FrozenDate;
use Cake\ORM\Query;
use Cake\Database\Expression\QueryExpression;
use Dompdf\Dompdf;
use Cake\I18n\Number;

class SalesOrdersController extends AppController
{
    public function index()
    {
        $session = $this->getRequest()->getSession();
        $periodtbl = $this->fetchTable('AccountingPeriods');
        $options = $periodtbl->find('list',['keyField' => 'code','valueField' => 'name'])->toArray();
        $this->set(compact('options'));
        $from_period = $this->request->getQuery('from_period');
        $to_period = $this->request->getQuery('to_period');
        $today = FrozenDate::today();
        $curperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($today) {return $exp->lte('AccountingPeriods.start_date', $today)->gte('AccountingPeriods.end_date', $today);})->first();
        if (empty($from_period)) {
            $from_period = $session->read('from_period');
        }
        if (empty($to_period)) {
            $to_period = $session->read('to_period');
        }
        if (empty($from_period)) {
            $from_period = $curperiod->code;
        }
        if (empty($to_period)) {
            $to_period = $curperiod->code;
        }
        $session->write('from_period', $from_period);
        $session->write('to_period', $to_period);
        $this->set(compact('from_period','to_period'));

        $fromperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($from_period) {return $exp->eq('AccountingPeriods.code', $from_period);})->first();
        $toperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($to_period) {return $exp->eq('AccountingPeriods.code', $to_period);})->first();
        
        $table = $this->fetchTable('SalesOrders');
        $query = $table->find()->where(function (QueryExpression $exp, Query $q) use ($fromperiod, $toperiod) {return $exp->between('SalesOrders.order_date', $fromperiod->start_date, $toperiod->end_date, 'datetime');});
        $contains = [];
        foreach ($table->associations() as $assoc) {
            if ($assoc->type() === 'manyToOne') {
                $contains[] = $assoc->getName();
            }
        }
        if (!empty($contains)) {
            $query->contain($contains);
        }
        $records = $this->paginate($query,['limit' => 250, 'maxLimit' => 500]);
        $this->set(compact('records'));
    }

    public function view($id = null)
    {
        $table = $this->fetchTable('SalesOrders');
        $contains = [];
        foreach ($table->associations() as $assoc) {
            $contains[] = $assoc->getName();
        }
        $record = $table->get($id, contain: $contains);
        $this->set(compact('record'));

        $table = $this->fetchTable('SalesOrderDetails');
        $query = $table->find()->where(['SalesOrderDetails.sales_order_id' => $id]);
        $contains = [];
        foreach ($table->associations() as $assoc) {
            if ($assoc->type() === 'manyToOne') {
                $contains[] = $assoc->getName();
            }
        }
        if (!empty($contains)) {
            $query->contain($contains);
        }
        $records = $query->all();
        $recnbr = 0;
        $tmprec=[];
        foreach ($records as $reck => $rec) {
            $tmprec[$recnbr] = ['No.' => $recnbr+1,
                                'sales_order'=>$rec->sales_order->so_number,
                                'product'=>$rec->product->full_name,
                                'quantity'=>$rec->quantity.' '.$rec->unit->name,
                                'unit_price'=>Number::format($rec->unit_price),
                                'vat_rate'=>$rec->vat_rate,
                                'vat_amount'=>Number::format($rec->vat_amount),
                                'amount'=>Number::format($rec->amount),
                                ];
            $recnbr++;
        }
        $records=$tmprec;
        $file = $this->exportGR('sales_orders', $records, $record);
        return $this->response->withFile($file, ['download' => true, 'name' => 'sales_orders_'.date('Ymd').'.pdf']);
        
    }

    public function exportGR(string $tableName, array $records, \Cake\Datasource\EntityInterface $record): string
    {
        $html = '<html>
    <head><meta charset="utf-8">
        <style>
            body {font-family: "DejaVu Sans", sans-serif;font-size: 14px;}
            h2 {font-family: "DejaVu Sans", sans-serif;font-weight: bold;font-size: 16px;}
        </style>
    </head>
    <body><h2 style="text-align:center">Đơn bán hàng</h2>';
        $html .= '<table cellpadding="5" cellspacing="5"><tr><td>Ngày bán: ' . $record->order_date->format('d/m/Y') . '</td>';
        $html .= '<td>Khách hàng: '.$record->customer->name.'</td></tr>';
        $html .= '<tr>';
        $html .= '<td colspan="2">Tổng cộng: <b>'.Number::format($record->grand_total).'</b> VNĐ</td></tr></table>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse:collapse; font-size:12px;text-align:right;">';
        if (empty($records)) {
            $html .= '<tr><td>Khong co du lieu</td></tr>';
        } else {
            $first = $records[0];
            if (is_object($first)) $first = $first->toArray();
            $headers = array_keys($first);
            $html .= '<tr>'; foreach ($headers as $h) $html .= '<th>' . htmlspecialchars($h) . '</th>'; $html .= '</tr>';
            foreach ($records as $rec) {
                if (is_object($rec)) $rec = $rec->toArray();
                $html .= '<tr>';
                foreach ($headers as $h) {
                    $val = $rec[$h] ?? '';
                    if ($val instanceof \DateTimeInterface) $val = $val->format('Y-m-d');
                    $html .= '<td>' . htmlspecialchars((string)$val) . '</td>';
                }
                $html .= '</tr>';
            }
        }
        $html .= '</table></body></html>';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $tmpDir = sys_get_temp_dir();
        $file = $tmpDir . DIRECTORY_SEPARATOR . $tableName . '_' . date('Ymd_His') . '.pdf';
        file_put_contents($file, $dompdf->output());
        return $file;
    }

    public function add()
    {
        $table = $this->fetchTable('SalesOrders');
        $record = $table->newEmptyEntity();
        if ($this->request->is('post')) {
            $record = $table->patchEntity($record, $this->request->getData());
            if ($table->save($record)) {
                $this->Flash->success('Đã lưu thành công.');
                return $this->redirect(['action' => 'edit',$record->id]);
            }
            $this->Flash->error('Lưu thất bại.');
        }
        $related = [];
        foreach ($table->associations() as $assoc) {
            if ($assoc->type() === 'manyToOne') {
                $rt = $this->fetchTable($assoc->getName());
                try {
                    $related[$assoc->getName()] = $rt->find('list', limit: 500)->toArray();
                } catch (\Exception $e) {
                    $related[$assoc->getName()] = [];
                }
            }
        }
        $this->set(compact('record', 'related'));
    }

    public function adddetail($id_master)
    {
        $table = $this->fetchTable('SalesOrderDetails');
        $record = $table->newEmptyEntity();
        if ($this->request->is('post')) {
            $record = $table->patchEntity($record, $this->request->getData());
            if ($table->save($record)) {

                $mtable = $this->fetchTable('SalesOrders');
                $mdata = $mtable->get($id_master);
                $dtable = $this->fetchTable('SalesOrderDetails');
                $dquery = $table->find()->where(['SalesOrderDetails.sales_order_id' => $id_master])->all();
                $total_amount=0;
                $vat_amount=0;
                $discount_amount=$mdata->discount_amount;
                $grand_total=0;
                foreach ($dquery as $det) {
                    $total_amount+=$det->amount;
                    $vat_amount+=$det->vat_amount;
                    $grand_total+=($total_amount+$vat_amount);
                }
                $mdata->total_amount=$total_amount;
                $mdata->vat_amount=$vat_amount;
                $mdata->grand_total=$grand_total-$discount_amount;
                $mtable->save($mdata);

                $this->Flash->success('Đã lưu thành công.');
                return $this->redirect(['action' => 'edit',$id_master]);
            }
            $this->Flash->error('Lưu thất bại.');
        }
        $related = [];
        foreach ($table->associations() as $assoc) {
            if ($assoc->type() === 'manyToOne') {
                $rt = $this->fetchTable($assoc->getName());
                try {
                    $related[$assoc->getName()] = $rt->find('list', limit: 500)->toArray();
                } catch (\Exception $e) {
                    $related[$assoc->getName()] = [];
                }
            }
        }
        $this->set(compact('record', 'related', 'id_master'));
        
    }


    public function edit($id = null)
    {
        $table = $this->fetchTable('SalesOrders');
        $record = $table->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $record = $table->patchEntity($record, $this->request->getData());
            if ($table->save($record)) {
                $this->Flash->success('Đã cập nhật.');
                return $this->redirect(['action' => 'edit',$id]);
            }
            $this->Flash->error('Cập nhật thất bại.');
        }
        $related = [];
        foreach ($table->associations() as $assoc) {
            if ($assoc->type() === 'manyToOne') {
                $rt = $this->fetchTable($assoc->getName());
                try {
                    $related[$assoc->getName()] = $rt->find('list', limit: 500)->toArray();
                } catch (\Exception $e) {
                    $related[$assoc->getName()] = [];
                }
            }
        }
        $this->set(compact('record', 'related'));

        $table = $this->fetchTable('SalesOrderDetails');
        $query = $table->find()->where(['SalesOrderDetails.sales_order_id' => $id]);
        $contains = [];
        foreach ($table->associations() as $assoc) {
            if ($assoc->type() === 'manyToOne') {
                $contains[] = $assoc->getName();
            }
        }
        if (!empty($contains)) {
            $query->contain($contains);
        }
        $records = $this->paginate($query,['limit' => 250, 'maxLimit' => 500]);
        $this->set(compact('records'));
        
    }

    public function editdetail($id = null)
    {
        $table = $this->fetchTable('SalesOrderDetails');
        $record = $table->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $record = $table->patchEntity($record, $this->request->getData());
            if ($table->save($record)) {

                $mtable = $this->fetchTable('SalesOrders');
                $mdata = $mtable->get($record->sales_order_id);
                $dtable = $this->fetchTable('SalesOrderDetails');
                $dquery = $table->find()->where(['SalesOrderDetails.sales_order_id' => $record->sales_order_id])->all();
                $total_amount=0;
                $vat_amount=0;
                $discount_amount=$mdata->discount_amount;
                $grand_total=0;
                foreach ($dquery as $det) {
                    $total_amount+=$det->amount;
                    $vat_amount+=$det->vat_amount;
                    $grand_total+=($det->amount+$det->vat_amount);
                }
                $mdata->total_amount=$total_amount;
                $mdata->vat_amount=$vat_amount;
                $mdata->grand_total=$grand_total-$discount_amount;
                $mtable->save($mdata);
            
                $this->Flash->success('Đã cập nhật.');
                return $this->redirect(['action' => 'edit',$record->sales_order_id]);
            }
            $this->Flash->error('Cập nhật thất bại.');
        }
        $related = [];
        foreach ($table->associations() as $assoc) {
            if ($assoc->type() === 'manyToOne') {
                $rt = $this->fetchTable($assoc->getName());
                try {
                    $related[$assoc->getName()] = $rt->find('list', limit: 500)->toArray();
                } catch (\Exception $e) {
                    $related[$assoc->getName()] = [];
                }
            }
        }
        $this->set(compact('record', 'related'));
        
    }


    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $table = $this->fetchTable('SalesOrders');
        $record = $table->get($id);
        if ($table->delete($record)) {
            $this->Flash->success('Đã xóa.');
        } else {
            $this->Flash->error('Xóa thất bại.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function deletedetail($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $table = $this->fetchTable('SalesOrderDetails');
        $record = $table->get($id);
        if ($table->delete($record)) {
            $this->Flash->success('Đã xóa.');
        } else {
            $this->Flash->error('Xóa thất bại.');
        }
        return $this->redirect(['action' => 'edit',$record->sales_order_id]);
    }

    public function exportExcel()
    {
        $table = $this->fetchTable('SalesOrders');
        $records = $table->find()->toArray();
        $service = new \App\Service\ExcelExportService();
        $file = $service->export('sales_orders', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'sales_orders_'.date('Ymd').'.xlsx']);
    }

    public function exportPdf()
    {
        $table = $this->fetchTable('SalesOrders');
        $records = $table->find()->toArray();
        $service = new \App\Service\PdfExportService();
        $file = $service->export('sales_orders', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'sales_orders_'.date('Ymd').'.pdf']);
    }
}
