<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Query\SelectQuery;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Departments', ['foreignKey' => 'department_id', 'joinType' => 'LEFT']);
        $this->hasMany('CashReceipts');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('username', 'Không được để trống');
        $validator->notEmptyString('email', 'Không được để trống');
        $validator->email('email');
        $validator->notEmptyString('password', 'Không được để trống');
        $validator->notEmptyString('full_name', 'Không được để trống');
        $validator->notEmptyString('role', 'Không được để trống');
        $validator->notEmptyString('is_active', 'Không được để trống');
        return $validator;
    }

    public function findAuthUser(SelectQuery $query, array $options): SelectQuery
    {
        return $query
            // ->contain(['Roles']) 
            ->where(['Users.is_active' => 1]); 
    }

}
