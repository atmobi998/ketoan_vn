<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Routing extends Entity
{
    protected array $_accessible = [
            'product_id' => true,
            'operation_sequence' => true,
            'work_center_id' => true,
            'setup_time' => true,
            'run_time' => true,
            'operation_name' => true,
            'description' => true,
            'cost' => true,
            'id' => false
    ];
}
