<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class ProductionOrderCost extends Entity
{
    protected array $_accessible = [
            'production_order_id' => true,
            'cost_type' => true,
            'amount' => true,
            'description' => true,
            'cost_center_id' => true,
            'id' => false
    ];
}
