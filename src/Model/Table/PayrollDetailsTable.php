<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PayrollDetailsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('payroll_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Payrolls', ['foreignKey' => 'payroll_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Employees', ['foreignKey' => 'employee_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('payroll_id', 'Không được để trống');
        $validator->notEmptyString('employee_id', 'Không được để trống');
        $validator->notEmptyString('basic_salary', 'Không được để trống');
        $validator->notEmptyString('allowance', 'Không được để trống');
        $validator->notEmptyString('overtime_amount', 'Không được để trống');
        $validator->notEmptyString('bonus', 'Không được để trống');
        $validator->notEmptyString('insurance_deduction', 'Không được để trống');
        $validator->notEmptyString('tax_deduction', 'Không được để trống');
        $validator->notEmptyString('other_deduction', 'Không được để trống');
        $validator->notEmptyString('net_salary', 'Không được để trống');
        return $validator;
    }
}
