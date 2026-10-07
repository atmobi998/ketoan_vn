<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class SalesOrderDetail extends Entity
{
    protected array $_accessible = [
            'sales_order_id' => true,
            'product_id' => true,
            'quantity' => true,
            'unit_id' => true,
            'unit_price' => true,
            'amount' => true,
            'vat_rate' => true,
            'vat_amount' => true,
            'description' => true,
            'id' => false
    ];
}
