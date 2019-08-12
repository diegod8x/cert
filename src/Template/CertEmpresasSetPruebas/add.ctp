<?php
    /**
     * @var \App\View\AppView $this
     * @var \App\Model\Entity\CertEmpresasSetPrueba $certEmpresasSetPrueba
     */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Boletas'), ['action' => 'emision-boletas']) ?></li>
        <li><?= $this->Html->link(__('Emisión de DTE'), ['action' => 'emision-dte']) ?></li>
        <li><?= $this->Html->link(__('Libro de Ventas'), [/*'controller' => 'CertEmpresas', */'action' => 'libro-ventas']) ?>
        </li>
        <li><?= $this->Html->link(__('Libro de Compras'), ['action' => 'libro-compras']) ?></li>
        <li><?= $this->Html->link(__('Libro Guías de Despacho'), ['action' => 'libro-guias-desp']) ?></li>
    </ul>
</nav>
<div class="certEmpresasSetPruebas form large-9 medium-8 columns content">
    <?= $this->Form->create($certEmpresasSetPrueba, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Emisión de DTE') ?></legend>

        <?php // echo $this->Form->input('set_de_pruebas', ['type' => 'file']); ?>

        <div class="row">
            <div class="large-12 columns">
                <label>Set de Pruebas (.txt)
                    <input type="file" name="set_de_pruebas" onchange="onFileImage(this);" />                    
                </label>
            </div>
        </div>


        <br />
        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <label>Rut Emisor (Empresa a certificar)
                        <input type="text" name="rut_emisor" placeholder="Rut emisor" />
                    </label>
                </div>

                <div class="large-6 columns">
                    <label>Rut Receptor (Empresa certificadora)
                        <input type="text" name="rut_receptor" placeholder="Rut receptor" />
                    </label>
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <input type="text" name="rs_emisor" placeholder="Razón social emisor" />
                </div>
                <div class="large-6 columns">
                    <input type="text" name="rs_receptor" placeholder="Razón social receptor" />
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <input type="text" name="giro_emisor" placeholder="Giro emisor" />
                </div>
                <div class="large-6 columns">
                    <input type="text" name="giro_receptor" placeholder="Giro receptor" />
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <input type="text" name="direccion_emisor" placeholder="Dirección emisor" />
                </div>
                <div class="large-6 columns">
                    <input type="text" name="direccion_receptor" placeholder="Dirección receptor" />
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <?php echo $this->Form->control('comuna_emisor', ['options' => $certEmpresas, 'empty' => 'Comuna emisor', 'label' => false]); ?>
                </div>
                <div class="large-6 columns">
                    <?php echo $this->Form->control('comuna_receptor', ['options' => $certEmpresas, 'empty' => 'Comuna receptor', 'label' => false]); ?>
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <input type="text" name="act_emisor" placeholder="Actividad económica emisor" />
                </div>
                <div class="large-6 columns">
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>

        <br />

        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <label>Firma electrónica (certificado formato .p12)
                        <input type="file" name="firma_emisor" onchange="onFileImage(this);" />
                    </label>
                </div>
                <div class="large-6 columns">
                    <label>Contraseña firma electrónica
                        <input type="text" name="pass_emisor" placeholder="Contraseña firma" />
                    </label>
                </div>
            </div>
        </div>

        <br />

        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <label>Fecha resolución
                        <input type="text" id="nro_resolucion" placeholder="Fecha resolución" />
                    </label>
                </div>
                <div class="large-6 columns">
                    <label>Número de resolución
                        <input type="text" id="nro_resolucion" placeholder="Número de resolución" />
                    </label>
                </div>
            </div>
        </div>

        <br />
        <div class="row" id="caf_container">
            <div class="large-12">
                <div class="large-4 columns">
                    <label>Archivos CAF (.xml)
                        <input type="file" name="caf_1" onchange="onFileImage(this);" />
                    </label>
                </div>
                <div class="large-2 columns">
                    <label>Nr. Documento
                        <input type="text" name="nro_documento_1" />
                    </label>
                </div>
                <div class="large-2 columns">
                    <label>Folio desde
                        <input type="text" name="folio_desde_1" />
                    </label>
                </div>
                <div class="large-4 columns">
                    <button type="button" class="button tiny" id="somebutton">
                        +
                    </button>
                </div>
            </div>

        </div>

    </fieldset>
    <div class="large-8">
        <?= $this->Form->button(__('Submit')) ?>
    </div>
    <?= $this->Form->end() ?>
</div>



<script>
var countButton = 1;
$("#somebutton").click(function () {
    countButton++;
    $("#caf_container").append('<div class="large-8">\
                <div class="large-6 columns">\
                    <label>\
                        <input type="file" name="caf_' + countButton + '" onchange="onFileImage(this);" />\
                    </label>\
                </div>\
                <div class="large-3 columns">\
                    <label>\
                        <input type="text" name="nro_documento_' + countButton + '" />\
                    </label>\
                </div>\
                <div class="large-3 columns">\
                    <label>\
                        <input type="text" name="folio_desde_' + countButton + '" />\
                    </label>\
                </div>\
            </div>');
});
</script>