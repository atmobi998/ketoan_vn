<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Attendance extends Entity
{
    protected array $_accessible = [
            'employee_id' => true,
            'work_date' => true,
            'check_in' => true,
            'check_out' => true,
            'work_hours' => true,
            'overtime_hours' => true,
            'status' => true,
            'notes' => true,
            'id' => false
    ];
}
