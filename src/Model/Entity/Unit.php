<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Unit extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'description' => true,
            'id' => false
    ];
}
