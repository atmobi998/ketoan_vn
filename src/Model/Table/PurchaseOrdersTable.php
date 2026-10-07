<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use ArrayObject;

class PurchaseOrdersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('purchase_orders');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Suppliers', ['foreignKey' => 'supplier_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Currencies', ['foreignKey' => 'currency_id', 'joinType' => 'LEFT']);
        $this->belongsTo('AccountingPeriods', ['foreignKey' => 'accounting_period_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('po_number', 'Không được để trống');
        $validator->add('po_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('order_date', 'Không được để trống');
        $validator->notEmptyString('supplier_id', 'Không được để trống');
        $validator->notEmptyString('total_amount', 'Không được để trống');
        $validator->notEmptyString('vat_amount', 'Không được để trống');
        $validator->notEmptyString('discount_amount', 'Không được để trống');
        $validator->notEmptyString('grand_total', 'Không được để trống');
        $validator->notEmptyString('status', 'Không được để trống');
        return $validator;
    }

    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, $primary)
    {
        $query->orderBy(['PurchaseOrders.po_number' => 'DESC']);
    }


}
