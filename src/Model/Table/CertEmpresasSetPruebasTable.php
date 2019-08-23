<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CertEmpresasSetPruebas Model
 *
 * @property \App\Model\Table\CertEmpresasTable&\Cake\ORM\Association\BelongsTo $CertEmpresas
 * @property \App\Model\Table\CertSetPruebasTable&\Cake\ORM\Association\BelongsTo $CertSetPruebas
 *
 * @method \App\Model\Entity\CertEmpresasSetPrueba get($primaryKey, $options = [])
 * @method \App\Model\Entity\CertEmpresasSetPrueba newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CertEmpresasSetPrueba[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CertEmpresasSetPrueba|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CertEmpresasSetPrueba saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CertEmpresasSetPrueba patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CertEmpresasSetPrueba[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CertEmpresasSetPrueba findOrCreate($search, callable $callback = null, $options = [])
 */
class CertEmpresasSetPruebasTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('cert_empresas_set_pruebas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CertEmpresas', [
            'foreignKey' => 'cert_empresa_id'
        ]);
        $this->belongsTo('CertSetPruebas', [
            'foreignKey' => 'cert_set_prueba_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('estado')
            ->maxLength('estado', 45)
            ->allowEmptyString('estado');

        $validator
            ->scalar('set_prueba_envio')
            ->maxLength('set_prueba_envio', 200)
            ->allowEmptyString('set_prueba_envio');

        $validator
            ->scalar('xml_envio')
            ->maxLength('xml_envio', 4294967295)
            ->allowEmptyString('xml_envio');

        $validator
            ->scalar('trackid_envio')
            ->maxLength('trackid_envio', 200)
            ->allowEmptyString('trackid_envio');

        $validator
            ->scalar('respuesta_envio')
            ->maxLength('respuesta_envio', 1000)
            ->allowEmptyString('respuesta_envio');

        $validator
            ->scalar('observaciones_envio')
            ->maxLength('observaciones_envio', 1000)
            ->allowEmptyString('observaciones_envio');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['cert_empresa_id'], 'CertEmpresas'));
        $rules->add($rules->existsIn(['cert_set_prueba_id'], 'CertSetPruebas'));

        return $rules;
    }
}
