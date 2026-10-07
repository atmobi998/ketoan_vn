<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class ProductCategory extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'parent_id' => true,
            'description' => true,
            'id' => false
    ];
}
