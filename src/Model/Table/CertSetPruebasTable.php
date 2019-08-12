<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CertSetPruebas Model
 *
 * @property \App\Model\Table\CertEmpresasSetPruebasTable&\Cake\ORM\Association\HasMany $CertEmpresasSetPruebas
 *
 * @method \App\Model\Entity\CertSetPrueba get($primaryKey, $options = [])
 * @method \App\Model\Entity\CertSetPrueba newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CertSetPrueba[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CertSetPrueba|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CertSetPrueba saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CertSetPrueba patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CertSetPrueba[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CertSetPrueba findOrCreate($search, callable $callback = null, $options = [])
 */
class CertSetPruebasTable extends Table
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

        $this->setTable('cert_set_pruebas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('CertEmpresasSetPruebas', [
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
            ->scalar('nombre')
            ->maxLength('nombre', 45)
            ->allowEmptyString('nombre');

        return $validator;
    }
}
