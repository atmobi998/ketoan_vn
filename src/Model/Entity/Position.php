<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Position extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'base_salary' => true,
            'description' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->name . ' (' . $this->code.')';
    }


}
