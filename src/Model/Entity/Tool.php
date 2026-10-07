<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Tool extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'tool_category_id' => true,
            'quantity' => true,
            'unit_id' => true,
            'unit_price' => true,
            'total_value' => true,
            'allocation_months' => true,
            'remaining_value' => true,
            'status' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->name . ' (' . $this->code.')';
    }

}
