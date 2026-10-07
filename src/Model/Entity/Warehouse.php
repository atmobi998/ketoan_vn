<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Warehouse extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'address' => true,
            'manager_id' => true,
            'is_active' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->name . ' (' . $this->code.')';
    }


}
