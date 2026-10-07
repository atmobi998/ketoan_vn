<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ExchangeRatesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('exchange_rates');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('from_currency_id', 'Không được để trống');
        $validator->notEmptyString('to_currency_id', 'Không được để trống');
        $validator->notEmptyString('rate', 'Không được để trống');
        $validator->notEmptyString('effective_date', 'Không được để trống');
        return $validator;
    }
}
