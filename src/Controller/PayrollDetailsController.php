<?php
namespace App\Controller;
use Cake\I18n\FrozenDate;
use Cake\ORM\Query;
use Cake\Database\Expression\QueryExpression;
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
use Dompdf\Dompdf;
use Cake\I18n\Number;

class PayrollDetailsController extends AppController
{
    public function index()
    {
        $session = $this->getRequest()->getSession();
        $periodtbl = $this->fetchTable('AccountingPeriods');
        $options = $periodtbl->find('list',['keyField' => 'code','valueField' => 'name'])->toArray();
        $this->set(compact('options'));
        $from_period = $this->request->getQuery('from_period');
        $today = FrozenDate::today();
        $curperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($today) {return $exp->lte('AccountingPeriods.start_date', $today)->gte('AccountingPeriods.end_date', $today);})->first();
        if (empty($from_period)) {
            $from_period = $session->read('from_period');
        }
        if (empty($from_period)) {
            $from_period = $curperiod->code;
        }
        $session->write('from_period', $from_period);
        $this->set(compact('from_period'));
        $fromperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($from_period) {return $exp->eq('AccountingPeriods.code', $from_period);})->first();
    
        $table = $this->fetchTable('PayrollDetails');
        $query = $table->find()->where(function (QueryExpression $exp, Query $q) use ($fromperiod) {return $exp->eq('Payrolls.accounting_period_id', $fromperiod->id);});
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
        $table = $this->fetchTable('PayrollDetails');
        $contains = [];
        foreach ($table->associations() as $assoc) {
            $contains[] = $assoc->getName();
        }
        $record = $table->get($id, contain: $contains);
        $this->set(compact('record'));
    }

    public function add()
    {
        $table = $this->fetchTable('PayrollDetails');
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
        $table = $this->fetchTable('PayrollDetails');
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
        $table = $this->fetchTable('PayrollDetails');
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
        $table = $this->fetchTable('PayrollDetails');
        $records = $table->find()->toArray();
        $service = new \App\Service\ExcelExportService();
        $file = $service->export('payroll_details', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'payroll_details_'.date('Ymd').'.xlsx']);
    }

    public function exportPdf()
    {
        $table = $this->fetchTable('PayrollDetails');
        $records = $table->find()->toArray();
        $service = new \App\Service\PdfExportService();
        $file = $service->export('payroll_details', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'payroll_details_'.date('Ymd').'.pdf']);
    }
}
