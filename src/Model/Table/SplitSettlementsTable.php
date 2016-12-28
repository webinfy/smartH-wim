<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SplitSettlementsTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('split_settlements');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'merchant_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Webfronts', [
            'foreignKey' => 'webfront_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('SplitSettlementMappings', [
            'foreignKey' => 'split_settlement_id',
            'dependent' => TRUE
        ]);
    }

    public function validationDefault(Validator $validator) {
        //Code//
        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['merchant_id'], 'Users'));
        $rules->add($rules->existsIn(['webfront_id'], 'Webfronts'));

        return $rules;
    }

}
