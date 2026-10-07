<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class FixedAsset extends Entity
{
    protected array $_accessible = [
            'code' => true,
            'name' => true,
            'asset_category_id' => true,
            'acquisition_date' => true,
            'original_cost' => true,
            'useful_life' => true,
            'depreciation_method' => true,
            'accumulated_depreciation' => true,
            'remaining_value' => true,
            'location' => true,
            'status' => true,
            'employee_id' => true,
            'department_id' => true,
            'chart_of_account_id' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->name . ' (' . $this->code.')';
    }


}
