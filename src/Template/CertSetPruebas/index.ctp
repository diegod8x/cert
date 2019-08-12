<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CertSetPrueba[]|\Cake\Collection\CollectionInterface $certSetPruebas
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Cert Set Prueba'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cert Empresas Set Pruebas'), ['controller' => 'CertEmpresasSetPruebas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cert Empresas Set Prueba'), ['controller' => 'CertEmpresasSetPruebas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="certSetPruebas index large-9 medium-8 columns content">
    <h3><?= __('Cert Set Pruebas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($certSetPruebas as $certSetPrueba): ?>
            <tr>
                <td><?= $this->Number->format($certSetPrueba->id) ?></td>
                <td><?= h($certSetPrueba->nombre) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $certSetPrueba->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $certSetPrueba->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $certSetPrueba->id], ['confirm' => __('Are you sure you want to delete # {0}?', $certSetPrueba->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
