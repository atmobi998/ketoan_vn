<?php
namespace App\Controller;
use Cake\I18n\FrozenDate;
use Cake\ORM\Query;
use Cake\Database\Expression\QueryExpression;
use Dompdf\Dompdf;
use Cake\I18n\Number;

class CostCalculationsController extends AppController
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
    
        $table = $this->fetchTable('CostCalculations');
        $query = $table->find()->where(function (QueryExpression $exp, Query $q) use ($fromperiod, $toperiod) {return $exp->between('CostCalculations.calculation_date', $fromperiod->start_date, $toperiod->end_date, 'datetime');});
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
        $table = $this->fetchTable('CostCalculations');
        $contains = [];
        foreach ($table->associations() as $assoc) {
            $contains[] = $assoc->getName();
        }
        $record = $table->get($id, contain: $contains);
        $this->set(compact('record'));
    }

    public function add()
    {
        $table = $this->fetchTable('CostCalculations');
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

    public function edit($id = null)
    {
        $table = $this->fetchTable('CostCalculations');
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
        $table = $this->fetchTable('ProductionOrders');
        $rec = $table->get($record->production_order_id);
        $this->set(compact('rec'));
        
        $table = $this->fetchTable('ProductionOrderCosts');
        $query = $table->find()->where(['ProductionOrderCosts.production_order_id' => $record->production_order_id,'ProductionOrderCosts.cost_type' => 'material'])
                                ->select(['total' => 'SUM(amount)'])->first();
        $material_cost = $query->total ?? 0;
        $this->set(compact('material_cost'));

        $table = $this->fetchTable('ProductionOrderCosts');
        $query = $table->find()->where(['ProductionOrderCosts.production_order_id' => $record->production_order_id,'ProductionOrderCosts.cost_type' => 'labor'])
                                ->select(['total' => 'SUM(amount)'])->first();
        $labor_cost = $query->total ?? 0;
        $this->set(compact('labor_cost'));

        $table = $this->fetchTable('ProductionOrderCosts');
        $query = $table->find()->where(['ProductionOrderCosts.production_order_id' => $record->production_order_id,'ProductionOrderCosts.cost_type' => 'overhead'])
                                ->select(['total' => 'SUM(amount)'])->first();
        $overhead_cost = $query->total ?? 0;
        $this->set(compact('overhead_cost'));
        
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $table = $this->fetchTable('CostCalculations');
        $record = $table->get($id);
        if ($table->delete($record)) {
            $this->Flash->success('Đã xóa.');
        } else {
            $this->Flash->error('Xóa thất bại.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function exportExcel()
    {
        $table = $this->fetchTable('CostCalculations');
        $records = $table->find()->toArray();
        $service = new \App\Service\ExcelExportService();
        $file = $service->export('cost_calculations', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'cost_calculations_'.date('Ymd').'.xlsx']);
    }

    public function exportPdf()
    {
        $table = $this->fetchTable('CostCalculations');
        $records = $table->find()->toArray();
        $service = new \App\Service\PdfExportService();
        $file = $service->export('cost_calculations', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'cost_calculations_'.date('Ymd').'.pdf']);
    }
}
