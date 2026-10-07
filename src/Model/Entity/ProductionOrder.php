<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class ProductionOrder extends Entity
{
    protected array $_accessible = [
            'po_number' => true,
            'bom_id' => true,
            'product_id' => true,
            'quantity_planned' => true,
            'quantity_produced' => true,
            'start_date' => true,
            'end_date' => true,
            'status' => true,
            'cost_center_id' => true,
            'sync_inv' => true,
            'created_by' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->id . ' (' . $this->po_number.')';
    }

}
