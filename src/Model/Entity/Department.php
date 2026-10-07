<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Department extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'description' => true,
            'parent_id' => true,
            'manager_id' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->name . ' (' . $this->code.')';
    }
    
}
