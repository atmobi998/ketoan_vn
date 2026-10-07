<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class AssetCategory extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'depreciation_rate' => true,
            'useful_life_months' => true,
            'chart_account_asset' => true,
            'chart_account_depreciation' => true,
            'chart_account_expense' => true,
            'description' => true,
            'id' => false
    ];
}
