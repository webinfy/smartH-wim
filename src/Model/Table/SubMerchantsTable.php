<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SubMerchantsTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('sub_merchants');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'merchant_id',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator) {

        $validator
                ->requirePresence('name', 'create')
                ->notEmpty('name');
        $validator
                ->requirePresence('email', 'create')
                ->notEmpty('email');
        $validator
                ->requirePresence('payumid', 'create')
                ->notEmpty('payumid');


        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
//        $rules->add($rules->isUnique(['payumid']));
        $rules->add($rules->existsIn(['merchant_id'], 'Users'));
        return $rules;
    }

}
