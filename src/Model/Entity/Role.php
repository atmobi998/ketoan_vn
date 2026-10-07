<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Role extends Entity
{
    protected array $_accessible = [
            'name' => true,
            'description' => true,
            'id' => false
    ];
}
