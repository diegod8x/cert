<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CertEmpresasSetPrueba[]|\Cake\Collection\CollectionInterface $certEmpresasSetPruebas
 */
?>
<?= $this->element('nav') ?>
<div class="certEmpresasSetPruebas index large-9 medium-8 columns content">
    <h3><?= __('Empresas Set Pruebas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <!-- >th scope="col"><?= $this->Paginator->sort('id') ?></th-->
                <th scope="col"><?= $this->Paginator->sort('empresa') ?></th>
                <th scope="col"><?= $this->Paginator->sort('set_prueba') ?></th>
                <!--th scope="col"><?= $this->Paginator->sort('estado') ?></th-->
                <!-- >th scope="col"><?= $this->Paginator->sort('set_prueba_envio') ?></th-->
                <th scope="col"><?= $this->Paginator->sort('xml') ?></th>
                <th scope="col"><?= $this->Paginator->sort('trackid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('respuesta') ?></th>
                <th scope="col"><?= $this->Paginator->sort('observaciones') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($certEmpresasSetPruebas as $certEmpresasSetPrueba): ?>
            <tr>
                <!-- td><?= $this->Number->format($certEmpresasSetPrueba->id) ?></td-->
                <td><?= $certEmpresasSetPrueba->cert_empresa->nombre //? $this->Html->link($certEmpresasSetPrueba->cert_empresa->nombre, ['controller' => 'CertEmpresas', 'action' => 'view', $certEmpresasSetPrueba->cert_empresa->id]) : '' ?></td>
                <td><?= $certEmpresasSetPrueba->cert_set_prueba->nombre //? $this->Html->link($certEmpresasSetPrueba->cert_set_prueba->nombre, ['controller' => 'CertSetPruebas', 'action' => 'view', $certEmpresasSetPrueba->cert_set_prueba->id]) : '' ?></td>
                <!-- td><?= h($certEmpresasSetPrueba->estado) ?></td-->
                <!-- >td><?= h($certEmpresasSetPrueba->set_prueba_envio) ?></td-->
                <td>
                <?php 
                    $links = [];
                    foreach($certEmpresasSetPrueba->xml_envio as $key => $doc){
                        $nombreFile = explode('/', $doc);
                        $file = explode(".",end($nombreFile));
                        if(end($file)=='zip')
                            echo $this->Html->link(end($nombreFile), ['controller' =>'CertEmpresasSetPruebas', 'action' => 'descargarZIP', '?' => ["file"=>$doc]], ["target" => "_blank"]);
                        else 
                            echo $this->Html->link(end($nombreFile), $doc, ["download"=>end($nombreFile)]).'<br />';
                    }
                    ?>
                </td>
                <td><?= h($certEmpresasSetPrueba->trackid_envio) ?></td>
                <td><?= h($certEmpresasSetPrueba->respuesta_envio) ?></td>
                <td><?= h($certEmpresasSetPrueba->observaciones_envio) ?></td>
                <td class="actions">                   
                    <?= $this->Html->link(__('Consulta envio'), ['action' => 'consultaEnvio', $certEmpresasSetPrueba->id]) ?> |
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $certEmpresasSetPrueba->id], ['confirm' => __('¿Seguro desea eliminar el registro # {0}?', $certEmpresasSetPrueba->trackid_envio)]) ?>
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
