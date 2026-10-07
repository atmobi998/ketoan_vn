<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class AssetDepreciation extends Entity
{
    protected array $_accessible = [
            'fixed_asset_id' => true,
            'depreciation_date' => true,
            'period' => true,
            'depreciation_amount' => true,
            'accumulated_depreciation' => true,
            'remaining_value' => true,
            'accounting_period_id' => true,
            'id' => false
    ];
}
