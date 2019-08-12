<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CertEmpresa Entity
 *
 * @property int $id
 * @property string|null $rut
 * @property string|null $nombre
 *
 * @property \App\Model\Entity\CertEmpresasSetPrueba[] $cert_empresas_set_pruebas
 */
class CertEmpresa extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'rut' => true,
        'nombre' => true,
        'cert_empresas_set_pruebas' => true
    ];
}
