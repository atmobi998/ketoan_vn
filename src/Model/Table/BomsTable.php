<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BomsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('boms');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Products', ['foreignKey' => 'product_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('bom_code', 'Không được để trống');
        $validator->add('bom_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('product_id', 'Không được để trống');
        $validator->notEmptyString('version', 'Không được để trống');
        $validator->notEmptyString('quantity_produced', 'Không được để trống');
        $validator->notEmptyString('effective_date', 'Không được để trống');
        $validator->notEmptyString('status', 'Không được để trống');
        return $validator;
    }
}
