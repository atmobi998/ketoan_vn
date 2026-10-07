<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ToolsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('tools');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('ToolCategories', ['foreignKey' => 'tool_category_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Units', ['foreignKey' => 'unit_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('code', 'Không được để trống');
        $validator->add('code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('name', 'Không được để trống');
        $validator->notEmptyString('tool_category_id', 'Không được để trống');
        $validator->notEmptyString('quantity', 'Không được để trống');
        $validator->notEmptyString('unit_price', 'Không được để trống');
        $validator->notEmptyString('total_value', 'Không được để trống');
        $validator->notEmptyString('allocation_months', 'Không được để trống');
        $validator->notEmptyString('remaining_value', 'Không được để trống');
        $validator->notEmptyString('status', 'Không được để trống');
        return $validator;
    }
}
