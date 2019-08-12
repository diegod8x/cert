<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CertEmpresasSetPrueba $certEmpresasSetPrueba
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $certEmpresasSetPrueba->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $certEmpresasSetPrueba->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Cert Empresas Set Pruebas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cert Empresas'), ['controller' => 'CertEmpresas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cert Empresa'), ['controller' => 'CertEmpresas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cert Set Pruebas'), ['controller' => 'CertSetPruebas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cert Set Prueba'), ['controller' => 'CertSetPruebas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="certEmpresasSetPruebas form large-9 medium-8 columns content">
    <?= $this->Form->create($certEmpresasSetPrueba) ?>
    <fieldset>
        <legend><?= __('Edit Cert Empresas Set Prueba') ?></legend>
        <?php
            echo $this->Form->control('cert_empresa_id', ['options' => $certEmpresas, 'empty' => true]);
            echo $this->Form->control('cert_set_prueba_id', ['options' => $certSetPruebas, 'empty' => true]);
            echo $this->Form->control('estado');
            echo $this->Form->control('trackid');
            echo $this->Form->control('respuesta_envio');
            echo $this->Form->control('xml_envio');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
