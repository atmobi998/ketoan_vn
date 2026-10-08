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

class PayrollsController extends AppController
{

    public function beforeFilter(EventInterface $event): ?Response
	{
		$unlockedActions = ['updatepayroll'];
        $result = parent::beforeFilter($event);
		$this->FormProtection->setConfig('unlockedActions', $unlockedActions);
        $this->Authorization->skipAuthorization();
        $this->Authentication->allowUnauthenticated([$this->request->getParam('action')]);
        if ($result instanceof Response) {
            return $result;
        }
        return $result;
	}

    /**
     * THANH TOÁN LƯƠNG QUA NGÂN HÀNG - tạo UNC tự động
     * Route: /payrolls/pay-via-bank/{id}
     */
    public function payViaBank($id = null)
    {
        $this->request->allowMethod(['post', 'put', 'get']);
        $table = $this->fetchTable('Payrolls');
        $record = $table->get($id);
        
        $bankAccountId = $this->request->getQuery('bank_account_id') ?? $this->request->getData('bank_account_id');
        
        $gl = new \App\Service\GlPostingService();
        $result = $gl->createPayrollBankPayment((int)$id, $bankAccountId ? (int)$bankAccountId : null);
        
        if ($result['status'] === 'ok') {
            $this->Flash->success(sprintf('Đã tạo UNC %s - %s VND - Bút toán %s', 
                $result['voucher_number'], 
                number_format($result['amount']),
                $result['entry_number']
            ));
            // Cập nhật trạng thái bảng lương thành paid
            $record->status = 'paid';
            $table->save($record);
        } elseif ($result['status'] === 'skipped') {
            $this->Flash->warning($result['message']);
        } else {
            $this->Flash->error('Lỗi: '.$result['message']);
        }
        
        return $this->redirect(['action' => 'edit', $id]);
    }

    /**
     * THANH TOÁN LƯƠNG QUA NGÂN HÀNG - tạo UNC tự động
     * Route: /payrolls/pay-via-bank/{id}
     */
    public function payViaBankIdx($id = null)
    {
        $this->request->allowMethod(['post', 'put', 'get']);
        $table = $this->fetchTable('Payrolls');
        $record = $table->get($id);
        
        $bankAccountId = $this->request->getQuery('bank_account_id') ?? $this->request->getData('bank_account_id');
        
        $gl = new \App\Service\GlPostingService();
        $result = $gl->createPayrollBankPayment((int)$id, $bankAccountId ? (int)$bankAccountId : null);
        
        if ($result['status'] === 'ok') {
            $this->Flash->success(sprintf('Đã tạo UNC %s - %s VND - Bút toán %s', 
                $result['voucher_number'], 
                number_format($result['amount']),
                $result['entry_number']
            ));
            // Cập nhật trạng thái bảng lương thành paid
            $record->status = 'paid';
            $table->save($record);
        } elseif ($result['status'] === 'skipped') {
            $this->Flash->warning($result['message']);
        } else {
            $this->Flash->error('Lỗi: '.$result['message']);
        }
        
        return $this->redirect(['action' => 'index']);
    }

