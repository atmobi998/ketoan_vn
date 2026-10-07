<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class BankPayment extends Entity
{
    protected array $_accessible = [
            'voucher_number' => true,
            'voucher_date' => true,
            'accounting_date' => true,
            'payee_name' => true,
            'reason' => true,
            'bank_account_id' => true,
            'chart_of_account_id' => true,
            'currency_id' => true,
            'amount' => true,
            'exchange_rate' => true,
            'amount_vnd' => true,
            'status' => true,
            'created_by' => true,
            'accounting_period_id' => true,
            'id' => false
    ];
}
