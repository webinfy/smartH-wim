<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WebfrontFields Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Webfronts
 * @property \Cake\ORM\Association\BelongsTo $Validations
 * @property \Cake\ORM\Association\HasMany $WebfrontFieldValues
 *
 * @method \App\Model\Entity\WebfrontField get($primaryKey, $options = [])
 * @method \App\Model\Entity\WebfrontField newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WebfrontField[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WebfrontField|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WebfrontField patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WebfrontField[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WebfrontField findOrCreate($search, callable $callback = null)
 */
class WebfrontFieldsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('webfront_fields');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Webfronts', [
            'foreignKey' => 'webfront_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Validations', [
            'foreignKey' => 'validation_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('WebfrontFieldValues', [
            'foreignKey' => 'webfront_field_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->integer('id')
                ->allowEmpty('id', 'create');

        $validator
                ->requirePresence('name', 'create')
                ->notEmpty('name');

        $validator
                ->integer('is_mandatory')
                ->requirePresence('is_mandatory', 'create')
                ->notEmpty('is_mandatory');

        $validator
                ->integer('input_type')
                ->requirePresence('input_type', 'create')
                ->notEmpty('input_type');


        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['webfront_id'], 'Webfronts'));
        $rules->add($rules->existsIn(['validation_id'], 'Validations'));

        return $rules;
    }

}