    /**
     * THANH TOÁN CẢ THÁNG QUA NGÂN HÀNG
     * Route: /payrolls/pay-month-via-bank?month=9&year=2026
     */
    public function payMonthViaBank()
    {
        $month = (int)($this->request->getQuery('month') ?? date('n'));
        $year = (int)($this->request->getQuery('year') ?? date('Y'));
        $bankAccountId = $this->request->getQuery('bank_account_id');
        $groupByDept = $this->request->getQuery('group') !== '0'; // default group theo phòng ban
        
        $gl = new \App\Service\GlPostingService();
        $result = $gl->createPayrollMonthBankPayment($month, $year, $bankAccountId ? (int)$bankAccountId : null, $groupByDept);
        
        if ($result['status'] === 'ok') {
            $this->Flash->success($result['message'] . ' - Tổng: ' . number_format($result['total_amount']) . ' VND');
        } else {
            $this->Flash->error($result['message']);
        }
        
        return $this->redirect(['action' => 'index', '?' => ['from_period' => sprintf('%04d-%02d', $year, $month), 'to_period' => sprintf('%04d-%02d', $year, $month)]]);
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
    
        $table = $this->fetchTable('Payrolls');
        $query = $table->find()->where(function (QueryExpression $exp, Query $q) use ($fromperiod, $toperiod) {return $exp->between('AccountingPeriods.start_date', $fromperiod->start_date, $toperiod->end_date, 'datetime');});
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

    public function updatepayroll($period_code = '') {
        $this->viewBuilder()->setLayout('ajax'); 
        $data = $this->getRequest()->getData();
        $from_period = $data['from_period'];
        $to_period = $data['to_period'];
        $return_code = $from_period;
        if (!empty($from_period) && !empty($to_period)) {
            $periodtbl = $this->fetchTable('AccountingPeriods');
            $fromperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($from_period, $to_period) {return $exp->eq('AccountingPeriods.code', $from_period);})->first();
            $toperiod = $periodtbl->find()->where(function (QueryExpression $exp, Query $q) use ($from_period, $to_period) {return $exp->eq('AccountingPeriods.code', $to_period);})->first();
            $deptable = $this->fetchTable('Departments');
            $emptable = $this->fetchTable('Employees');
            $prolltable = $this->fetchTable('Payrolls');
            $prdettable = $this->fetchTable('PayrollDetails');
            $month = $fromperiod->start_date->month;
            $year = $fromperiod->start_date->year;
            $existpr = $prolltable->find()->where(['Payrolls.payroll_month' => $month,'Payrolls.payroll_year' => $year])->all()->toArray();
            foreach ($existpr as $pr) {
                $existprdet = $prdettable->find()->where(['PayrollDetails.payroll_id' => $pr['id']])->all()->toArray();
                foreach ($existprdet as $prdet) {
                    $prdettable->delete($prdettable->get($prdet['id']));
                }
                $prolltable->delete($prolltable->get($pr['id']));
            }
            $defworkhours=0;
            $defoverhours=0;
            $perioddays=[];
            $currentDay = $fromperiod->start_date;
            while ($currentDay <= $fromperiod->end_date) {
                $currentDay = $currentDay->modify('+1 day');
                $perioddays[$currentDay->i18nFormat('yyyy-MM-dd')]=$currentDay;
                if ($currentDay->isSaturday()) {
                    $defoverhours+=4;
                    $defworkhours+=0;
                } else if ($currentDay->isSunday()) {
                    $defoverhours+=0;
                    $defworkhours+=0;
                } else {
                    $defoverhours+=0;
                    $defworkhours+=8;
                }
            }

            $depts = $deptable->find()->all()->toArray();
            foreach ($depts as $dept) {
                $emps = $emptable->find()->where(['Employees.department_id' => $dept['id']])->all()->toArray();
                $drecord = $prolltable->newEmptyEntity();
                $deptrecord = [   'payroll_code'=>'HR-PAY-'.$year.'-'.str_pad($month, 2, "0", STR_PAD_LEFT).'-'.str_pad($dept['id'], 3, "0", STR_PAD_LEFT),
                            'payroll_month'=> $month, 
                            'payroll_year'=> $year, 
                            'department_id' => $dept['id'],
                            'total_employees' => count($emps),
                            'total_amount' => 0.0,
                            'total_deduction' => 0.0,
                            'total_net' => 0.0,
                            'status' => 'approved',
                            'created_by' => 1,
                            'accounting_period_id' => $fromperiod->id,
                        ];
                $drecord = $prolltable->patchEntity($drecord, $deptrecord);
                $prolltable->save($drecord);
                $total_amount=0;
                $total_deduction=0;
                $total_net=0;
                $total_insurance_deduction=0;
                $total_tax_deduction=0;
                foreach ($emps as $emp) {
                    $attstable = $this->fetchTable('Attendances');
                    $empts = $attstable->find()->where(function (QueryExpression $exp, Query $q) use ($fromperiod,$emp) 
                        {
                            return $exp->between('Attendances.work_date', $fromperiod->start_date, $fromperiod->end_date, 'datetime')
                                    ->eq('Attendances.employee_id',$emp['id'])
                                    ->in('Attendances.status',['present','late']);
                        })
                        ->select(['hours' => 'SUM(work_hours)','overs' => 'SUM(overtime_hours)'])->first();
                    $empworkhours=$empts->hours;
                    $empoverhours=$empts->overs*1.5;
                    $basic_salary=($empworkhours/$defworkhours)*$emp['basic_salary'];
                    $allowance=($empworkhours/$defworkhours)*$basic_salary*(5/100);
                    $overtime_amount=($empoverhours/$defworkhours)*$basic_salary;
                    $bonus=($basic_salary+$allowance+$overtime_amount)*(5/100)+$emp['bonus'];
                    $insurance_deduction=$basic_salary*(21.5/100)*(20/100);
                    $taxcalc=($basic_salary);
                    $tax_deduction=0;
                    if ($taxcalc <= 10000000) {
                        $tax_deduction=($taxcalc)*(5/100);
                    } else if (10000000 < $taxcalc && $taxcalc <= 30000000) {
                        $tax_deduction=($taxcalc)*(10/100);
                    } else if (30000000 < $taxcalc && $taxcalc <= 60000000) {
                        $tax_deduction=($taxcalc)*(20/100);
                    } else if (60000000 < $taxcalc && $taxcalc <= 100000000) {
                        $tax_deduction=($taxcalc)*(30/100);
                    } else if (100000000 < $taxcalc) {
                        $tax_deduction=($taxcalc)*(35/100);
                    }
                    $other_deduction=0;
                    $net_salary=$basic_salary+$allowance+$overtime_amount+$bonus-$insurance_deduction-$tax_deduction-$other_deduction;
                    $empproll = [
                                'payroll_id'=>$drecord->id,
                                'employee_id'=>$emp['id'],
                                'basic_salary'=>$basic_salary,
                                'allowance'=>$allowance,
                                'overtime_amount'=>$overtime_amount,
                                'bonus'=>$bonus,
                                'insurance_deduction'=>$insurance_deduction,
                                'tax_deduction'=>$tax_deduction,
                                'other_deduction'=>$other_deduction,
                                'net_salary'=>$net_salary,
                                'notes'=>'auto generated',
                                ];
                    $erecord = $prdettable->newEmptyEntity();
                    $erecord = $prdettable->patchEntity($erecord, $empproll);
                    $prdettable->save($erecord);
                    $total_amount+=$basic_salary+$allowance+$overtime_amount+$bonus;
                    $total_deduction+=($insurance_deduction+$tax_deduction+$other_deduction);
                    $total_net+=$net_salary;
                    $total_insurance_deduction+=$insurance_deduction;
                    $total_tax_deduction+=$tax_deduction;
                }
                $drecord->total_amount=$total_amount;
                $drecord->total_deduction=($total_amount>0)? $total_deduction:0;
                $drecord->total_net=($total_amount>0)? $total_net:0;
                $drecord->insurance_deduction=($total_amount>0)? $total_insurance_deduction:0;
                $drecord->tax_deduction=($total_amount>0)? $total_tax_deduction:0;
                $prolltable->save($drecord);
            }
        }
        $this->set(compact('return_code','from_period','to_period','month','year'));
    }

