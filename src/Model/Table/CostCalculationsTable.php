<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CostCalculationsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('cost_calculations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('ProductionOrders', ['foreignKey' => 'production_order_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('calculation_code', 'Không được để trống');
        $validator->add('calculation_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('production_order_id', 'Không được để trống');
        $validator->notEmptyString('material_cost', 'Không được để trống');
        $validator->notEmptyString('labor_cost', 'Không được để trống');
        $validator->notEmptyString('overhead_cost', 'Không được để trống');
        $validator->notEmptyString('total_cost', 'Không được để trống');
        $validator->notEmptyString('unit_cost', 'Không được để trống');
        $validator->notEmptyString('calculation_date', 'Không được để trống');
        $validator->notEmptyString('status', 'Không được để trống');
        return $validator;
    }
}
