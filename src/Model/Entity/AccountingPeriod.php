<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class AccountingPeriod extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'start_date' => true,
            'end_date' => true,
            'status' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->name . ' (' . $this->code.')';
    }


}