    public function view($id = null)
    {
        $table = $this->fetchTable('Payrolls');
        $contains = [];
        foreach ($table->associations() as $assoc) {
            $contains[] = $assoc->getName();
        }
        $record = $table->get($id, contain: $contains);
        $this->set(compact('record'));

        $table = $this->fetchTable('PayrollDetails');
        $query = $table->find()->where(['PayrollDetails.payroll_id' => $id]);
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
                                'employee'=>$rec->employee->full_name,
                                'basic_salary'=>Number::format((int)$rec->basic_salary),
                                'allowance'=>Number::format((int)$rec->allowance),
                                'overtime_amount'=>Number::format((int)$rec->overtime_amount),
                                'bonus'=>Number::format((int)$rec->bonus),
                                'insurance'=>Number::format((int)$rec->insurance_deduction),
                                'tax'=>Number::format((int)$rec->tax_deduction),
                                'other'=>Number::format((int)$rec->other_deduction),
                                'net_salary'=>Number::format((int)$rec->net_salary),
                                ];
            $recnbr++;
        }
        $records=$tmprec;
        $file = $this->exportPR('payrolls', $records, $record);
        return $this->response->withFile($file, ['download' => true, 'name' => 'payrolls_'.$record->accounting_period->code.'_'.$record->department->code.'.pdf']);
        
    }

    public function exportPR(string $tableName, array $records, \Cake\Datasource\EntityInterface $record): string
    {
        $html = '<html>
    <head><meta charset="utf-8">
        <style>
            body {font-family: "DejaVu Sans", sans-serif;font-size: 14px;}
            h2 {font-family: "DejaVu Sans", sans-serif;font-weight: bold;font-size: 16px;}
        </style>
    </head>
    <body><h2 style="text-align:center">Bảng lương</h2>';
        $html .= '<table cellpadding="5" cellspacing="5"><tr><td>Kỳ: <u>' . $record->accounting_period->name . '</u></td>';
        $html .= '<td>Phòng ban: '.$record->department->name.'</td></tr>';
        $html .= '<tr>';
        $html .= '<td>code: '.$record->payroll_code.'</td><td>Tổng cộng (NET): <b>'.Number::format((int)$record->total_net).'</b> VNĐ</td></tr></table>';
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
        $table = $this->fetchTable('Payrolls');
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
        $table = $this->fetchTable('PayrollDetails');
        $record = $table->newEmptyEntity();
        if ($this->request->is('post')) {
            $record = $table->patchEntity($record, $this->request->getData());
            if ($table->save($record)) {
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
        $this->set(compact('record', 'related'));
    }

    public function edit($id = null)
    {
        $table = $this->fetchTable('Payrolls');
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

        $table = $this->fetchTable('PayrollDetails');
        $query = $table->find()->where(['PayrollDetails.payroll_id' => $id]);
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
        $table = $this->fetchTable('PayrollDetails');
        $record = $table->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $record = $table->patchEntity($record, $this->request->getData());
            if ($table->save($record)) {
                $this->Flash->success('Đã cập nhật.');
                return $this->redirect(['action' => 'edit',$record->payroll_id]);
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
        $table = $this->fetchTable('Payrolls');
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
        $table = $this->fetchTable('PayrollDetails');
        $record = $table->get($id);
        if ($table->delete($record)) {
            $this->Flash->success('Đã xóa.');
        } else {
            $this->Flash->error('Xóa thất bại.');
        }
        return $this->redirect(['action' => 'edit',$record->payroll_id]);
    }

    public function exportExcel()
    {
        $table = $this->fetchTable('Payrolls');
        $records = $table->find()->toArray();
        $service = new \App\Service\ExcelExportService();
        $file = $service->export('payrolls', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'payrolls_'.date('Ymd').'.xlsx']);
    }

    public function exportPdf()
    {
        $table = $this->fetchTable('Payrolls');
        $records = $table->find()->toArray();
        $service = new \App\Service\PdfExportService();
        $file = $service->export('payrolls', $records);
        return $this->response->withFile($file, ['download' => true, 'name' => 'payrolls_'.date('Ymd').'.pdf']);
    }
}
