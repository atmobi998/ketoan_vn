<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CashPaymentDetailsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('cash_payment_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('CashPayments', ['foreignKey' => 'cash_payment_id', 'joinType' => 'LEFT']);
        $this->belongsTo('ChartOfAccounts', ['foreignKey' => 'chart_of_account_id', 'joinType' => 'LEFT']);
        $this->belongsTo('CostCenters', ['foreignKey' => 'cost_center_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('cash_payment_id', 'Không được để trống');
        $validator->notEmptyString('amount', 'Không được để trống');
        return $validator;
    }
}
