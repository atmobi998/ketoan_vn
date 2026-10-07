<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class ProductionOrderMaterial extends Entity
{
    protected array $_accessible = [
            'production_order_id' => true,
            'product_id' => true,
            'quantity_required' => true,
            'quantity_used' => true,
            'unit_id' => true,
            'unit_price' => true,
            'total_cost' => true,
            'warehouse_id' => true,
            'sync_inv' => true,
            'id' => false
    ];
}
