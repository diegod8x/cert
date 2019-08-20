<?php
    /**
     * @var \App\View\AppView $this
     * @var \App\Model\Entity\CertEmpresasSetPrueba $certEmpresasSetPrueba
     */
?>
<?= $this->element('nav') ?>
<div class="certEmpresasSetPruebas form large-9 medium-8 columns content">
    <?= $this->Form->create($certEmpresasSetPrueba, ['id' => 'certEmpresasSetPrueba', 'type' => 'file', "role"=>"form", "data-abide" => '', "novalidate"=>'novalidate']) ?>
    <fieldset>
        <legend><?= __('Boletas') ?></legend>

        <div class="row">
            <div class="large-8">
                <div class="large-12 columns">
                    <label>Set de Pruebas Boletas (.csv)
                        <input type="file" name="set_de_pruebas" required />
                    </label>
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <br />
        <div class="row">
            <div class="large-8">
                <div class="large-12 columns">
                    <input type="hidden" name="emisor[id]" />
                    <label>Rut Emisor (Empresa a certificar)
                        <input type="text" name="emisor[RUTEmisor]" placeholder="Rut emisor"
                            onchange="getEmisor(this.value)" required pattern="\d{3,8}-[\d|kK]{1}"/>
                    </label>
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-12 columns">
                    <input type="text" name="emisor[RznSoc]" placeholder="Razón social emisor" required />
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-12 columns">
                    <input type="text" name="emisor[GiroEmis]" placeholder="Giro emisor" required />
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-12 columns">
                    <input type="text" name="emisor[DirOrigen]" placeholder="Dirección emisor" required />
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-12 columns">
                    <?php echo $this->Form->control('emisor[CmnaOrigen]', ['options' => $comunas, 'empty' => 'Comuna emisor...', 'label' => false, "id"=>"CmnaOrigen" , "required"=>"required"]); ?>
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <div class="row">
            <div class="large-8">
                <div class="large-12 columns">
                    <input type="text" name="emisor[Acteco]" placeholder="Actividad económica emisor" pattern="number" required />
                </div>
            </div>
            <div class="large-4 columns"></div>
        </div>
        <br />
        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <label>Firma electrónica (certificado formato .p12)
                        <input type="file" name="certificado[firma]" required />
                    </label>
                </div>
                <div class="large-6 columns">
                    <label>Contraseña firma electrónica
                        <input type="password" name="certificado[pass]" placeholder="Contraseña firma" required />
                    </label>
                </div>
            </div>
        </div>

        <br />

        <div class="row">
            <div class="large-8">
                <div class="large-6 columns">
                    <label>Fecha resolución
                        <input type="text" name="caratula[FchResol]" placeholder="AAAA-MM-DD" pattern="date" required />
                    </label>
                </div>
                <div class="large-6 columns">
                    <label>Número de resolución
                        <input type="text" name="caratula[NroResol]" placeholder="Número de resolución" pattern="number" required />
                    </label>
                </div>
            </div>
        </div>

        <br />
        <div class="row" id="caf_container">
            <div class="large-12 columns">
                <div class="large-4 columns">
                    <label>Archivos CAF (.xml)
                        <input type="file" name="cafs[0][caf]" required />
                    </label>
                </div>
                <div class="large-2 columns">
                    <label>Nr. Documento
                        <input type="text" name="cafs[0][nro_documento]" required />
                    </label>
                </div>
                <div class="large-2 columns">
                    <label>Folio desde
                        <input type="text" name="cafs[0][folio_desde]" required />
                    </label>
                </div>

                <div class="large-4 columns">
                    <button type="button" class="button tiny" id="addbutton">
                        <i class="fi-plus"></i>
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

    var countButton = 0;
    $("#addbutton").click(function () {
        countButton++;
        $("#caf_container").append('\
            <div class="large-12 columns">\
                <div class="removerow'+parseInt(countButton)+'">\
                    <div class="large-4 columns">\
                        <label>\
                            <input type="file" name="cafs[' + parseInt(countButton) + '][caf]" required />\
                        </label>\
                    </div>\
                    <div class="large-2 columns">\
                        <label>\
                            <input type="text" name="cafs[' + parseInt(countButton) + '][nro_documento]" required />\
                        </label>\
                    </div>\
                    <div class="large-2 columns">\
                        <label>\
                            <input type="text" name="cafs[' + parseInt(countButton) + '][folio_desde]" required /> \
                        </label>\
                    </div>\
                    <div class="large-4 columns">\
                        <a><i class="fi-x" id="deletebutton"></i></a>\
                    </div>\
                </div>\
            </div>');
    });
    $("#caf_container").on('click', '#deletebutton',  function () {
        $(this).parent().parent().parent().remove();
    });

    $("#generate, #send").click(function() {    
        var accion = $(this).attr("id");
        $("#accion").val(accion);
        $("#certEmpresasSetPrueba").submit();    
    });

    var getEmisor = function (rut) {
        $.ajax({
            type: "GET",
            url: '<?php echo $this->Url->build(["controller"=>"cert-empresas", "action"=>"getEmisor"]) ?>',
            data: { "rut": rut },
            async: true,
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    $("input[name='emisor[" + index + "]']").val(value);
                    if ($('#' + index).find("option[value='" + value + "']").length) {
                        $('#' + index).val(value).trigger('change');
                    }
                });
            }
        });
    };

</script>