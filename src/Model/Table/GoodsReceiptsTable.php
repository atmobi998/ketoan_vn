<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use ArrayObject;

class GoodsReceiptsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('goods_receipts');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Suppliers', ['foreignKey' => 'supplier_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Warehouses', ['foreignKey' => 'warehouse_id', 'joinType' => 'LEFT']);
        $this->belongsTo('PurchaseOrders', ['foreignKey' => 'purchase_order_id', 'joinType' => 'LEFT']);
        $this->hasMany('GoodsReceiptDetails', ['foreignKey' => 'goods_receipt_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('gr_number', 'Không được để trống');
        $validator->add('gr_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('receipt_date', 'Không được để trống');
        $validator->notEmptyString('supplier_id', 'Không được để trống');
        $validator->notEmptyString('warehouse_id', 'Không được để trống');
        $validator->notEmptyString('total_amount', 'Không được để trống');
        $validator->notEmptyString('status', 'Không được để trống');
        return $validator;
    }

    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, $primary)
    {
        $query->orderBy(['GoodsReceipts.gr_number' => 'DESC']);
    }



}
