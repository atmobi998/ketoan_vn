<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('products');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('ProductCategories', ['foreignKey' => 'product_category_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Units', ['foreignKey' => 'unit_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('code', 'Không được để trống');
        $validator->add('code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('name', 'Không được để trống');
        $validator->notEmptyString('price_buy', 'Không được để trống');
        $validator->notEmptyString('price_sell', 'Không được để trống');
        $validator->notEmptyString('vat_rate', 'Không được để trống');
        $validator->notEmptyString('stock_min', 'Không được để trống');
        $validator->notEmptyString('stock_max', 'Không được để trống');
        $validator->notEmptyString('is_active', 'Không được để trống');
        return $validator;
    }
}
