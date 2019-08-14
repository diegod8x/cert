<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CertEmpresasSetPrueba[]|\Cake\Collection\CollectionInterface $certEmpresasSetPruebas
 */
?>
<?= $this->element('nav') ?>
<div class="certEmpresasSetPruebas index large-9 medium-8 columns content">
    <h3><?= __('Empresas Set de Pruebas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cert_empresa_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cert_set_prueba_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('estado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('trackid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('respuesta_envio') ?></th>
                <th scope="col"><?= $this->Paginator->sort('xml_envio') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($certEmpresasSetPruebas as $certEmpresasSetPrueba): ?>
            <tr>
                <td><?= $this->Number->format($certEmpresasSetPrueba->id) ?></td>
                <td><?= $certEmpresasSetPrueba->has('cert_empresa') ? $this->Html->link($certEmpresasSetPrueba->cert_empresa->id, ['controller' => 'CertEmpresas', 'action' => 'view', $certEmpresasSetPrueba->cert_empresa->id]) : '' ?></td>
                <td><?= $certEmpresasSetPrueba->has('cert_set_prueba') ? $this->Html->link($certEmpresasSetPrueba->cert_set_prueba->id, ['controller' => 'CertSetPruebas', 'action' => 'view', $certEmpresasSetPrueba->cert_set_prueba->id]) : '' ?></td>
                <td><?= h($certEmpresasSetPrueba->estado) ?></td>
                <td><?= h($certEmpresasSetPrueba->trackid) ?></td>
                <td><?= h($certEmpresasSetPrueba->respuesta_envio) ?></td>
                <td><?= h($certEmpresasSetPrueba->xml_envio) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $certEmpresasSetPrueba->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $certEmpresasSetPrueba->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $certEmpresasSetPrueba->id], ['confirm' => __('Are you sure you want to delete # {0}?', $certEmpresasSetPrueba->id)]) ?>
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
