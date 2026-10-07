<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Product extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'product_category_id' => true,
            'unit_id' => true,
            'description' => true,
            'price_buy' => true,
            'price_sell' => true,
            'vat_rate' => true,
            'stock_min' => true,
            'stock_max' => true,
            'image' => true,
            'is_active' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->name . ' (' . $this->code.')';
    }


}
