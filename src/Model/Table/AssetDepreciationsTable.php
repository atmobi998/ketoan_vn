<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AssetDepreciationsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('asset_depreciations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('FixedAssets', ['foreignKey' => 'fixed_asset_id', 'joinType' => 'LEFT']);
        $this->belongsTo('AccountingPeriods', ['foreignKey' => 'accounting_period_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('fixed_asset_id', 'Không được để trống');
        $validator->notEmptyString('depreciation_date', 'Không được để trống');
        $validator->notEmptyString('period', 'Không được để trống');
        $validator->notEmptyString('depreciation_amount', 'Không được để trống');
        $validator->notEmptyString('accumulated_depreciation', 'Không được để trống');
        $validator->notEmptyString('remaining_value', 'Không được để trống');
        return $validator;
    }
}
