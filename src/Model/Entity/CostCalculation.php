<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CostCalculation extends Entity
{
    protected array $_accessible = [
            'calculation_code' => true,
            'production_order_id' => true,
            'units' => true,
            'material_cost' => true,
            'labor_cost' => true,
            'overhead_cost' => true,
            'total_cost' => true,
            'unit_cost' => true,
            'calculation_date' => true,
            'status' => true,
            'notes' => true,
            'created_by' => true,
            'id' => false
    ];
}
