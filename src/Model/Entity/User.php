<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class User extends Entity
{
    protected array $_accessible = [
            'username' => true,
            'email' => true,
            'password' => true,
            'full_name' => true,
            'role' => true,
            'department_id' => true,
            'is_active' => true,
            'last_login' => true,
            'id' => false
    ];
}
