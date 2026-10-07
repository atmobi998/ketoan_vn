<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class PurchaseInvoice extends Entity
{
    protected array $_accessible = [
            'invoice_number' => true,
            'invoice_date' => true,
            'supplier_id' => true,
            'goods_receipt_id' => true,
            'total_amount' => true,
            'vat_amount' => true,
            'discount_amount' => true,
            'grand_total' => true,
            'payment_due_date' => true,
            'status' => true,
            'created_by' => true,
            'accounting_period_id' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->id . ' (' . $this->invoice_number.')';
    }


}
