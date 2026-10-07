<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PurchaseInvoiceDetailsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('purchase_invoice_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('PurchaseInvoices', ['foreignKey' => 'purchase_invoice_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Products', ['foreignKey' => 'product_id', 'joinType' => 'LEFT']);
        $this->belongsTo('ChartOfAccounts', ['foreignKey' => 'chart_of_account_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Units', ['foreignKey' => 'unit_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('purchase_invoice_id', 'Không được để trống');
        $validator->notEmptyString('product_id', 'Không được để trống');
        $validator->notEmptyString('quantity', 'Không được để trống');
        $validator->notEmptyString('unit_price', 'Không được để trống');
        $validator->notEmptyString('amount', 'Không được để trống');
        $validator->notEmptyString('vat_rate', 'Không được để trống');
        $validator->notEmptyString('vat_amount', 'Không được để trống');
        return $validator;
    }
}
