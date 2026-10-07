<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductionOrderCostsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('production_order_costs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('ProductionOrders', ['foreignKey' => 'production_order_id', 'joinType' => 'LEFT']);
        $this->belongsTo('CostCenters', ['foreignKey' => 'cost_center_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('production_order_id', 'Không được để trống');
        $validator->notEmptyString('cost_type', 'Không được để trống');
        $validator->notEmptyString('amount', 'Không được để trống');
        return $validator;
    }
}
