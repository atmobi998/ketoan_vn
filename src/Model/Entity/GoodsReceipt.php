<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class GoodsReceipt extends Entity
{
    protected array $_accessible = [
            'gr_number' => true,
            'receipt_date' => true,
            'purchase_order_id' => true,
            'supplier_id' => true,
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
        return $this->id . ' (' . $this->gr_number.')';
    }

}
