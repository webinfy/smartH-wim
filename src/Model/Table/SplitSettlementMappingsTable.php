<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SplitSettlementMappingsTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('split_settlement_mappings');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('SplitSettlements', [
            'foreignKey' => 'split_settlement_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('WebfrontPaymentAttributes', [
            'foreignKey' => 'webfront_payment_attribute_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('SubMerchants', [
            'foreignKey' => 'sub_merchant_id',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator) {
        //Code//
        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['split_settlement_id'], 'SplitSettlements'));
        $rules->add($rules->existsIn(['webfront_payment_attribute_id'], 'WebfrontPaymentAttributes'));
        $rules->add($rules->existsIn(['sub_merchant_id'], 'SubMerchants'));

        return $rules;
    }

}
