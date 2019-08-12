<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CertSetPrueba $certSetPrueba
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cert Set Prueba'), ['action' => 'edit', $certSetPrueba->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cert Set Prueba'), ['action' => 'delete', $certSetPrueba->id], ['confirm' => __('Are you sure you want to delete # {0}?', $certSetPrueba->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cert Set Pruebas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cert Set Prueba'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cert Empresas Set Pruebas'), ['controller' => 'CertEmpresasSetPruebas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cert Empresas Set Prueba'), ['controller' => 'CertEmpresasSetPruebas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="certSetPruebas view large-9 medium-8 columns content">
    <h3><?= h($certSetPrueba->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($certSetPrueba->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($certSetPrueba->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Cert Empresas Set Pruebas') ?></h4>
        <?php if (!empty($certSetPrueba->cert_empresas_set_pruebas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Cert Empresa Id') ?></th>
                <th scope="col"><?= __('Cert Set Prueba Id') ?></th>
                <th scope="col"><?= __('Estado') ?></th>
                <th scope="col"><?= __('Track Id') ?></th>
                <th scope="col"><?= __('Respuesta Envio') ?></th>
                <th scope="col"><?= __('Xml Envio') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($certSetPrueba->cert_empresas_set_pruebas as $certEmpresasSetPruebas): ?>
            <tr>
                <td><?= h($certEmpresasSetPruebas->id) ?></td>
                <td><?= h($certEmpresasSetPruebas->cert_empresa_id) ?></td>
                <td><?= h($certEmpresasSetPruebas->cert_set_prueba_id) ?></td>
                <td><?= h($certEmpresasSetPruebas->estado) ?></td>
                <td><?= h($certEmpresasSetPruebas->trackid) ?></td>
                <td><?= h($certEmpresasSetPruebas->respuesta_envio) ?></td>
                <td><?= h($certEmpresasSetPruebas->xml_envio) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CertEmpresasSetPruebas', 'action' => 'view', $certEmpresasSetPruebas->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CertEmpresasSetPruebas', 'action' => 'edit', $certEmpresasSetPruebas->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CertEmpresasSetPruebas', 'action' => 'delete', $certEmpresasSetPruebas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $certEmpresasSetPruebas->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
