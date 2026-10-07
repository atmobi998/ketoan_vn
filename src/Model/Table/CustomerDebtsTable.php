<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CustomerDebtsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('customer_debts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Customers', ['foreignKey' => 'customer_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('customer_id', 'Không được để trống');
        $validator->notEmptyString('document_type', 'Không được để trống');
        $validator->notEmptyString('document_number', 'Không được để trống');
        $validator->add('document_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('document_date', 'Không được để trống');
        $validator->notEmptyString('amount', 'Không được để trống');
        $validator->notEmptyString('paid_amount', 'Không được để trống');
        $validator->notEmptyString('remaining_amount', 'Không được để trống');
        $validator->notEmptyString('status', 'Không được để trống');
        return $validator;
    }
}
