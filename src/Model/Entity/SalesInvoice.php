<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class SalesInvoice extends Entity
{
    protected array $_accessible = [
            'invoice_number' => true,
            'invoice_date' => true,
            'customer_id' => true,
            'delivery_note_id' => true,
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
