<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class DeliveryNoteDetail extends Entity
{
    protected array $_accessible = [
            'delivery_note_id' => true,
            'product_id' => true,
            'quantity' => true,
            'unit_id' => true,
            'unit_price' => true,
            'amount' => true,
            'vat_rate' => true,
            'vat_amount' => true,
            'lot_number' => true,
            'sync_inv' => true,
            'id' => false
    ];
}
