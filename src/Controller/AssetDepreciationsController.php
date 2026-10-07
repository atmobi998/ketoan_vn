<?php
namespace App\Controller;
use Cake\I18n\FrozenDate;
use Cake\ORM\Query;
use Cake\Database\Expression\QueryExpression;
use Dompdf\Dompdf;
use Cake\I18n\Number;

class AssetDepreciationsController extends AppController
{
    public function index()
    {
        $session = $this->getRequest()->getSession();
        $producttbl = $this->fetchTable('FixedAssets');
        $options = $producttbl->find('list',['keyField' => 'id','valueField' => 'full_name'])
                                    ->where(function (QueryExpression $exp, Query $q) {return $exp->like('FixedAssets.code', 'TS%');})
                                    ->orderBy(['FixedAssets.name'])
                                    ->toArray();
        $defquery=$producttbl->find()->where(function (QueryExpression $exp, Query $q) {return $exp->like('FixedAssets.code', 'TS%');})->first();
        $this->set(compact('options'));
        $fixed_asset_id = $this->request->getQuery('fixed_asset_id');
        if (empty($fixed_asset_id)) {
            $fixed_asset_id = $session->read('fixed_asset_id');
        }
        if (empty($fixed_asset_id)) {
            $fixed_asset_id = $defquery->id;
        }
        $session->write('fixed_asset_id', $fixed_asset_id);
        $this->set(compact('fixed_asset_id'));
    
        $table = $this->fetchTable('AssetDepreciations');
        $query = $table->find()->where(['AssetDepreciations.fixed_asset_id' => $fixed_asset_id])
                                ->orderBy(['AssetDepreciations.depreciation_date' => 'DESC']);
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
        $table = $this->fetchTable('AssetDepreciations');
        $contains = [];
        foreach ($table->associations() as $assoc) {
            $contains[] = $assoc->getName();
        }
        $record = $table->get($id, contain: $contains);
        $this->set(compact('record'));
    }

    public function add($fixed_asset_id)
    {
        $table = $this->fetchTable('AssetDepreciations');
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
        $this->set(compact('record', 'related','fixed_asset_id'));
    }

    public function edit($id = null)
    {
        $table = $this->fetchTable('AssetDepreciations');
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
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $table = $this->fetchTable('AssetDepreciations');
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
        $table = $this->fetchTable('AssetDepreciations');
        $records = $table->find()->toArray();
        $service = new \App\Service\ExcelExportService();
        $file = $service->export('asset_depreciations', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'asset_depreciations_'.date('Ymd').'.xlsx']);
    }

    public function exportPdf()
    {
        $table = $this->fetchTable('AssetDepreciations');
        $records = $table->find()->toArray();
        $service = new \App\Service\PdfExportService();
        $file = $service->export('asset_depreciations', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'asset_depreciations_'.date('Ymd').'.pdf']);
    }
}
