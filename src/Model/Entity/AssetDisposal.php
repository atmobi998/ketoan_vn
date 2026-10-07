<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class AssetDisposal extends Entity
{
    protected array $_accessible = [
            'fixed_asset_id' => true,
            'disposal_date' => true,
            'disposal_method' => true,
            'disposal_amount' => true,
            'loss_gain' => true,
            'reason' => true,
            'created_by' => true,
            'id' => false
    ];
}
