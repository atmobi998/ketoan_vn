<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Currency extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'symbol' => true,
            'exchange_rate' => true,
            'is_default' => true,
            'id' => false
    ];
}
