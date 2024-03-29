<?php
    /**
     * @var \App\View\AppView $this
     * @var \App\Model\Entity\CertEmpresasSetPrueba $certEmpresasSetPrueba
     */
?>
<?= $this->element('nav') ?>
<div class="form large-9 medium-8 columns content">
    <div class="large-12">
        <label> FACTURA ELECTRONICA Y OTROS DOCUMENTOS ELECTRONICOS</label>
        <?php echo $this->Html->link('https://maullin.sii.cl/cvc/dte/certificacion_dte.html','https://maullin.sii.cl/cvc/dte/certificacion_dte.html', array('target' => '_blank')); ?>
    </div>
    <br />

    
    <div class="large-12">
        <label> PREGUNTAS FRECUENTES DE DOCUMENTOS TRIBUTARIOS (FACTURAS - BOLETAS)</label>
        <?php echo $this->Html->link('http://www.sii.cl/preguntas_frecuentes/catastro/preg_documentos_tributarios.htm','http://www.sii.cl/preguntas_frecuentes/catastro/preg_documentos_tributarios.htm', array('target' => '_blank')); ?>
    </div>
    <br />
    <div class="large-12">
        <label> FORMATO XML DE DOCUMENTOS ELECTRÓNICOS </label>
        <?php echo $this->Html->link('http://www.sii.cl/factura_electronica/formato_xml.htm','http://www.sii.cl/factura_electronica/formato_xml.htm', array('target' => '_blank')); ?>
    </div>
    <br />
    <div class="large-12">
        <label>NÓMINA PERSONAS JURÍDICAS Y EMPRESAS</label>
        <?php echo $this->Html->link('http://www.sii.cl/estadisticas/nominas/nominapersonasjuridicas.htm','http://www.sii.cl/estadisticas/nominas/nominapersonasjuridicas.htm', array('target' => '_blank')); ?>
    </div>
</div>


