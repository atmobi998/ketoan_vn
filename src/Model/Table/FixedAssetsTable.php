<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FixedAssetsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('fixed_assets');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('AssetCategories', ['foreignKey' => 'asset_category_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Employees', ['foreignKey' => 'employee_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Departments', ['foreignKey' => 'department_id', 'joinType' => 'LEFT']);
        $this->belongsTo('ChartOfAccounts', ['foreignKey' => 'chart_of_account_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('code', 'Không được để trống');
        $validator->add('code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('name', 'Không được để trống');
        $validator->notEmptyString('asset_category_id', 'Không được để trống');
        $validator->notEmptyString('acquisition_date', 'Không được để trống');
        $validator->notEmptyString('original_cost', 'Không được để trống');
        $validator->notEmptyString('useful_life', 'Không được để trống');
        $validator->notEmptyString('depreciation_method', 'Không được để trống');
        $validator->notEmptyString('accumulated_depreciation', 'Không được để trống');
        $validator->notEmptyString('remaining_value', 'Không được để trống');
        $validator->notEmptyString('status', 'Không được để trống');
        return $validator;
    }
}
