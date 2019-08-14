<?php
    echo $this->Html->charset();
    //echo $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css');
    //echo $this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js');

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Boletas'), ['controller'=>'cert-empresas-set-pruebas','action' => 'emision-boletas']) ?></li>
        <li><?= $this->Html->link(__('Emisión de DTE'), ['controller'=>'cert-empresas-set-pruebas','action' => 'emision-dte']) ?></li>
        <li><?= $this->Html->link(__('Libro de Ventas'), [/*'controller' => 'CertEmpresas', */'action' => 'libro-ventas']) ?>
        </li>
        <li><?= $this->Html->link(__('Libro de Compras'), ['action' => 'libro-compras']) ?></li>
        <li><?= $this->Html->link(__('Libro Guías de Despacho'), ['action' => 'libro-guias-desp']) ?></li>
    </ul>
</nav>