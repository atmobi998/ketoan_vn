<?php
namespace App\Controller;

class ChartOfAccountsController extends AppController
{
    
    public function index()
    {
        $table = $this->fetchTable('ChartOfAccounts');
        $query = $table->find();
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
        $table = $this->fetchTable('ChartOfAccounts');
        $contains = [];
        foreach ($table->associations() as $assoc) {
            $contains[] = $assoc->getName();
        }
        $record = $table->get($id, contain: $contains);
        $this->set(compact('record'));
    }

    public function add()
    {
        $table = $this->fetchTable('ChartOfAccounts');
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
        $Parents = $this->fetchTable('ChartOfAccounts');
        $related['Parents']=$Parents->find('list', limit: 500)->toArray();
        $this->set(compact('record', 'related'));
    }

    public function edit($id = null)
    {
        $table = $this->fetchTable('ChartOfAccounts');
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
        $Parents = $this->fetchTable('ChartOfAccounts');
        $related['Parents']=$Parents->find('list', limit: 500)->toArray();
        $this->set(compact('record', 'related'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $table = $this->fetchTable('ChartOfAccounts');
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
        $table = $this->fetchTable('ChartOfAccounts');
        $records = $table->find()->toArray();
        $service = new \App\Service\ExcelExportService();
        $file = $service->export('chart_of_accounts', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'chart_of_accounts_'.date('Ymd').'.xlsx']);
    }

    public function exportPdf()
    {
        $table = $this->fetchTable('ChartOfAccounts');
        $records = $table->find()->toArray();
        $service = new \App\Service\PdfExportService();
        $file = $service->export('chart_of_accounts', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'chart_of_accounts_'.date('Ymd').'.pdf']);
    }
}
