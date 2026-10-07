<?php
namespace App\Controller;
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authorization->skipAuthorization();
        $this->Authentication->allowUnauthenticated(['login','logout']);
    }
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';
            return $this->redirect($target);
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Sai tai khoan hoac mat khau');
        }
    }
    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['action' => 'login']);
    }
    public function index()
    {
        $table = $this->fetchTable('Users');
        $records = $this->paginate($table->find()->contain(['Departments']));
        $this->set(compact('records'));
    }
    public function view($id = null)
    {
        $table = $this->fetchTable('Users');
        $record = $table->get($id, contain: ['Departments']);
        $this->set(compact('record'));
    }
    public function add()
    {
        $table = $this->fetchTable('Users');
        $record = $table->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (!empty($data['password'])) { $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT); }
            $record = $table->patchEntity($record, $data);
            if ($table->save($record)) { $this->Flash->success('Da luu user'); return $this->redirect(['action' => 'index']); }
            $this->Flash->error('Loi luu user');
        }
        $departments = $this->fetchTable('Departments')->find('list', limit: 500)->toArray();
        $this->set(compact('record', 'departments'));
        $this->set('related', ['Departments' => $departments]);
    }
    public function edit($id = null)
    {
        $table = $this->fetchTable('Users');
        $record = $table->get($id);
        if ($this->request->is(['patch','post','put'])) {
            $data = $this->request->getData();
            if (!empty($data['password'])) { $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT); } else { unset($data['password']); }
            $record = $table->patchEntity($record, $data);
            if ($table->save($record)) { $this->Flash->success('Da cap nhat'); return $this->redirect(['action' => 'index']); }
            $this->Flash->error('Loi');
        }
        $departments = $this->fetchTable('Departments')->find('list', limit: 500)->toArray();
        $this->set(compact('record', 'departments'));
        $this->set('related', ['Departments' => $departments]);
    }
    public function delete($id = null)
    {
        $this->request->allowMethod(['post','delete']);
        $table = $this->fetchTable('Users');
        $record = $table->get($id);
        if ($table->delete($record)) $this->Flash->success('Da xoa'); else $this->Flash->error('Xoa that bai');
        return $this->redirect(['action' => 'index']);
    }
    public function exportExcel()
    {
        $table = $this->fetchTable('Users');
        $records = $table->find()->toArray();
        $service = new \App\Service\ExcelExportService();
        $file = $service->export('users', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'users.xlsx']);
    }
    public function exportPdf()
    {
        $table = $this->fetchTable('Users');
        $records = $table->find()->toArray();
        $service = new \App\Service\PdfExportService();
        $file = $service->export('users', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'users.pdf']);
    }
}
