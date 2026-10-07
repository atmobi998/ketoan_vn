<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CashReceiptDetail extends Entity
{
    protected array $_accessible = [
            'cash_receipt_id' => true,
            'description' => true,
            'chart_of_account_id' => true,
            'amount' => true,
            'cost_center_id' => true,
            'id' => false
    ];
}
