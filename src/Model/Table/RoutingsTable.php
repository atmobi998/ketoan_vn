<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class RoutingsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('routings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Products', ['foreignKey' => 'product_id', 'joinType' => 'LEFT']);
        $this->belongsTo('WorkCenters', ['foreignKey' => 'work_center_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('product_id', 'Không được để trống');
        $validator->notEmptyString('operation_sequence', 'Không được để trống');
        $validator->notEmptyString('work_center_id', 'Không được để trống');
        $validator->notEmptyString('setup_time', 'Không được để trống');
        $validator->notEmptyString('run_time', 'Không được để trống');
        $validator->notEmptyString('operation_name', 'Không được để trống');
        $validator->notEmptyString('cost', 'Không được để trống');
        return $validator;
    }
}
