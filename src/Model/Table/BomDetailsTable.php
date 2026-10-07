<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BomDetailsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('bom_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Boms', ['foreignKey' => 'bom_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Products', ['foreignKey' => 'material_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Units', ['foreignKey' => 'unit_id', 'joinType' => 'LEFT']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('bom_id', 'Không được để trống');
        $validator->notEmptyString('material_id', 'Không được để trống');
        $validator->notEmptyString('quantity', 'Không được để trống');
        $validator->notEmptyString('waste_rate', 'Không được để trống');
        $validator->notEmptyString('unit_cost', 'Không được để trống');
        $validator->notEmptyString('total_cost', 'Không được để trống');
        return $validator;
    }
}
