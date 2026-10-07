<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use ArrayObject;

class CustomerPaymentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('customer_payments');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Customers', ['foreignKey' => 'customer_id', 'joinType' => 'LEFT']);
        $this->belongsTo('BankAccounts', ['foreignKey' => 'bank_account_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('payment_number', 'Không được để trống');
        $validator->add('payment_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('payment_date', 'Không được để trống');
        $validator->notEmptyString('customer_id', 'Không được để trống');
        $validator->notEmptyString('amount', 'Không được để trống');
        $validator->notEmptyString('payment_method', 'Không được để trống');
        return $validator;
    }

    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, $primary)
    {
        $query->orderBy(['CustomerPayments.payment_number' => 'DESC']);
    }


}
