<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CashReceipt extends Entity
{
    protected array $_accessible = [
            'voucher_number' => true,
            'voucher_date' => true,
            'accounting_date' => true,
            'payer_name' => true,
            'reason' => true,
            'chart_of_account_id' => true,
            'bank_account_id' => true,
            'currency_id' => true,
            'amount' => true,
            'exchange_rate' => true,
            'amount_vnd' => true,
            'status' => true,
            'created_by' => true,
            'accounting_period_id' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->id . ' (' . $this->voucher_number.')';
    }


}
