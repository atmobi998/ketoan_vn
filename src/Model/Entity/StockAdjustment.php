<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class StockAdjustment extends Entity
{
    protected array $_accessible = [
            'adjustment_number' => true,
            'adjustment_date' => true,
            'warehouse_id' => true,
            'adjustment_type' => true,
            'reason' => true,
            'total_amount' => true,
            'status' => true,
            'created_by' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->id . ' (' . $this->adjustment_number.')';
    }
    
}
