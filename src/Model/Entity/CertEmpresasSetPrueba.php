<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CertEmpresasSetPrueba Entity
 *
 * @property int $id
 * @property int|null $cert_empresa_id
 * @property int|null $cert_set_prueba_id
 * @property string|null $estado
 * @property string|null $trackid
 * @property string|null $respuesta_envio
 * @property string|null $xml_envio
 *
 * @property \App\Model\Entity\CertEmpresa $cert_empresa
 * @property \App\Model\Entity\CertSetPrueba $cert_set_prueba
 */
class CertEmpresasSetPrueba extends Entity
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
        'cert_empresa_id' => true,
        'cert_set_prueba_id' => true,
        'estado' => true,
        'trackid' => true,
        'respuesta_envio' => true,
        'xml_envio' => true,
        'cert_empresa' => true,
        'cert_set_prueba' => true
    ];
}
