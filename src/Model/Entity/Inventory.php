<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Inventory extends Entity
{
    protected array $_accessible = [
            'product_id' => true,
            'warehouse_id' => true,
            'quantity' => true,
            'quantity_available' => true,
            'quantity_reserved' => true,
            'unit_id' => true,
            'last_import_price' => true,
            'average_price' => true,
            'last_updated' => true,
            'id' => false
    ];
}
