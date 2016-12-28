<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PaymentsTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('payments');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('CounterCache', [
            'UploadedPaymentFiles' => ['upload_count']
        ]);

        $this->belongsTo('Webfronts', [
            'foreignKey' => 'webfront_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('UploadedPaymentFiles', [
            'foreignKey' => 'uploaded_payment_file_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'customer_id',
            'joinType' => 'LEFT'
        ]);
    }

    public function validationDefault(Validator $validator) {

        $validator
                ->requirePresence('name', 'create')
                ->notEmpty('name');

        $validator
                ->email('email')
                ->requirePresence('email', 'create')
                ->notEmpty('email');

        $validator
                ->requirePresence('phone', 'create')
                ->notEmpty('phone');
//
//        $validator
//                ->decimal('convenience_fee_amount')
//                ->requirePresence('convenience_fee_amount', 'create')
//                ->notEmpty('convenience_fee_amount');
//
//        $validator
//                ->decimal('fee')
//                ->requirePresence('fee', 'create')
//                ->notEmpty('fee');


        return $validator;
    }

//    public function buildRules(RulesChecker $rules) {      
//        $rules->add($rules->existsIn(['uploaded_payment_file_id'], 'UploadedPaymentFiles'));
//        $rules->add($rules->existsIn(['customer_id'], 'Users'));
//
//        return $rules;
//    }
}
