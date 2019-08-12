<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CertEmpresas Model
 *
 * @property \App\Model\Table\CertEmpresasSetPruebasTable&\Cake\ORM\Association\HasMany $CertEmpresasSetPruebas
 *
 * @method \App\Model\Entity\CertEmpresa get($primaryKey, $options = [])
 * @method \App\Model\Entity\CertEmpresa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CertEmpresa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CertEmpresa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CertEmpresa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CertEmpresa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CertEmpresa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CertEmpresa findOrCreate($search, callable $callback = null, $options = [])
 */
class CertEmpresasTable extends Table
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

        $this->setTable('cert_empresas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('CertEmpresasSetPruebas', [
            'foreignKey' => 'cert_empresa_id'
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
            ->scalar('rut')
            ->maxLength('rut', 45)
            ->allowEmptyString('rut');

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 45)
            ->allowEmptyString('nombre');

        return $validator;
    }
}
