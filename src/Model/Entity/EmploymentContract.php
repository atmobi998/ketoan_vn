<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class EmploymentContract extends Entity
{
    protected array $_accessible = [
            'contract_number' => true,
            'employee_id' => true,
            'contract_type' => true,
            'start_date' => true,
            'end_date' => true,
            'salary' => true,
            'status' => true,
            'notes' => true,
            'id' => false
    ];
}
