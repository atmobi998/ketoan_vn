<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class InventoriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('inventories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Products', ['foreignKey' => 'product_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Warehouses', ['foreignKey' => 'warehouse_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Units', ['foreignKey' => 'unit_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('product_id', 'Không được để trống');
        $validator->notEmptyString('warehouse_id', 'Không được để trống');
        $validator->notEmptyString('quantity', 'Không được để trống');
        $validator->notEmptyString('quantity_available', 'Không được để trống');
        $validator->notEmptyString('quantity_reserved', 'Không được để trống');
        $validator->notEmptyString('last_import_price', 'Không được để trống');
        $validator->notEmptyString('average_price', 'Không được để trống');
        return $validator;
    }
}
