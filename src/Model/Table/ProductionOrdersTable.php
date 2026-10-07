<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductionOrdersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('production_orders');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Boms', ['foreignKey' => 'bom_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Products', ['foreignKey' => 'product_id', 'joinType' => 'LEFT']);
        $this->belongsTo('CostCenters', ['foreignKey' => 'cost_center_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('po_number', 'Không được để trống');
        $validator->add('po_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('bom_id', 'Không được để trống');
        $validator->notEmptyString('product_id', 'Không được để trống');
        $validator->notEmptyString('quantity_planned', 'Không được để trống');
        $validator->notEmptyString('quantity_produced', 'Không được để trống');
        $validator->notEmptyString('start_date', 'Không được để trống');
        $validator->notEmptyString('end_date', 'Không được để trống');
        $validator->notEmptyString('status', 'Không được để trống');
        return $validator;
    }
}
