<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class ToolCategory extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'allocation_months' => true,
            'description' => true,
            'id' => false
    ];
}
