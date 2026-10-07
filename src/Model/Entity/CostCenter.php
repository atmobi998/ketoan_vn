<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CostCenter extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'description' => true,
            'department_id' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->name . ' (' . $this->code.')';
    }

}
