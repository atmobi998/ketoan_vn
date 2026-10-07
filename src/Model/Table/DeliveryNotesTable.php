<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use ArrayObject;

class DeliveryNotesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('delivery_notes');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Customers', ['foreignKey' => 'customer_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Warehouses', ['foreignKey' => 'warehouse_id', 'joinType' => 'LEFT']);
        $this->belongsTo('SalesOrders', ['foreignKey' => 'sales_order_id', 'joinType' => 'LEFT']);
        $this->hasMany('DeliveryNoteDetails', ['foreignKey' => 'delivery_note_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('dn_number', 'Không được để trống');
        $validator->add('dn_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('delivery_date', 'Không được để trống');
        $validator->notEmptyString('customer_id', 'Không được để trống');
        $validator->notEmptyString('warehouse_id', 'Không được để trống');
        $validator->notEmptyString('total_amount', 'Không được để trống');
        $validator->notEmptyString('status', 'Không được để trống');
        return $validator;
    }

    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, $primary)
    {
        $query->orderBy(['DeliveryNotes.dn_number' => 'DESC']);
    }

}
