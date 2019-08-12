<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CertEmpresasCertificadoras Model
 *
 * @method \App\Model\Entity\CertEmpresasCertificadora get($primaryKey, $options = [])
 * @method \App\Model\Entity\CertEmpresasCertificadora newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CertEmpresasCertificadora[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CertEmpresasCertificadora|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CertEmpresasCertificadora saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CertEmpresasCertificadora patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CertEmpresasCertificadora[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CertEmpresasCertificadora findOrCreate($search, callable $callback = null, $options = [])
 */
class CertEmpresasCertificadorasTable extends Table
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

        $this->setTable('cert_empresas_certificadoras');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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

        $validator
            ->scalar('estado')
            ->maxLength('estado', 45)
            ->allowEmptyString('estado');

        return $validator;
    }
}
