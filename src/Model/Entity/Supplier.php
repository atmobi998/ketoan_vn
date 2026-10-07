<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Supplier extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'tax_code' => true,
            'address' => true,
            'phone' => true,
            'email' => true,
            'contact_person' => true,
            'chart_of_account_id' => true,
            'debt_account' => true,
            'payment_term' => true,
            'is_active' => true,
            'id' => false
    ];
}
