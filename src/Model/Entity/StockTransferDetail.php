<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class StockTransferDetail extends Entity
{
    protected array $_accessible = [
            'stock_transfer_id' => true,
            'product_id' => true,
            'quantity' => true,
            'unit_id' => true,
            'notes' => true,
            'id' => false
    ];
}
