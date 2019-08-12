<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CertEmpresa $certEmpresa
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cert Empresa'), ['action' => 'edit', $certEmpresa->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cert Empresa'), ['action' => 'delete', $certEmpresa->id], ['confirm' => __('Are you sure you want to delete # {0}?', $certEmpresa->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cert Empresas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cert Empresa'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cert Empresas Set Pruebas'), ['controller' => 'CertEmpresasSetPruebas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cert Empresas Set Prueba'), ['controller' => 'CertEmpresasSetPruebas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="certEmpresas view large-9 medium-8 columns content">
    <h3><?= h($certEmpresa->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Rut') ?></th>
            <td><?= h($certEmpresa->rut) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($certEmpresa->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($certEmpresa->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Cert Empresas Set Pruebas') ?></h4>
        <?php if (!empty($certEmpresa->cert_empresas_set_pruebas)): ?>
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
            <?php foreach ($certEmpresa->cert_empresas_set_pruebas as $certEmpresasSetPruebas): ?>
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
