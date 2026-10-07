<?php
namespace App\Controller;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;
use Cake\Database\Expression\QueryExpression;
use Dompdf\Dompdf;
use Cake\I18n\Number;
use Cake\Core\Configure;
use Cake\Database\Expression\IdentifierExpression;
use Cake\I18n\I18n;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Text;
use Cake\Mailer\Email;
use Cake\Network\Session;
use Cake\Utility\Security;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;
use Cake\Core\Exception\Exception;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Router;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Authentication\Identifier\PasswordIdentifier;
use Cake\I18n\DateTime;

class ProductionOrdersController extends AppController
{

    public function beforeFilter(EventInterface $event): ?Response
	{
		$unlockedActions = ['getprodord'];
        $result = parent::beforeFilter($event);
		$this->FormProtection->setConfig('unlockedActions', $unlockedActions);
        $this->Authorization->skipAuthorization();
        $this->Authentication->allowUnauthenticated([$this->request->getParam('action')]);
        if ($result instanceof Response) {
            return $result;
        }
        return $result;
	}

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
    
        $table = $this->fetchTable('ProductionOrders');
        $query = $table->find()->where(function (QueryExpression $exp, Query $q) use ($fromperiod, $toperiod) {return $exp->between('ProductionOrders.start_date', $fromperiod->start_date, $toperiod->end_date, 'datetime');})
                                ->orderBy(['ProductionOrders.po_number' => 'DESC']);
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
        $table = $this->fetchTable('ProductionOrders');
        $contains = [];
        foreach ($table->associations() as $assoc) {
            $contains[] = $assoc->getName();
        }
        $record = $table->get($id, contain: $contains);
        $this->set(compact('record'));
    }

    public function add()
    {
        $table = $this->fetchTable('ProductionOrders');
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
        $table = $this->fetchTable('ProductionOrderMaterials');
        $record = $table->newEmptyEntity();
        if ($this->request->is('post')) {
            $record = $table->patchEntity($record, $this->request->getData());
            if ($table->save($record)) {
                $this->Flash->success('Đã lưu thành công.');
                return $this->redirect(['action' => 'edit',$record->production_order_id]);
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

    public function addcost($id_master)
    {
        $table = $this->fetchTable('ProductionOrderCosts');
        $record = $table->newEmptyEntity();
        if ($this->request->is('post')) {
            $record = $table->patchEntity($record, $this->request->getData());
            if ($table->save($record)) {
                $this->Flash->success('Đã lưu thành công.');
                return $this->redirect(['action' => 'edit',$record->production_order_id]);
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
        $table = $this->fetchTable('ProductionOrders');
        $record = $table->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $record = $table->patchEntity($record, $this->request->getData());
            if ($table->save($record)) {
                $this->Flash->success('Đã cập nhật.');
                return $this->redirect(['action' => 'edit',$record->id]);
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

        $pordtable = $this->fetchTable('ProductionOrders');
        $product_id=$record->product_id ?? 0;
        $warehouse_id=Configure::read('Site.khoTP');
        $invtab = $this->fetchTable('Inventories');
        $invrec = $invtab->find()->where(['Inventories.warehouse_id' => $warehouse_id,'Inventories.product_id' => $product_id])->first();
        if (!$invrec) {
            $invrec = $invtab->newEmptyEntity();
            $invrec->warehouse_id=$warehouse_id;
            $invrec->product_id=$product_id;
            $invrec->quantity=0;
        }
        $invrec->quantity += $record->quantity_produced;
        $invrec->quantity_available += $record->quantity_produced;
        if ($record->sync_inv < 1 && $record->status == 'completed') {
            if ($invtab->save($invrec)) {
                $record->sync_inv=1;
                $pordtable->save($record);
            }
        }

        $dettable = $this->fetchTable('ProductionOrderMaterials');
        $detrecs = $dettable->find()->where(['ProductionOrderMaterials.production_order_id' => $id])->all();
        foreach ($detrecs as $detrec) {
            $product_id=$detrec->product_id ?? 0;
            $warehouse_id=$detrec->warehouse_id ?? 0;
            $invrec = $invtab->find()->where(['Inventories.warehouse_id' => $warehouse_id,'Inventories.product_id' => $product_id])->first();
            if (!$invrec) {
                $invrec = $invtab->newEmptyEntity();
                $invrec->warehouse_id=$warehouse_id;
                $invrec->product_id=$product_id;
                $invrec->quantity=0;
            }
            $invrec->quantity -= $detrec->quantity_used;
            $invrec->quantity_available -= $detrec->quantity_used;
            if ($detrec->sync_inv < 1) {
                if ($invtab->save($invrec)) {
                    $detrec->sync_inv=1;
                    $dettable->save($detrec);
                }
            }
        }


        $table = $this->fetchTable('ProductionOrderMaterials');
        $query = $table->find()->where(['ProductionOrderMaterials.production_order_id' => $id]);
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
        
        $table = $this->fetchTable('ProductionOrderCosts');
        $query = $table->find()->where(['ProductionOrderCosts.production_order_id' => $id]);
        $contains = [];
        foreach ($table->associations() as $assoc) {
            if ($assoc->type() === 'manyToOne') {
                $contains[] = $assoc->getName();
            }
        }
        if (!empty($contains)) {
            $query->contain($contains);
        }
        $recordcosts = $this->paginate($query);
        $this->set(compact('recordcosts'));
        
        $table = $this->fetchTable('BomDetails');
        $query = $table->find()->where(['BomDetails.bom_id' => $record->bom_id]);
        $contains = [];
        foreach ($table->associations() as $assoc) {
            if ($assoc->type() === 'manyToOne') {
                $contains[] = $assoc->getName();
            }
        }
        if (!empty($contains)) {
            $query->contain($contains);
        }
        $bomrecords = $this->paginate($query,['limit' => 250, 'maxLimit' => 500]);
        $this->set(compact('bomrecords'));

        $table = $this->fetchTable('Routings');
        $query = $table->find()->where(['Routings.product_id' => $record->product_id]);
        $contains = [];
        foreach ($table->associations() as $assoc) {
            if ($assoc->type() === 'manyToOne') {
                $contains[] = $assoc->getName();
            }
        }
        if (!empty($contains)) {
            $query->contain($contains);
        }
        $routerecords = $this->paginate($query,['limit' => 250, 'maxLimit' => 500]);
        $this->set(compact('routerecords'));
        
    }

    public function getprodord($id=null) {
        $this->viewBuilder()->setLayout('ajax');
        $table = $this->fetchTable('ProductionOrders');

        if ($table->exists(['id' => $id])) {
            $record = $table->get($id);
            $table = $this->fetchTable('ProductionOrderCosts');

            $query = $table->find()->where(['ProductionOrderCosts.production_order_id' => $id,'ProductionOrderCosts.cost_type' => 'material'])
                                    ->select(['total' => 'SUM(amount)'])->first();
            $material_cost = $query->total ?? 0;

            $query = $table->find()->where(['ProductionOrderCosts.production_order_id' => $id,'ProductionOrderCosts.cost_type' => 'labor'])
                                    ->select(['total' => 'SUM(amount)'])->first();
            $labor_cost = $query->total ?? 0;

            $query = $table->find()->where(['ProductionOrderCosts.production_order_id' => $id,'ProductionOrderCosts.cost_type' => 'overhead'])
                                    ->select(['total' => 'SUM(amount)'])->first();
            $overhead_cost = $query->total ?? 0;

            $record->material_cost=$material_cost;
            $record->labor_cost=$labor_cost;
            $record->overhead_cost=$overhead_cost;
        }
        $this->set(compact('record'));
    } 

    public function editdetail($id = null)
    {
        $table = $this->fetchTable('ProductionOrderMaterials');
        $record = $table->get($id);
        $bkrec = $table->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $record = $table->patchEntity($record, $this->request->getData());
            if ($table->save($record)) {
                $product_id=$record->product_id ?? 0;
                $warehouse_id=$record->warehouse_id ?? 0;
                $invtab = $this->fetchTable('Inventories');
                $invrec = $invtab->find()->where(['Inventories.warehouse_id' => $warehouse_id,'Inventories.product_id' => $product_id])->first();
                if ($record->quantity_used > $bkrec->quantity_used) {
                    $invrec->quantity -= ($record->quantity_used-$bkrec->quantity_used);
                    $invrec->quantity_available -= ($record->quantity_used-$bkrec->quantity_used);
                } else {
                    $invrec->quantity += ($bkrec->quantity_used-$record->quantity_used);
                    $invrec->quantity_available += ($bkrec->quantity_used-$record->quantity_used);
                }
                $invtab->save($invrec);
                $this->Flash->success('Đã cập nhật.');
                return $this->redirect(['action' => 'edit',$record->production_order_id]);
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

    public function editcost($id = null)
    {
        $table = $this->fetchTable('ProductionOrderCosts');
        $record = $table->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $record = $table->patchEntity($record, $this->request->getData());
            if ($table->save($record)) {
                $this->Flash->success('Đã cập nhật.');
                return $this->redirect(['action' => 'edit',$record->production_order_id]);
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
        $table = $this->fetchTable('ProductionOrders');
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
        $table = $this->fetchTable('ProductionOrderMaterials');
        $record = $table->get($id);
        if ($table->delete($record)) {
            $product_id=$record->product_id ?? 0;
            $warehouse_id=$record->warehouse_id ?? 0;
            $invtab = $this->fetchTable('Inventories');
            $invrec = $invtab->find()->where(['Inventories.warehouse_id' => $warehouse_id,'Inventories.product_id' => $product_id])->first();
            $invrec->quantity += $record->quantity_used;
            $invrec->quantity_available += $record->quantity_used;
            $invtab->save($invrec);
            $this->Flash->success('Đã xóa.');
        } else {
            $this->Flash->error('Xóa thất bại.');
        }
        return $this->redirect(['action' => 'edit',$record->production_order_id]);
    }

    public function deletecost($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $table = $this->fetchTable('ProductionOrderCosts');
        $record = $table->get($id);
        if ($table->delete($record)) {
            $this->Flash->success('Đã xóa.');
        } else {
            $this->Flash->error('Xóa thất bại.');
        }
        return $this->redirect(['action' => 'edit',$record->production_order_id]);
    }

    public function exportExcel()
    {
        $table = $this->fetchTable('ProductionOrders');
        $records = $table->find()->toArray();
        $service = new \App\Service\ExcelExportService();
        $file = $service->export('production_orders', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'production_orders_'.date('Ymd').'.xlsx']);
    }

    public function exportPdf()
    {
        $table = $this->fetchTable('ProductionOrders');
        $records = $table->find()->toArray();
        $service = new \App\Service\PdfExportService();
        $file = $service->export('production_orders', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'production_orders_'.date('Ymd').'.pdf']);
    }
}
