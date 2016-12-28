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
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('CounterCache', [
            'Webfronts' => ['uploaded_payment_file_count']
        ]);

        $this->belongsTo('Webfronts', [
            'foreignKey' => 'webfront_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Payments', [
            'dependent' => TRUE
        ]);
    }

    public function validationDefault(Validator $validator) {


        $validator
                ->date('payment_cycle_date')
                ->notEmpty('payment_cycle_date');

        $validator
                ->requirePresence('file', 'create')
                ->notEmpty('file');


        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['webfront_id'], 'Webfronts'));
        return $rules;
    }

}
