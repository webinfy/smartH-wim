<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class WebfrontsTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('webfronts');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'merchant_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('MerchantProfiles', [
            'foreignKey' => 'merchant_id',
            'bindingKey' => 'merchant_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('Payments', [
            'foreignKey' => 'webfront_id',
            'dependent' => TRUE
        ]);

        $this->hasMany('WebfrontFields', [
            'foreignKey' => 'webfront_id',
            'dependent' => TRUE
        ]);
    }

    public function validationDefault(Validator $validator) {

        $validator
                ->requirePresence('url', 'create')
                ->notEmpty('url');

        $validator
                ->email('email')
                ->requirePresence('email', 'create')
                ->notEmpty('email');

        $validator
                ->requirePresence('phone', 'create')
                ->notEmpty('phone');

        $validator
                ->requirePresence('title', 'create')
                ->notEmpty('title');

        $validator
                ->requirePresence('description', 'create')
                ->notEmpty('description');



        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->isUnique(['url']));
        $rules->add($rules->existsIn(['merchant_id'], 'Users'));
        return $rules;
    }

}
