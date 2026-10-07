<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class StockTransaction extends Entity
{
    protected array $_accessible = [
            'transaction_number' => true,
            'transaction_date' => true,
            'transaction_type' => true,
            'warehouse_id' => true,
            'warehouse_to_id' => true,
            'product_id' => true,
            'quantity' => true,
            'unit_id' => true,
            'unit_price' => true,
            'total_amount' => true,
            'reference_type' => true,
            'reference_id' => true,
            'notes' => true,
            'created_by' => true,
            'id' => false
    ];
}
