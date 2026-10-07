<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use ArrayObject;

class JournalEntriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('journal_entries');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('AccountingPeriods', ['foreignKey' => 'accounting_period_id', 'joinType' => 'LEFT']);
        $this->hasMany('JournalEntryLines');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('entry_number', 'Không được để trống');
        $validator->add('entry_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('entry_date', 'Không được để trống');
        $validator->notEmptyString('accounting_date', 'Không được để trống');
        $validator->notEmptyString('total_debit', 'Không được để trống');
        $validator->notEmptyString('total_credit', 'Không được để trống');
        $validator->notEmptyString('status', 'Không được để trống');
        return $validator;
    }

    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, $primary)
    {
        $query->orderBy(['JournalEntries.entry_number' => 'DESC']);
    }


}
