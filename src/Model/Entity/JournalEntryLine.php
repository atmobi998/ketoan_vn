<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class JournalEntryLine extends Entity
{
    protected array $_accessible = [
            'journal_entry_id' => true,
            'chart_of_account_id' => true,
            'debit' => true,
            'credit' => true,
            'description' => true,
            'cost_center_id' => true,
            'customer_id' => true,
            'supplier_id' => true,
            'product_id' => true,
            'employee_id' => true,
            'id' => false
    ];
}
