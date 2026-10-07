<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class ChartOfAccount extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'account_type' => true,
            'parent_id' => true,
            'is_detail' => true,
            'balance_type' => true,
            'description' => true,
            'is_active' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->code . ' (' . $this->name.')';
    }

}
