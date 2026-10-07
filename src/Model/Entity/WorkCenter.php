<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class WorkCenter extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'cost_per_hour' => true,
            'capacity' => true,
            'department_id' => true,
            'description' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->name . ' (' . $this->code.')';
    }


}
