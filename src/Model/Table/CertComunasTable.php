<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CertComunas Model
 *
 * @property \App\Model\Table\CertEmpresasTable&\Cake\ORM\Association\HasMany $CertEmpresas
 *
 * @method \App\Model\Entity\CertComuna get($primaryKey, $options = [])
 * @method \App\Model\Entity\CertComuna newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CertComuna[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CertComuna|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CertComuna saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CertComuna patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CertComuna[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CertComuna findOrCreate($search, callable $callback = null, $options = [])
 */
class CertComunasTable extends Table
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

        $this->setTable('cert_comunas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('CertEmpresas', [
            'foreignKey' => 'cert_comuna_id'
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
            ->maxLength('nombre', 500)
            ->allowEmptyString('nombre');

        return $validator;
    }
}
