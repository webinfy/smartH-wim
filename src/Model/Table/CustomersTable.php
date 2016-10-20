<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CustomersTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('customers');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');


        $this->belongsTo('CustomerGroups', [
            'foreignKey' => 'customer_group_id',
            'joinType' => 'INNER'
        ]);
      
    }

    public function validationDefault(Validator $validator) {


        $validator
                ->requirePresence('name', 'create')
                ->notEmpty('name');



//        $validator
//                ->requirePresence('phone', 'create')
//                ->notEmpty('phone');


        return $validator;
    }

    public function buildRules(RulesChecker $rules) {

//        $rules->add($rules->existsIn(['merchant_id'], 'Merchants'));

        return $rules;
    }

}
