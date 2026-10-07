<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class SupplierDebt extends Entity
{
    protected array $_accessible = [
            'supplier_id' => true,
            'document_type' => true,
            'document_id' => true,
            'document_number' => true,
            'document_date' => true,
            'due_date' => true,
            'amount' => true,
            'paid_amount' => true,
            'remaining_amount' => true,
            'status' => true,
            'id' => false
    ];
}
