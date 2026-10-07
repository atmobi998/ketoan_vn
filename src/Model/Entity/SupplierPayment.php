<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class SupplierPayment extends Entity
{
    protected array $_accessible = [
            'payment_number' => true,
            'payment_date' => true,
            'supplier_id' => true,
            'amount' => true,
            'bank_account_id' => true,
            'payment_method' => true,
            'reference' => true,
            'notes' => true,
            'created_by' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->id . ' (' . $this->payment_number.')';
    }


}
