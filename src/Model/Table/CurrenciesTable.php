<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CurrenciesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('currencies');
        $this->setDisplayField('code');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('code', 'Không được để trống');
        $validator->add('code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('name', 'Không được để trống');
        $validator->notEmptyString('exchange_rate', 'Không được để trống');
        $validator->notEmptyString('is_default', 'Không được để trống');
        return $validator;
    }
}
