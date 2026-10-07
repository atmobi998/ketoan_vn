<?php
namespace App\Controller;
use Cake\I18n\FrozenDate;
use Cake\ORM\Query;
use Cake\Database\Expression\QueryExpression;
use Dompdf\Dompdf;
use Cake\I18n\Number;
use Cake\I18n\FrozenTime;

class DeliveryNotesController extends AppController
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
    
        $table = $this->fetchTable('DeliveryNotes');
        $query = $table->find()->where(function (QueryExpression $exp, Query $q) use ($fromperiod, $toperiod) {return $exp->between('DeliveryNotes.delivery_date', $fromperiod->start_date, $toperiod->end_date, 'datetime');});
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
        $table = $this->fetchTable('DeliveryNotes');
        $contains = [];
        foreach ($table->associations() as $assoc) {
            $contains[] = $assoc->getName();
        }
        $record = $table->get($id, contain: $contains);
        $this->set(compact('record'));

        $table = $this->fetchTable('DeliveryNoteDetails');
        $query = $table->find()->where(['DeliveryNoteDetails.delivery_note_id' => $id]);
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
                                'delivery_note'=>$rec->delivery_note->dn_number,
                                'product'=>$rec->product->full_name,
                                'quantity'=>$rec->quantity.' '.$rec->unit->name,
                                'unit_price'=>Number::format($rec->unit_price),
                                'vat_rate'=>$rec->vat_rate,
                                'vat_amount'=>Number::format($rec->vat_amount),
                                'amount'=>Number::format($rec->amount),
                                'lot_number'=>$rec->lot_number,
                                ];
            $recnbr++;
        }
        $records=$tmprec;
        $file = $this->exportDN('goods_receipts', $records, $record);
        return $this->response->withFile($file, ['download' => true, 'name' => 'delivery_notes_'.date('Ymd').'.pdf']);
        
    }

    public function exportDN(string $tableName, array $records, \Cake\Datasource\EntityInterface $record): string
    {
        $html = '<html>
    <head><meta charset="utf-8">
        <style>
            body {font-family: "DejaVu Sans", sans-serif;font-size: 14px;}
            h2 {font-family: "DejaVu Sans", sans-serif;font-weight: bold;font-size: 16px;}
        </style>
    </head>
    <body><h2 style="text-align:center">Phiếu Xuất</h2>';
        $html .= '<table cellpadding="5" cellspacing="5"><tr><td>Ngày xuất: ' . $record->delivery_date->format('d/m/Y') . '</td>';
        $html .= '<td>KH: '.$record->customer->name.'</td></tr>';
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
        $table = $this->fetchTable('DeliveryNotes');
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
        $table = $this->fetchTable('DeliveryNoteDetails');
        $record = $table->newEmptyEntity();
        if ($this->request->is('post')) {
            $record = $table->patchEntity($record, $this->request->getData());
            if ($table->save($record)) {

                $mtable = $this->fetchTable('DeliveryNotes');
                $mdata = $mtable->get($id_master);
                $dtable = $this->fetchTable('DeliveryNoteDetails');
                $dquery = $table->find()->where(['DeliveryNoteDetails.delivery_note_id' => $id_master])->all();
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
                $mdata->grand_total=($total_amount+$vat_amount)-$discount_amount;
                $mtable->save($mdata);
            
                $this->Flash->success('Đã lưu thành công.');
                return $this->redirect(['action' => 'edit',$record->delivery_note_id]);
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
        $this->set(compact('record', 'related','id_master'));
    }

    public function edit($id = null)
    {
        $table = $this->fetchTable('DeliveryNotes');
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

        $warehouse_id=$record->warehouse_id ?? 0;
        $dettable = $this->fetchTable('DeliveryNoteDetails');
        $detrecs = $dettable->find()->where(['DeliveryNoteDetails.delivery_note_id' => $id])->all();
        foreach ($detrecs as $rec) {
            $product_id=$rec->product_id ?? 0;
            $invtab = $this->fetchTable('Inventories');
            $invrec = $invtab->find()->where(['Inventories.warehouse_id' => $warehouse_id,'Inventories.product_id' => $product_id])->first();
            if (!$invrec) {
                $invrec = $invtab->newEmptyEntity();
                $invrec->warehouse_id=$warehouse_id;
                $invrec->product_id=$product_id;
                $invrec->quantity=0;
            }
            if ($rec->sync_inv < 1) {
                $invrec->quantity -= $rec->quantity;
                $invrec->last_import_price = $rec->unit_price;
                $invrec->average_price = $rec->unit_price;
                $invrec->unit_id = $rec->unit_id;
                $invrec->last_updated = FrozenTime::now();
                $invrec->quantity_available = $invrec->quantity-$invrec->quantity_reserved;
                if ($invtab->save($invrec)) {
                    $rec->sync_inv=1;
                    $dettable->save($rec);
                }
            }
        }


        $table = $this->fetchTable('DeliveryNoteDetails');
        $query = $table->find()->where(['DeliveryNoteDetails.delivery_note_id' => $id]);
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
        $table = $this->fetchTable('DeliveryNoteDetails');
        $record = $table->get($id);
        $bkrec = $table->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $record = $table->patchEntity($record, $this->request->getData());
            if ($table->save($record)) {

                $mtable = $this->fetchTable('DeliveryNotes');
                $mdata = $mtable->get($record->delivery_note_id);
                $product_id=$record->product_id ?? 0;
                $warehouse_id=$mdata->warehouse_id ?? 0;
                $invtab = $this->fetchTable('Inventories');
                $invrec = $invtab->find()->where(['Inventories.warehouse_id' => $warehouse_id,'Inventories.product_id' => $product_id])->first();
                if ($record->quantity > $bkrec->quantity) {
                    $invrec->quantity -= ($record->quantity-$bkrec->quantity);
                    $invrec->quantity_available -= ($record->quantity-$bkrec->quantity);
                } else {
                    $invrec->quantity += ($bkrec->quantity-$record->quantity);
                    $invrec->quantity_available += ($bkrec->quantity-$record->quantity);
                }
                $invtab->save($invrec);
            
                $mtable = $this->fetchTable('DeliveryNotes');
                $mdata = $mtable->get($record->delivery_note_id);
                $dtable = $this->fetchTable('DeliveryNoteDetails');
                $dquery = $table->find()->where(['DeliveryNoteDetails.delivery_note_id' => $record->delivery_note_id])->all();
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
                $mdata->grand_total=($total_amount+$vat_amount)-$discount_amount;
                $mtable->save($mdata);
            
                $this->Flash->success('Đã cập nhật.');
                return $this->redirect(['action' => 'edit',$record->delivery_note_id]);
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
        $table = $this->fetchTable('DeliveryNotes');
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
        $table = $this->fetchTable('DeliveryNoteDetails');
        $record = $table->get($id);
        if ($table->delete($record)) {
            $this->Flash->success('Đã xóa.');
        } else {
            $this->Flash->error('Xóa thất bại.');
        }
        return $this->redirect(['action' => 'edit',$record->delivery_note_id]);
    }

    public function exportExcel()
    {
        $table = $this->fetchTable('DeliveryNotes');
        $records = $table->find()->toArray();
        $service = new \App\Service\ExcelExportService();
        $file = $service->export('delivery_notes', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'delivery_notes_'.date('Ymd').'.xlsx']);
    }

    public function exportPdf()
    {
        $table = $this->fetchTable('DeliveryNotes');
        $records = $table->find()->toArray();
        $service = new \App\Service\PdfExportService();
        $file = $service->export('delivery_notes', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'delivery_notes_'.date('Ymd').'.pdf']);
    }
}
