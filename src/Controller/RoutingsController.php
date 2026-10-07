<?php
namespace App\Controller;
use Cake\I18n\FrozenDate;
use Cake\ORM\Query;
use Cake\Database\Expression\QueryExpression;
use Dompdf\Dompdf;
use Cake\I18n\Number;

class RoutingsController extends AppController
{
    public function index()
    {
        $session = $this->getRequest()->getSession();
        $producttbl = $this->fetchTable('Products');
        $options = $producttbl->find('list',['keyField' => 'id','valueField' => 'full_name'])
                                    ->where(function (QueryExpression $exp, Query $q) {return $exp->like('Products.code', 'TP%');})
                                    ->orderBy(['Products.name'])
                                    ->toArray();
        $defquery=$producttbl->find()->where(function (QueryExpression $exp, Query $q) {return $exp->like('Products.code', 'TP%');})->first();
        $this->set(compact('options'));
        $product_id = $this->request->getQuery('product_id');
        if (empty($product_id)) {
            $product_id = $session->read('product_id');
        }
        if (empty($product_id)) {
            $product_id = $defquery->id;
        }
        $session->write('product_id', $product_id);
        $this->set(compact('product_id'));

        $table = $this->fetchTable('Routings');
        $query = $table->find()->where(['Routings.product_id' => $product_id]);
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
        $table = $this->fetchTable('Routings');
        $contains = [];
        foreach ($table->associations() as $assoc) {
            $contains[] = $assoc->getName();
        }
        $record = $table->get($id, contain: $contains);
        $this->set(compact('record'));
    }

    public function add()
    {
        $table = $this->fetchTable('Routings');
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
        $session = $this->getRequest()->getSession();
        $product_id = $session->read('product_id');
        $this->set(compact('product_id'));
    }

    public function edit($id = null)
    {
        $table = $this->fetchTable('Routings');
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
        $table = $this->fetchTable('Routings');
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
        $table = $this->fetchTable('Routings');
        $records = $table->find()->toArray();
        $service = new \App\Service\ExcelExportService();
        $file = $service->export('routings', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'routings_'.date('Ymd').'.xlsx']);
    }

    public function exportPdf()
    {
        $table = $this->fetchTable('Routings');
        $records = $table->find()->toArray();
        $service = new \App\Service\PdfExportService();
        $file = $service->export('routings', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'routings_'.date('Ymd').'.pdf']);
    }
}
