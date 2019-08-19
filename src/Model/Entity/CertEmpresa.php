<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CertEmpresa Entity
 *
 * @property int $id
 * @property string|null $rut
 * @property string|null $nombre
 * @property string|null $giro
 * @property string|null $direccion
 * @property int|null $cert_comuna_id
 * @property string|null $actividad
 * @property string|null $certificado
 * @property string|null $pass_firma
 * @property string|null $fecha_resolucion
 * @property int|null $numero_resolucion
 *
 * @property \App\Model\Entity\CertComuna $cert_comuna
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
        'giro' => true,
        'direccion' => true,
        'cert_comuna_id' => true,
        'actividad' => true,
        'certificado' => true,
        'pass_firma' => true,
        'fecha_resolucion' => true,
        'numero_resolucion' => true,
        'cert_comuna' => true,
        'cert_empresas_set_pruebas' => true
    ];
}
