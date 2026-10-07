<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CustomerPayment extends Entity
{
    protected array $_accessible = [
            'payment_number' => true,
            'payment_date' => true,
            'customer_id' => true,
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
