<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class MerchantProfilesTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('merchant_profiles');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'merchant_id',
            'joinType' => 'INNER'
        ]);
    }

    public function beforeDelete($event, $entity, $options) {
        if (is_file(WWW_ROOT . MERCHANT_LOGO . $entity->logo) && file_exists(WWW_ROOT . MERCHANT_LOGO . $entity->logo)) {
            unlink(WWW_ROOT . MERCHANT_LOGO . $entity->logo);
        }
    }

    public function validationDefault(Validator $validator) {

//        $validator
//                ->requirePresence('logo', 'create')
//                ->notEmpty('logo');

        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }

}
