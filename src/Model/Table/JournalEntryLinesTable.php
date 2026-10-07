<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use ArrayObject;

class JournalEntryLinesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('journal_entry_lines');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('JournalEntries', ['foreignKey' => 'journal_entry_id', 'joinType' => 'LEFT']);
        $this->belongsTo('ChartOfAccounts', ['foreignKey' => 'chart_of_account_id', 'joinType' => 'LEFT']);
        $this->belongsTo('CostCenters', ['foreignKey' => 'cost_center_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Customers', ['foreignKey' => 'customer_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Suppliers', ['foreignKey' => 'supplier_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Products', ['foreignKey' => 'product_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Employees', ['foreignKey' => 'employee_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('journal_entry_id', 'Không được để trống');
        $validator->notEmptyString('chart_of_account_id', 'Không được để trống');
        $validator->notEmptyString('debit', 'Không được để trống');
        $validator->notEmptyString('credit', 'Không được để trống');
        return $validator;
    }

    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, $primary)
    {
        $query->orderBy(['JournalEntryLines.journal_entry_id' => 'DESC']);
    }


}
