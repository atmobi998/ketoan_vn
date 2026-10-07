<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class SalesInvoiceDetail extends Entity
{
    protected array $_accessible = [
            'sales_invoice_id' => true,
            'product_id' => true,
            'quantity' => true,
            'unit_id' => true,
            'unit_price' => true,
            'amount' => true,
            'vat_rate' => true,
            'vat_amount' => true,
            'chart_of_account_id' => true,
            'id' => false
    ];
}
