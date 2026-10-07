<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class JournalEntry extends Entity
{
    protected array $_accessible = [
            'entry_number' => true,
            'entry_date' => true,
            'accounting_date' => true,
            'description' => true,
            'total_debit' => true,
            'total_credit' => true,
            'status' => true,
            'created_by' => true,
            'accounting_period_id' => true,
            'reference_type' => true,
            'reference_id' => true,
            'id' => false
    ];

    protected function _getFullName()
    {
        return $this->id . ' (' . $this->entry_number.')';
    }

}
