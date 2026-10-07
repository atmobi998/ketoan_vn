<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BankTransactionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('bank_transactions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('BankAccounts', ['foreignKey' => 'bank_account_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('transaction_date', 'Không được để trống');
        $validator->notEmptyString('bank_account_id', 'Không được để trống');
        $validator->notEmptyString('type', 'Không được để trống');
        $validator->notEmptyString('amount', 'Không được để trống');
        $validator->notEmptyString('balance_after', 'Không được để trống');
        return $validator;
    }
}
