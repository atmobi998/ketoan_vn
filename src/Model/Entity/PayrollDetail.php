<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class PayrollDetail extends Entity
{
    protected array $_accessible = [
            'payroll_id' => true,
            'employee_id' => true,
            'basic_salary' => true,
            'allowance' => true,
            'overtime_amount' => true,
            'bonus' => true,
            'insurance_deduction' => true,
            'tax_deduction' => true,
            'other_deduction' => true,
            'net_salary' => true,
            'notes' => true,
            'id' => false
    ];
}
