<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CertEmpresasCertificadora $certEmpresasCertificadora
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $certEmpresasCertificadora->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $certEmpresasCertificadora->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Cert Empresas Certificadoras'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="certEmpresasCertificadoras form large-9 medium-8 columns content">
    <?= $this->Form->create($certEmpresasCertificadora) ?>
    <fieldset>
        <legend><?= __('Edit Cert Empresas Certificadora') ?></legend>
        <?php
            echo $this->Form->control('nombre');
            echo $this->Form->control('estado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
