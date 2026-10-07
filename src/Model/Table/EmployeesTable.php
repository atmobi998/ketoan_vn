<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use ArrayObject;

class EmployeesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('employees');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Departments', ['foreignKey' => 'department_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Positions', ['foreignKey' => 'position_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('code', 'Không được để trống');
        $validator->add('code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('full_name', 'Không được để trống');
        $validator->notEmptyString('gender', 'Không được để trống');
        $validator->email('email');
        $validator->notEmptyString('basic_salary', 'Không được để trống');
        $validator->notEmptyString('is_active', 'Không được để trống');
        return $validator;
    }

    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, $primary)
    {
        $query->orderBy(['Employees.full_name' => 'ASC']);
    }

}
