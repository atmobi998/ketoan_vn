<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CashPaymentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('cash_payments');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('ChartOfAccounts', ['foreignKey' => 'chart_of_account_id', 'joinType' => 'LEFT']);
        $this->belongsTo('BankAccounts', ['foreignKey' => 'bank_account_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Currencies', ['foreignKey' => 'currency_id', 'joinType' => 'LEFT']);
        $this->belongsTo('AccountingPeriods', ['foreignKey' => 'accounting_period_id', 'joinType' => 'LEFT']);
        $this->hasMany('CashPaymentDetails');
    }
    
    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('voucher_number', 'Không được để trống');
        $validator->add('voucher_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('voucher_date', 'Không được để trống');
        $validator->notEmptyString('accounting_date', 'Không được để trống');
        $validator->notEmptyString('payee_name', 'Không được để trống');
        $validator->notEmptyString('amount', 'Không được để trống');
        $validator->notEmptyString('exchange_rate', 'Không được để trống');
        $validator->notEmptyString('amount_vnd', 'Không được để trống');
        $validator->notEmptyString('status', 'Không được để trống');
        return $validator;
    }
}
