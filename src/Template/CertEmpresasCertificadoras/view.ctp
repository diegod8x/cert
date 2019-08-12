<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CertEmpresasCertificadora $certEmpresasCertificadora
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cert Empresas Certificadora'), ['action' => 'edit', $certEmpresasCertificadora->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cert Empresas Certificadora'), ['action' => 'delete', $certEmpresasCertificadora->id], ['confirm' => __('Are you sure you want to delete # {0}?', $certEmpresasCertificadora->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cert Empresas Certificadoras'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cert Empresas Certificadora'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="certEmpresasCertificadoras view large-9 medium-8 columns content">
    <h3><?= h($certEmpresasCertificadora->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($certEmpresasCertificadora->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estado') ?></th>
            <td><?= h($certEmpresasCertificadora->estado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($certEmpresasCertificadora->id) ?></td>
        </tr>
    </table>
</div>
