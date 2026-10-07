<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ToolAllocationsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('tool_allocations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Tools', ['foreignKey' => 'tool_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Departments', ['foreignKey' => 'department_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Employees', ['foreignKey' => 'employee_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('tool_id', 'Không được để trống');
        $validator->notEmptyString('allocation_date', 'Không được để trống');
        $validator->notEmptyString('quantity', 'Không được để trống');
        $validator->notEmptyString('amount', 'Không được để trống');
        $validator->notEmptyString('monthly_allocation', 'Không được để trống');
        $validator->notEmptyString('remaining_months', 'Không được để trống');
        $validator->notEmptyString('status', 'Không được để trống');
        return $validator;
    }
}
