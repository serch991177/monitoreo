<?php $this->load->view('general/layout/menu') ?>

<div class="row">
    <div class="large-11 large-centered columns">
        <?php $this->load->view('general/layout/message') ?>
        <div class="box no-shadow">
            <div class="box-header panel palette-Defecto bg">
                <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
                    <span><?= lang('lista.notas') ?></span>
                </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="large-4 medium-8 small-12 large-offset-10 medium-offset-8 small-offset-6 columns">
                        <button title="Registrar Nota" class="list-bt palette-Defecto bg button" onclick="nuevaNota()" ; data-open="modalNota">Nuevo Nota<i class="las la-plus la-2x"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="large-4 medium-4 small-12 columns">
                        <?= form_label(lang('fecha.inicial'), 'fecha_inicial'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="las la-calendar"></i></span>
                            <?= form_input('fecha_ini', set_value('fecha_ini'), ['class' => 'input-group-field datepicker', 'required' => 'required', 'id' => 'fecha_ini']); ?>
                        </div>
                        <span class="form-error" data-form-error-for="fecha_ini">
                            <?= lang('campo.requerido') ?>
                        </span>
                    </div>
                    <div class="large-4 medium-4 small-12 columns">
                        <?= form_label(lang('fecha.final'), 'fecha_fin'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="las la-calendar-alt"></i></span>
                            <?= form_input('fecha_fin', set_value('fecha_fin'), ['class' => 'input-group-field datepicker', 'required' => 'required', 'id' => 'fecha_fin']); ?>
                        </div>
                        <span class="form-error" data-form-error-for="fecha_fin">
                            <?= lang('campo.requerido') ?>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <table id="example" class="display cell-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Dependencia</th>
                                    <th>Temas</th>
                                    <!--th>Area</th-->
                                    <th>Fecha Registro</th>
                                    <th>Medios</th>

                                    <th>Operaciones</th>
                                </tr>
                            </thead>
                        </table>
                        <table id="table" class="hover">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="large reveal" id="modalNota" data-reveal data-options="closeOnClick:false;">
    <?= form_open('guardar-nota', ['id' => 'nota', 'data-abide' => '', 'no-validate' => '', 'onsubmit' => 'return validarForm();']); ?>
    <input type="hidden" id="id_nota" name="id_nota">
    <h3 id="titulo-modal" class="center"><?= lang('agregar.nota') ?></h3>
    <div class="row">
        <div class="large-8 medium-10 small-11 columns">
            <?= form_label(lang('dependencia.sel'), 'dependencia'); ?>
            <?= form_dropdown('dependencia', null, set_value('dependencia'), ['class' => 'dependencia input-group-field', 'required' => 'required', 'id' => 'selected_dependencia', 'onchange' => 'selecdep();']); ?>
        </div> <span class="form-error" data-form-error-for="dependencia">
            <?= lang('campo.requerido') ?>
        </span>
        <div class="large-4 medium-2 small-1 columns">
            <br>
            <button class="btn" onclick="limpiar('dependencia');"><i class="las la-backspace"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="large-6 medium-12 small-12 columns" id="nueva_dep">
            <?= form_label(lang('nueva.dependecia'), 'dependencia_nueva'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-info-circle"></i></span>
                <?= form_input('dependencia_nueva', set_value('dependencia_nueva'), ['class' => 'input-group-field ignore', 'id' => 'dependencia_nueva', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'maxlength' => '110']); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="large-8 medium-10 small-12 columns">
            <?= form_label(lang('tema.se'), 'tema'); ?>

            <?= form_dropdown('tema', null, set_value('tema'), ['class' => 'tema input-group-field', 'required' => 'required', 'id' => 'selected_tema', 'onchange' => 'selecttema();']); ?>

            <span class="form-error" data-form-error-for="tema">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
        <div class="large-4 medium-2 small-12 columns">
            <br>
            <button class="btn" onclick="limpiar('tema');"><i class="las la-backspace"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="large-8 medium-12 small-12 columns" id="new_tema">
            <!--a href="<?php echo "temas" ?>" ><?php echo "Registrar otro tema" ?></a-->
            <?= form_label(lang('nuevo.tema'), 'tema_nue'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-info-circle"></i></span>
                <?= form_input('tema_nue', set_value('tema_nue'), ['class' => 'input-group-field ignore', 'id' => 'tema_nue', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'maxlength' => '110']); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="large-12 medium-12 small-12 columns">
            <?= form_label(lang('detalle'), 'detalle'); ?>
            <?= form_textarea(['name' => 'detalle', 'rows' => '3', 'id'=>'detalle','class' => 'basicEditor', 'value' => html_entity_decode(set_value('detalle'))]) ?>
        </div>
    </div>
    <fieldset class="fieldset">
        <legend>
            <h4><?= lang('asignar.medio') ?></h4>
        </legend>


        <div class="row">

            <div class="form-group">
                <div name="add_name" id="add_name">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dynamic_field">
                            <thead>
                                <tr class="bg palette-Celeste">
                                    <th class="palette-Black text" width="24%">MEDIO</th>
                                    <th class="palette-Black text" width="15%">TENDENCIA</th>
                                    <th class="palette-Black text" width="15%">TIPO DE NOTICIA</th>
                                    <th class="palette-Black text" width="16%">TURNO</th>
                                    <th class="palette-Black text" width="22%">DETALLE</th>
                                    <th class="palette-Black text" width="22%">ACCIONES</th>
                                    <th class="palette-Black text" width="10%">Añadir Nuevo</th>
                                </tr>
                            </thead>
                            <tr>
                                <td> <?= form_dropdown('medio[1]', $medios, set_value('medio[]'), ['class' => 'input-group-field req','onchange'=>'validar_blanco(this)']); ?></td>
                                <td><?= form_dropdown('tendencia[1]', $tendencias, set_value('tendencia[]'), ['class' => 'input-group-field req', 'onchange'=>'validar_blanco(this)']); ?></td>

                                <td><?= form_dropdown('tipo_noticia[1]', $tipo_noticias, set_value('tipo_noticia[]'), ['class' => 'input-group-field req','onchange'=>'validar_blanco(this)']); ?></td>

                                <td><?= form_dropdown('turno[1]', $turnos, set_value('turno[]'), ['class' => 'input-group-field req','onchange'=>'validar_blanco(this)']); ?></td>

                                <td> <?= form_input('detalle_reg[1]', set_value('detalle_reg[]'), ['class' => 'input-group-field', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'maxlength' => '60']); ?></td>
                                <td> <?= form_input('acciones_reg[1]', set_value('acciones_reg[]'), ['class' => 'input-group-field', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'maxlength' => '60']); ?></td>



                                <td><button type="button" name="add" id="add" class="btn bg palette-Green"><i class="las la-plus-circle la-2x"></i></button></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>

    <div class="large-6 medium-8 small-12 large-centered medium-centered small-centered columns">
        <br>
        <button type="submit" title="Registrar Nota" id="btn_reg_nota" class="list-bt palette-Defecto button expanded bg">Registrar Nota</button>
    </div>

    <?= form_close(); ?>

    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="large reveal" id="modalModNota" data-reveal data-options="closeOnClick:false;">
    <?= form_open('guardar-nota', ['id' => 'nota', 'data-abide' => '', 'no-validate' => '', 'onsubmit' => 'return validarForm();']); ?>
    <input type="hidden" id="id_nota_mod" name="id_nota">
    <h3 id="titulo-modal" class="center"><?= lang('modificar.nota') ?></h3>
    <div class="row">
        <div class="large-6 medium-6 small-6 columns">
            <?= form_label(lang('dependencia'), 'dependencia'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-question-circle"></i></span>
                <?= form_dropdown('dependencia', $dependencias, set_value('dependencia'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'dependencia_mod']); ?>
            </div>
            <span class="form-error" data-form-error-for="dependencia">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
        <!--div class="large-6 medium-6 small-6 columns">
          <?= form_label(lang('area'), 'area'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-question-circle"></i></span>
              <?= form_dropdown('area', $areas, set_value('area'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'area_mod']); ?>
          </div>
          <span class="form-error" data-form-error-for="area">
              <?= lang('campo.requerido') ?>
          </span>
      </div-->
        <div class="large-12 medium-12 small-12 columns">
            <?= form_label(lang('tema'), 'tema'); ?>

            <?= form_dropdown('tema', null, set_value('tema'), ['class' => 'tema input-group-field', 'required' => 'required', 'id' => 'selected_tema_mod']); ?>

            <span class="form-error" data-form-error-for="tema">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
        <div class="large-6 medium-6 small-6 columns">
            <a href="<?php echo "temas" ?>"><?php echo "Registrar otro tema" ?></a>
        </div>

        <div class="large-12 medium-12 small-12 columns">
            <?= form_label(lang('detalle'), 'detalle'); ?>
            <?= form_textarea(['name' => 'detalle', 'rows' => '3', 'id' => 'detalle_mod', 'class' => 'basicEditor', 'value' => html_entity_decode(set_value('detalle'))]) ?>
        </div>


        <div class="large-6 medium-6 small-6 columns">
            <?= form_label(lang('estado'), 'estado'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-question-circle"></i></span>
                <?= form_dropdown('estado', $estados, set_value('estado'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'estado']); ?>
            </div>
            <span class="form-error" data-form-error-for="estado">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
    </div>

    <div class="large-6 medium-8 small-12 large-centered medium-centered small-centered columns">
        <br>
        <button title="Modificar Nota" id="btn_reg_nota" class="list-bt palette-Defecto button expanded bg">Modificar Nota</button>
    </div>


    <?= form_close(); ?>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="large reveal" id="modalModMedio" data-reveal data-options="closeOnClick:false;">
    <?= form_open('modificar-medio', ['id' => 'medio', 'data-abide' => '', 'no-validate' => '', 'onsubmit' => 'return validarForm();']); ?>
    <input type="hidden" id="id_detalle_medio" name="id_detalle_medio">
    <h3 id="titulo-modal" class="center"><?= lang('modificar.medio') ?></h3>
    <div class="row">
        <fieldset class="fieldset" id="datos">
            <div class="form-group">
                <div class="large-6 medium-6 small-6 columns">
                    <?= form_label(lang('medio'), 'medio'); ?>
                    <div class="input-group">
                        <span class="input-group-label"><i class="las la-question-circle"></i></span>
                        <?= form_dropdown('medio', $medios, set_value('medio'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'medio_mod']); ?>
                    </div>
                    <span class="form-error" data-form-error-for="medio">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
                <div class="large-6 medium-6 small-6 columns">
                    <?= form_label(lang('tendencia'), 'tendencia'); ?>
                    <div class="input-group">
                        <span class="input-group-label"><i class="las la-question-circle"></i></span>
                        <?= form_dropdown('tendencia', $tendencias, set_value('tendencia'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'tendencia_mod']); ?>
                    </div>
                    <span class="form-error" data-form-error-for="tendencia">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
                <div class="large-6 medium-6 small-6 columns">
                    <?= form_label(lang('tipo.noticia'), 'tipo_noticia'); ?>
                    <div class="input-group">
                        <span class="input-group-label"><i class="las la-info-circle"></i></span>
                        <?= form_dropdown('tipo_noticia', $tipo_noticias, set_value('tipo_noticia'), ['class' => 'input-group-field ignore', 'id' => 'tipo_noticia_mod', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'maxlength' => '110', 'required' => 'required']); ?>
                    </div>
                    <span class="form-error" data-form-error-for="tipo_noticia">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
                <div class="large-6 medium-6 small-6 columns">
                    <?= form_label(lang('turno'), 'turno'); ?>
                    <div class="input-group">
                        <span class="input-group-label"><i class="las la-question-circle"></i></span>
                        <?= form_dropdown('turno', $turnos, set_value('turno'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'turno_mod']); ?>
                    </div>
                    <span class="form-error" data-form-error-for="turno">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
                <div class="large-12 medium-12 small-12 columns">
                    <?= form_label(lang('detalle'), 'detalle'); ?>
                    <?= form_textarea(['name' => 'detalle', 'rows' => '3', 'id' => 'detalle_med', 'class' => 'basicEditor', 'value' => html_entity_decode(set_value('detalle'))]) ?>
                </div>
                <div class="large-12 medium-12 small-12 columns">
                    <?= form_label(lang('acciones'), 'acciones'); ?>
                    <?= form_textarea(['name' => 'acciones', 'rows' => '3', 'id' => 'acciones', 'class' => 'basicEditor', 'value' => html_entity_decode(set_value('acciones'))]) ?>
                </div>

                <input type="hidden" id="id_nota_medio" name="id_nota">

            </div>
            <div class="large-6 medium-8 small-12 large-centered medium-centered small-centered columns">
                <br>
                <button title="Modificar Medio" id="btn_mod_medio" class="list-bt palette-Defecto button expanded bg">Modificar Medio</button>
            </div>
        </fieldset>
    </div>
    <?= form_close(); ?>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>



<div class="large reveal" id="modalMedio" data-reveal data-options="closeOnClick:false;">
    <?= form_open('asignar-medio', array('id' => 'asignar_medio', 'data-abide' => '', 'no-validate' => '')); ?>
    <h3 id="titulo-modal" class="center"><?= lang('medio') ?></h3>
    <div class="row">
        <fieldset class="fieldset" id="datos">
            <legend>
                <h4><?= lang('asignar.medio') ?></h4>
            </legend>

            <div class="form-group">
                <div class="large-6 medium-6 small-6 columns">
                    <?= form_label(lang('medio'), 'medio'); ?>
                    <div class="input-group">
                        <span class="input-group-label"><i class="las la-question-circle"></i></span>
                        <?= form_dropdown('medio', $medios, set_value('medio'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'medio']); ?>
                    </div>
                    <span class="form-error" data-form-error-for="medio">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
                <div class="large-6 medium-6 small-6 columns">
                    <?= form_label(lang('tendencia'), 'tendencia'); ?>
                    <div class="input-group">
                        <span class="input-group-label"><i class="las la-question-circle"></i></span>
                        <?= form_dropdown('tendencia', $tendencias, set_value('tendencia'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'tendencia']); ?>
                    </div>
                    <span class="form-error" data-form-error-for="tendencia">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
                <div class="large-6 medium-6 small-6 columns">
                    <?= form_label(lang('tipo.noticia'), 'tipo_noticia'); ?>
                    <div class="input-group">
                        <span class="input-group-label"><i class="las la-info-circle"></i></span>
                        <?= form_dropdown('tipo_noticia', $tipo_noticias, set_value('tipo_noticia'), ['class' => 'input-group-field ignore', 'id' => 'tipo_noticia', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'maxlength' => '110', 'required' => 'required']); ?>
                    </div>
                    <span class="form-error" data-form-error-for="tipo_noticia">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
                <div class="large-6 medium-6 small-6 columns">
                    <?= form_label(lang('turno'), 'turno'); ?>
                    <div class="input-group">
                        <span class="input-group-label"><i class="las la-question-circle"></i></span>
                        <?= form_dropdown('turno', $turnos, set_value('turno'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'turno']); ?>
                    </div>
                    <span class="form-error" data-form-error-for="turno">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
                <div class="large-12 medium-12 small-12 columns">
                    <?= form_label(lang('detalle'), 'detalle'); ?>
                    <?= form_textarea(['name' => 'detalle', 'rows' => '3', 'id' => 'detalle', 'class' => 'basicEditor', 'value' => html_entity_decode(set_value('detalle'))]) ?>
                </div>
                <div class="large-12 medium-12 small-12 columns">
                    <?= form_label(lang('acciones'), 'acciones'); ?>
                    <?= form_textarea(['name' => 'acciones', 'rows' => '3', 'id' => 'acciones', 'class' => 'basicEditor', 'value' => html_entity_decode(set_value('acciones'))]) ?>
                </div>

                <input type="hidden" id="id_nota_med" name="id_nota">

            </div>
            <div class="large-6 medium-8 small-12 large-centered medium-centered small-centered columns">
                <br>
                <button title="Registrar Medio" id="btn_med_nota" class="list-bt palette-Defecto button expanded bg">Registrar Medio</button>
            </div>
        </fieldset>

        <?= form_close(); ?>
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>

        <table border="1">
            <caption>ASIGNACIÓN DE MEDIOS </caption>
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>MEDIO</th>
                    <th>TENDENCIA</th>
                    <th>TIPO NOTICIA</th>
                    <th>TURNO</th>
                    <th>DETALLE</th>
                    <th>ACCIONES</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
            <tbody id="listmedios">
            </tbody>

        </table>

    </div>

</div>
<div class="small reveal" id="modalArchivo" data-reveal data-options="closeOnClick:false;">
    <?= form_open_multipart('subir-archivo', ['id' => 'form_archivo', 'data-abide' => '', 'no-validate' => '', 'data-live-validate' => "true", 'data-validate-on-blur' => "true"]); ?>
    <input type="hidden" id="id_n" name="id_nota">
    <h3 id="titulo-modal" class="center"><?= lang('subir.archivo') ?></h3>


    <div class="row">
        <div class="large-8 columns">
            <b><?= form_label(lang('label.imagen'), 'imagen'); ?></b>
            <div class="center">

                <button class="btn button expanded bg palette-Boton"> <?= lang('cargar.archivo') ?></button>
                <input type="file" name="archivo" title="Cargar Imagen" id="archivo" accept="image/*" required />
                <span class="form-error" data-form-error-for="archivo">
                    <?= lang('campo.requerido') ?>
                </span>
            </div>

        </div>
    </div>
    <div class="row columns text-center">
        <img id="file_img" src="" alt="Imagen No Cargada" style="display: none;">
    </div>
    <?php echo br(2); ?>
    <div class="row">
        <div id="ver_archivo">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns center">
            <br>
            <button title="Subir Archivo" id="btn_subir_nota" class="list-bt palette-Defecto button expanded bg">Subir Archivo</button>
        </div>
    </div>
    <?= form_close(); ?>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>


<?php $this->load->view('normal/nota/js/index') ?>
<?php $this->load->view('general/layout/footer') ?>
