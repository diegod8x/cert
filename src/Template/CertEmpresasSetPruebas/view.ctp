<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CertEmpresasSetPrueba $certEmpresasSetPrueba
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cert Empresas Set Prueba'), ['action' => 'edit', $certEmpresasSetPrueba->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cert Empresas Set Prueba'), ['action' => 'delete', $certEmpresasSetPrueba->id], ['confirm' => __('Are you sure you want to delete # {0}?', $certEmpresasSetPrueba->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cert Empresas Set Pruebas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cert Empresas Set Prueba'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cert Empresas'), ['controller' => 'CertEmpresas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cert Empresa'), ['controller' => 'CertEmpresas', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cert Set Pruebas'), ['controller' => 'CertSetPruebas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cert Set Prueba'), ['controller' => 'CertSetPruebas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="certEmpresasSetPruebas view large-9 medium-8 columns content">
    <h3><?= h($certEmpresasSetPrueba->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Cert Empresa') ?></th>
            <td><?= $certEmpresasSetPrueba->has('cert_empresa') ? $this->Html->link($certEmpresasSetPrueba->cert_empresa->id, ['controller' => 'CertEmpresas', 'action' => 'view', $certEmpresasSetPrueba->cert_empresa->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cert Set Prueba') ?></th>
            <td><?= $certEmpresasSetPrueba->has('cert_set_prueba') ? $this->Html->link($certEmpresasSetPrueba->cert_set_prueba->id, ['controller' => 'CertSetPruebas', 'action' => 'view', $certEmpresasSetPrueba->cert_set_prueba->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estado') ?></th>
            <td><?= h($certEmpresasSetPrueba->estado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Set Prueba Envio') ?></th>
            <td><?= h($certEmpresasSetPrueba->set_prueba_envio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Xml Envio') ?></th>
            <td><?= h($certEmpresasSetPrueba->xml_envio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Trackid Envio') ?></th>
            <td><?= h($certEmpresasSetPrueba->trackid_envio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Respuesta Envio') ?></th>
            <td><?= h($certEmpresasSetPrueba->respuesta_envio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Observaciones Envio') ?></th>
            <td><?= h($certEmpresasSetPrueba->observaciones_envio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($certEmpresasSetPrueba->id) ?></td>
        </tr>
    </table>
</div>
