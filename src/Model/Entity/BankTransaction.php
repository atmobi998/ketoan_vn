<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class BankTransaction extends Entity
{
    protected array $_accessible = [
            'transaction_date' => true,
            'bank_account_id' => true,
            'type' => true,
            'amount' => true,
            'description' => true,
            'reference_type' => true,
            'reference_id' => true,
            'balance_after' => true,
            'id' => false
    ];
}
