<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class StockAdjustmentDetail extends Entity
{
    protected array $_accessible = [
            'stock_adjustment_id' => true,
            'product_id' => true,
            'quantity_system' => true,
            'quantity_actual' => true,
            'quantity_diff' => true,
            'unit_price' => true,
            'amount' => true,
            'id' => false
    ];
}
