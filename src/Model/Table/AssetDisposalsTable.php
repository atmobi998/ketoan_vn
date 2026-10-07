<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AssetDisposalsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('asset_disposals');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('FixedAssets', ['foreignKey' => 'fixed_asset_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('fixed_asset_id', 'Không được để trống');
        $validator->notEmptyString('disposal_date', 'Không được để trống');
        $validator->notEmptyString('disposal_amount', 'Không được để trống');
        $validator->notEmptyString('loss_gain', 'Không được để trống');
        return $validator;
    }
}
