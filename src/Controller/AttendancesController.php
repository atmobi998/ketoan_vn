<?php
namespace App\Controller;
use Cake\I18n\FrozenDate;
use Cake\ORM\Query;
use Cake\Database\Expression\QueryExpression;

class AttendancesController extends AppController
{
    public function index()
    {
        $filter_date = $this->request->getQuery('filter_date');
        if (empty($filter_date)) {
            $select_by_date = FrozenDate::today();
        } else {
            $select_by_date = FrozenDate::parse($filter_date);
        }
        $filter_date = $select_by_date->format('Y-m-d');
        $this->set(compact('filter_date'));

        $to_date = $this->request->getQuery('to_date');
        if (empty($to_date)) {
            $select_to_date = FrozenDate::today();
        } else {
            $select_to_date = FrozenDate::parse($to_date);
        }
        $to_date = $select_to_date->format('Y-m-d');
        $this->set(compact('to_date'));

        $table = $this->fetchTable('Attendances');
        $cnt = $this->fetchTable('Attendances')->find()->where(['Attendances.work_date' => $filter_date])->count();
        $check_out = $filter_date.' 17:00:00';
        $work_hours = 8.0;
        $overtime_hours = 0.0;
        if ($select_by_date->isSaturday()) {
            $check_out = $filter_date.' 12:00:00';
            $work_hours = 0.0;
            $overtime_hours = 4.0;
        }
        $employees = $this->fetchTable('Employees')->find('all')->toArray();
        foreach ($employees as $k => $v) {
            $chkcnt=$this->fetchTable('Attendances')->find()->where(['Attendances.work_date' => $filter_date,'Attendances.employee_id' => $v['id']])->count();
            $recordobj = $table->newEmptyEntity();
            $recordobj = $table->patchEntity($recordobj, 
                    ['employee_id' => $v['id'], 'work_date' => $filter_date, 'check_in' => $filter_date.' 08:00:00', 
                    'check_out' => $check_out, 'work_hours' => $work_hours, 'overtime_hours' => $overtime_hours, 'status' => 'present', 'notes' => 'auto timesheet']);
            if (($chkcnt<1) && !$select_by_date->isSunday() && ($v['join_date'] <= $select_by_date) && $table->save($recordobj)) {

            }
        }
        $employee = $this->request->getQuery('employee');
        $employees = $this->fetchTable('Employees')->find('list')->toArray();
        $this->set(compact('employees','employee'));

        $table = $this->fetchTable('Attendances');
        if ($employee) {
            $query = $table->find()->where(function (QueryExpression $exp, Query $q) use ($select_by_date, $select_to_date, $employee) {return $exp->between('Attendances.work_date', $select_by_date, $select_to_date, 'datetime')->eq('Attendances.employee_id', $employee);})->orderBy(['Attendances.work_date' => 'DESC','Attendances.employee_id' => 'ASC']);
        } else {
            $query = $table->find()->where(function (QueryExpression $exp, Query $q) use ($select_by_date, $select_to_date, $employee) {return $exp->between('Attendances.work_date', $select_by_date, $select_to_date, 'datetime');})->orderBy(['Attendances.work_date' => 'DESC','Attendances.employee_id' => 'ASC']);
        }

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
        $dbattsobj = $table;
        $this->set(compact('records','dbattsobj'));

    }

    public function view($id = null)
    {
        $table = $this->fetchTable('Attendances');
        $contains = [];
        foreach ($table->associations() as $assoc) {
            $contains[] = $assoc->getName();
        }
        $record = $table->get($id, contain: $contains);
        $this->set(compact('record'));
    }

    public function add()
    {
        $table = $this->fetchTable('Attendances');
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
        $table = $this->fetchTable('Attendances');
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
        $table = $this->fetchTable('Attendances');
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
        $table = $this->fetchTable('Attendances');
        $records = $table->find()->toArray();
        $service = new \App\Service\ExcelExportService();
        $file = $service->export('attendances', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'attendances_'.date('Ymd').'.xlsx']);
    }

    public function exportPdf()
    {
        $table = $this->fetchTable('Attendances');
        $records = $table->find()->toArray();
        $service = new \App\Service\PdfExportService();
        $file = $service->export('attendances', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'attendances_'.date('Ymd').'.pdf']);
    }
}
