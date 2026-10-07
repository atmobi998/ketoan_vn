<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Employee extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'full_name' => true,
            'gender' => true,
            'birth_date' => true,
            'phone' => true,
            'email' => true,
            'address' => true,
            'department_id' => true,
            'position_id' => true,
            'join_date' => true,
            'basic_salary' => true,
            'bonus' => true,
            'bank_account' => true,
            'bank_name' => true,
            'is_active' => true,
            'id' => false
    ];
}
