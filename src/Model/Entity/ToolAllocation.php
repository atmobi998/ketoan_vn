<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class ToolAllocation extends Entity
{
    protected array $_accessible = [
            'tool_id' => true,
            'employee_id' => true,
            'department_id' => true,
            'allocation_date' => true,
            'quantity' => true,
            'amount' => true,
            'monthly_allocation' => true,
            'remaining_months' => true,
            'status' => true,
            'notes' => true,
            'id' => false
    ];
}
