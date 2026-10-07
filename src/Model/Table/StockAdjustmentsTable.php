<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class StockAdjustmentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('stock_adjustments');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Warehouses', ['foreignKey' => 'warehouse_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('adjustment_number', 'Không được để trống');
        $validator->add('adjustment_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('adjustment_date', 'Không được để trống');
        $validator->notEmptyString('warehouse_id', 'Không được để trống');
        $validator->notEmptyString('adjustment_type', 'Không được để trống');
        $validator->notEmptyString('total_amount', 'Không được để trống');
        $validator->notEmptyString('status', 'Không được để trống');
        return $validator;
    }
}
