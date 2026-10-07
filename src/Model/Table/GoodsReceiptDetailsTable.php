<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class GoodsReceiptDetailsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('goods_receipt_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('GoodsReceipts', ['foreignKey' => 'goods_receipt_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Products', ['foreignKey' => 'product_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Units', ['foreignKey' => 'unit_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('goods_receipt_id', 'Không được để trống');
        $validator->notEmptyString('product_id', 'Không được để trống');
        $validator->notEmptyString('quantity', 'Không được để trống');
        $validator->notEmptyString('unit_price', 'Không được để trống');
        $validator->notEmptyString('amount', 'Không được để trống');
        $validator->add('lot_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        return $validator;
    }
}
