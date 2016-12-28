<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class UsersTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('email');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasOne('MerchantProfiles', [
            'foreignKey' => 'merchant_id',
            'conditions' => ['Users.type' => 3],
            'joinType' => 'LEFT',
            'dependent' => TRUE
        ]);
    }

    public function validationDefault(Validator $validator) {

//        $validator
//                ->requirePresence('name', 'create')
//                ->notEmpty('name');
//
//        $validator
//                ->email('email')
//                ->requirePresence('email', 'create')
//                ->notEmpty('email');

//        $validator
//                ->requirePresence('phone', 'create')
//                ->notEmpty('phone');


        return $validator;
    }

//    public function buildRules(RulesChecker $rules) {
//        $rules->add($rules->isUnique(['email']));
//        $rules->add($rules->isUnique(['phone']));
//        return $rules;
//    }

    public function validationPassword(Validator $validator) {

        $validator
                ->add('old_password', 'custom', [
                    'rule' => function($value, $context) {
                        $user = $this->get($context['data']['id']);
                        if ($user) {
                            if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                                return true;
                            }
                        }
                        return false;
                    },
                    'message' => 'The old password does not match the current password!',
                ])
                ->notEmpty('old_password');

        $validator
                ->add('password1', [
                    'length' => [
                        'rule' => ['minLength', 6],
                        'message' => 'The password have to be at least 6 characters!',
                    ]
                ])
                ->add('password1', [
                    'match' => [
                        'rule' => ['compareWith', 'password2'],
                        'message' => 'The passwords does not match!',
                    ]
                ])
                ->notEmpty('password1');
        $validator
                ->add('password2', [
                    'length' => [
                        'rule' => ['minLength', 6],
                        'message' => 'The password have to be at least 6 characters!',
                    ]
                ])
                ->add('password2', [
                    'match' => [
                        'rule' => ['compareWith', 'password1'],
                        'message' => 'The passwords does not match!',
                    ]
                ])
                ->notEmpty('password2');

        return $validator;
    }

}
