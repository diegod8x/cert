<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CertEmpresa $certEmpresa
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Cert Empresas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cert Empresas Set Pruebas'), ['controller' => 'CertEmpresasSetPruebas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cert Empresas Set Prueba'), ['controller' => 'CertEmpresasSetPruebas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="certEmpresas form large-9 medium-8 columns content">
    <?= $this->Form->create($certEmpresa) ?>
    <fieldset>
        <legend><?= __('Add Cert Empresa') ?></legend>
        <?php
            echo $this->Form->control('rut');
            echo $this->Form->control('nombre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
