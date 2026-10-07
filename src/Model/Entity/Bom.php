<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Bom extends Entity
{
    protected array $_accessible = [
            'bom_code' => true,
            'product_id' => true,
            'version' => true,
            'quantity_produced' => true,
            'effective_date' => true,
            'expiry_date' => true,
            'status' => true,
            'description' => true,
            'created_by' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->id . ' (' . $this->bom_code.')';
    }


}
