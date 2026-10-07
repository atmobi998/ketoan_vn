<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use ArrayObject;

class PositionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('positions');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('code', 'Không được để trống');
        $validator->add('code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Đã tồn tại']);
        $validator->notEmptyString('name', 'Không được để trống');
        $validator->notEmptyString('base_salary', 'Không được để trống');
        return $validator;
    }

    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, $primary)
    {
        $query->orderBy(['Positions.code' => 'ASC']);
    }


}
