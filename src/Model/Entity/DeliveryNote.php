<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class DeliveryNote extends Entity
{
    protected array $_accessible = [
            'dn_number' => true,
            'delivery_date' => true,
            'sales_order_id' => true,
            'customer_id' => true,
            'warehouse_id' => true,
            'total_amount' => true,
            'vat_amount' => true,
            'discount_amount' => true,
            'grand_total' => true,
            'status' => true,
            'notes' => true,
            'created_by' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->id . ' (' . $this->dn_number.')';
    }

}
