<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class StockTransfer extends Entity
{
    protected array $_accessible = [
            'transfer_number' => true,
            'from_warehouse_id' => true,
            'to_warehouse_id' => true,
            'transfer_date' => true,
            'status' => true,
            'notes' => true,
            'created_by' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->id . ' (' . $this->transfer_number.')';
    }


}
