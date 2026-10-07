<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class PurchaseOrder extends Entity
{
    protected array $_accessible = [
            'po_number' => true,
            'order_date' => true,
            'supplier_id' => true,
            'currency_id' => true,
            'total_amount' => true,
            'vat_amount' => true,
            'discount_amount' => true,
            'grand_total' => true,
            'status' => true,
            'notes' => true,
            'created_by' => true,
            'approved_by' => true,
            'accounting_period_id' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->id . ' (' . $this->po_number.')';
    }

}

