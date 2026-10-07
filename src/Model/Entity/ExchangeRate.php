<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class ExchangeRate extends Entity
{
    protected array $_accessible = [
            'from_currency_id' => true,
            'to_currency_id' => true,
            'rate' => true,
            'effective_date' => true,
            'id' => false
    ];
}
