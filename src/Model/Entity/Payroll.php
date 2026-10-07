<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Payroll extends Entity
{
    protected array $_accessible = [
            'payroll_code' => true,
            'payroll_month' => true,
            'payroll_year' => true,
            'department_id' => true,
            'total_employees' => true,
            'total_amount' => true,
            'total_deduction' => true,
            'insurance_deduction' => true,
            'tax_deduction' => true,
            'total_net' => true,
            'status' => true,
            'created_by' => true,
            'accounting_period_id' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->id . ' (' . $this->payroll_code.')';
    }
    
}
