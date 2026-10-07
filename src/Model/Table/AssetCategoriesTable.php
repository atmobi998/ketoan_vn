<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AssetCategoriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('asset_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('code', 'Không được để trống');
        $validator->add('code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('name', 'Không được để trống');
        $validator->notEmptyString('depreciation_rate', 'Không được để trống');
        $validator->notEmptyString('useful_life_months', 'Không được để trống');
        return $validator;
    }
}
