<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UploadedPaymentFilesTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('uploaded_payment_files');
        $this->displayField('title');

        $this->addBehavior('Timestamp');
       

//        $this->belongsTo('UserDetails', [
//            'bindingKey' => 'user_id',
//            'foreignKey' => 'merchant_id',
//            'joinType' => 'INNER'
//        ]);

        $this->hasMany('Payments', [
            'foreignKey' => 'uploaded_payment_file_id',
            'dependent' => TRUE
        ]);
    }

    public function validationDefault(Validator $validator) {

        $validator
                ->requirePresence('title', 'create')
                ->notEmpty('title');

        $validator
                ->requirePresence('note', 'create')
                ->notEmpty('note');

        return $validator;
    }

//    public function buildRules(RulesChecker $rules) {
//        $rules->add($rules->existsIn(['merchant_id'], 'Users'));
//        return $rules;
//    }

    public function beforeDelete($event, $entity, $options) {
        /**
         * Desc : Delete all payments        
         */
//        echo $entity->id;exit;
        return TRUE;
    }

}
