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
            'UploadedPaymentFiles' => ['payment_count']
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Users', [
            'propertyName' => 'merchant',
            'class' => 'Users',
            'bindingKey' => 'id',
            'foreignKey' => 'merchant_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('UploadedPaymentFiles', [
            'foreignKey' => 'uploaded_payment_file_id',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator) {


        $validator
                ->integer('customer_code')
                ->requirePresence('customer_code', 'create')
                ->notEmpty('customer_code');

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

        $validator
                ->decimal('total_fee')
                ->requirePresence('total_fee', 'create')
                ->notEmpty('total_fee');

        $validator
                ->date('due_date')
                ->requirePresence('due_date', 'create')
                ->notEmpty('due_date');


        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
//        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['uploaded_payment_file_id'], 'UploadedPaymentFiles'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

}
