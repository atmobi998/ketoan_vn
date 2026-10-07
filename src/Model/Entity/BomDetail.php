<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class BomDetail extends Entity
{
    protected array $_accessible = [
            'bom_id' => true,
            'material_id' => true,
            'quantity' => true,
            'unit_id' => true,
            'waste_rate' => true,
            'unit_cost' => true,
            'total_cost' => true,
            'notes' => true,
            'id' => false
    ];
}
