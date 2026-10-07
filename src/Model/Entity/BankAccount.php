<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class BankAccount extends Entity
{
    protected array $_accessible = [
            'account_number' => true,
            'bank_name' => true,
            'branch' => true,
            'currency_id' => true,
            'chart_of_account_id' => true,
            'balance' => true,
            'is_active' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->account_number . ' (' . $this->bank_name.')';
    }


}
