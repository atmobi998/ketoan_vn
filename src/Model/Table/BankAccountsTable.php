<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BankAccountsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('bank_accounts');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Currencies', ['foreignKey' => 'currency_id', 'joinType' => 'LEFT']);
        $this->belongsTo('ChartOfAccounts', ['foreignKey' => 'chart_of_account_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('account_number', 'Không được để trống');
        $validator->add('account_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('bank_name', 'Không được để trống');
        $validator->notEmptyString('balance', 'Không được để trống');
        $validator->notEmptyString('is_active', 'Không được để trống');
        return $validator;
    }
}
