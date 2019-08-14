<?php
    /**
     * @var \App\View\AppView $this
     * @var \App\Model\Entity\CertEmpresasSetPrueba $certEmpresasSetPrueba
     */
?>
<?= $this->element('nav') ?>
<div class="certEmpresasSetPruebas form large-9 medium-8 columns content">
    <?= $this->Form->create($certEmpresasSetPrueba, ['id' => 'certEmpresasSetPrueba', 'type' => 'file', "data-abide" => 'ajax']) ?>
    <fieldset>
        <legend><?= __('Emisión de DTE') ?></legend>

        <?php // echo $this->Form->input('set_de_pruebas', ['type' => 'file']); ?>

        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <?php echo $this->Form->control('cert_set_prueba_id', ['options' => $setPruebas, 'empty' => 'Set de Pruebas...', 'label' => 'Seleccione']); ?>
                </div>
                <div class="large-6 columns">
                    <label>Set de Pruebas (.txt)
                        <input type="file" name="set_de_pruebas" onchange="onFileImage(this);" required />
                    </label>
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>

        <br />
        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <label>Rut Emisor (Empresa a certificar)
                        <input type="text" name="emisor[RUTEmisor]" placeholder="Rut emisor" onchange="getEmisor(this.value)" required />
                    </label>
                    <small class="error">A valid email address is required.</small>
                </div>

                <div class="large-6 columns">
                    <label>Rut Receptor (Empresa certificadora)
                        <input type="text" name="receptor[RUTRecep]" placeholder="Rut receptor" onchange="getReceptor(this.value)" required />
                    </label>
                    <small class="error">A valid email address is required.</small>
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <input type="text" name="emisor[RznSoc]" placeholder="Razón social emisor" required />
                </div>
                <div class="large-6 columns">
                    <input type="text" name="receptor[RznSocRecep]" placeholder="Razón social receptor" required />
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <input type="text" name="emisor[GiroEmis]" placeholder="Giro emisor" required/>
                </div>
                <div class="large-6 columns">
                    <input type="text" name="receptor[GiroRecep]" placeholder="Giro receptor" required/>
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <input type="text" name="emisor[DirOrigen]" placeholder="Dirección emisor" required/>
                </div>
                <div class="large-6 columns">
                    <input type="text" name="receptor[DirRecep]" placeholder="Dirección receptor" required/>
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <?php echo $this->Form->control('emisor[CmnaOrigen]', ['id'=> 'emisor[CmnaOrigen]', 'options' => $comunas, 'empty' => 'Comuna emisor...', 'label' => false]); ?>
                </div>
                <div class="large-6 columns">
                    <?php echo $this->Form->control('receptor[CmnaRecep]', ['id'=> 'receptor[CmnaRecep]', 'options' => $comunas, 'empty' => 'Comuna receptor...', 'label' => false]); ?>
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <input type="text" name="emisor[Acteco]" placeholder="Actividad económica emisor" required />
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
                        <input type="file" name="certificado[firma]" onchange="onFileImage(this);" />
                    </label>
                </div>
                <div class="large-6 columns">
                    <label>Contraseña firma electrónica
                        <input type="password" name="certificado[pass]" placeholder="Contraseña firma" required/>
                    </label>
                </div>
            </div>
        </div>

        <br />

        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <label>Fecha resolución
                        <input type="text" name="caratula[FchResol]" placeholder="Fecha resolución" />
                    </label>
                </div>
                <div class="large-6 columns">
                    <label>Número de resolución
                        <input type="text" name="caratula[NroResol]" placeholder="Número de resolución" />
                    </label>
                </div>
            </div>
        </div>

        <br />
        <div class="row" id="caf_container">
            <div class="large-12">
                <div class="large-4 columns">
                    <label>Archivos CAF (.xml)
                        <input type="file" name="cafs[0][caf]" onchange="onFileImage(this);" />
                    </label>
                </div>
                <div class="large-2 columns">
                    <label>Nr. Documento
                        <input type="text" name="cafs[0][nro_documento]" required/>
                    </label>
                </div>
                <div class="large-2 columns">
                    <label>Folio desde
                        <input type="text" name="cafs[0][folio_desde]" required/>
                    </label>
                </div>
                <div class="large-4 columns">
                    <button type="button" class="button tiny" id="addbutton">
                        <b>+</b>
                    </button>
                </div>
            </div>
        </div>

    </fieldset>
    <br />
    <div class="large-8">
        <div class="large-2 columns">&nbsp;</div>
        <div class="large-3 columns">
            <button type="button" class="button" id="generate">
                Generar XML
            </button>
        </div>
        <div class="large-1 columns">&nbsp;</div>
        <div class="large-5 columns">
            <button type="button" class="button" id="send">
                Generar y Enviar a SII
            </button>
        </div>
        
    </div>
    <br /><br /><br /><br /><br /><br />
    <input type="hidden" name="accion" id="accion" />
    <?= $this->Form->end() ?>
</div>



<script>
$(document).foundation();
$('#certEmpresasSetPrueba')
  .on('invalid.fndtn.abide', function () {
    var invalid_fields = $(this).find('[data-invalid]');
    console.log(invalid_fields);
  })
  .on('valid.fndtn.abide', function () {
    console.log('valid!');
  });

var countButton = 0;
$("#addbutton").click(function() {
    countButton++;
    $("#caf_container").append('<div class="large-8">\
                <div class="large-6 columns">\
                    <label>\
                        <input type="file" name="cafs[' + parseInt(countButton) + '][caf]" onchange="onFileImage(this);" />\
                    </label>\
                </div>\
                <div class="large-3 columns">\
                    <label>\
                        <input type="text" name="cafs[' + parseInt(countButton) + '][nro_documento]" />\
                    </label>\
                </div>\
                <div class="large-3 columns">\
                    <label>\
                        <input type="text" name="cafs[' + parseInt(countButton) + '][folio_desde]" />\
                    </label>\
                </div>\
            </div>');
});

$("#generate, #send").click(function() {

   /* $('#certEmpresasSetPrueba')
    .on('invalid.fndtn.abide', function () {
        var invalid_fields = $(this).find('[data-invalid]');
        console.log(invalid_fields);
    })
    .on('valid.fndtn.abide', function () {emisor[CmnaOrigen]
        console.log('valid!');
    });*/

    var accion = $(this).attr("id");
    $("#accion").val(accion);

    //var data = $('#certEmpresasSetPrueba').serializeArray();
    //console.log(JSON.stringify(data,null,2));
    $("#certEmpresasSetPrueba").submit();

});



    var getEmisor = function(rut){        
        $.ajax({
            type: "GET",
            url:'<?php echo $this->Url->build(["controller"=>"cert-empresas", "action"=>"getEmisor"]) ?>',
            data: { "rut" : rut },
            async: true,
            dataType: "json",
                success: function(data) {
                    console.log(typeof data);
                    $.each(data, function(index, value) {                    
                        $("input[name='emisor[" + index + "]']").val(value);
                        $("#emisor[CmnaOrigen] option[value='" + value + "']").prop('selected', true);
                    });
                }
            });
    };
    var getReceptor = function(rut){        
        $.ajax({
            type: "GET",
            url:'<?php echo $this->Url->build(["controller"=>"cert-empresas", "action"=>"getReceptor"]) ?>',
            data: { "rut" : rut },
            async: true,
            dataType: "json",
                success: function(data) {
                    console.log(typeof data);
                    $.each(data, function(index, value) {
                        $("input[name='receptor[" + index + "]']").val(value);
                        //$("#receptor[]").val(value).change();
                    });
                }
            });
    };



</script>