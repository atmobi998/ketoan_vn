<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class TaxRate extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'rate' => true,
            'chart_of_account_id' => true,
            'description' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->name . ' (' . $this->code.')';
    }


}
