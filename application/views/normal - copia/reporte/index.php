<?php $this->load->view('general/layout/menu') ?>

<div class="row">
    <div class="large-11 large-centered columns">
        <?php $this->load->view('general/layout/message') ?>
        <div class="box no-shadow">
            <div class="box-header panel palette-Defecto bg">
                <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
                    <span><?= lang('reporte.monitoreo') ?></span>
                </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <!--  <?php /*if ($this->session->sistema->id_rol == 4) :*/ ?>
                        { -->
                    <div class="large-4 medium-4 small-12 columns">
                        <?= form_label(lang('estado'), 'estado'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="las la-exclamation-triangle"></i></span>
                            <?= form_dropdown('estado', $estados, set_value('estado'), ['id' => 'estado', 'class' => 'input-group-field']); ?>
                        </div>
                        <span class="form-error" data-form-error-for="estado">
                            <?= lang('campo.requerido') ?>
                        </span>
                    </div>
                    <!-- }
                    <?php /*endif; */ ?> -->
                    <div class="large-4 medium-4 small-12 columns">
                        <?= form_label(lang('dependencia'), 'select_dependencia'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="las la-exclamation-triangle"></i></span>
                            <?= form_dropdown('select_dependencia', $dependencias, set_value('select_dependencia'), ['id' => 'select_dependencia', 'class' => 'input-group-field']); ?>
                        </div>
                        <span class="form-error" data-form-error-for="select_dependencia">
                            <?= lang('campo.requerido') ?>
                        </span>
                    </div>
                    <div class="large-4 medium-4 small-12 columns">
                        <?= form_label(lang('area'), 'select_area'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="las la-exclamation-triangle"></i></span>
                            <?= form_dropdown('area', $areas, set_value('area'), ['id' => 'area', 'class' => 'input-group-field']); ?>
                        </div>
                        <span class="form-error" data-form-error-for="area">
                            <?= lang('campo.requerido') ?>
                        </span>
                    </div>
                    <div class="large-4 medium-4 small-12 columns">
                        <?= form_label(lang('fecha.inicial'), 'fecha_ini'); ?>
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
                    <div class="row">
                        <div class="large-12 columns">
                            <table id="example" class="display cell-border" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Dependencia</th>
                                        <th>Fecha Registro</th>
                                        <th>Temas</th>
                                        <th>Area</th>
                                        <th>Medio</th>
                                        <th>Tendencia</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="small reveal" id="modalNota" data-reveal data-options="closeOnClick:false;">
    <input type="hidden" id="id_not" name="id_nota">
    <h3 id="titulo-modal" class="center"><?= lang('ver.nota') ?></h3>
    <div class="row">
      <div class="large-6 medium-6 small-6 columns">
          <?= form_label(lang('dependencia'), 'dependencia'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-question-circle"></i></span>
            <?= form_input('dependencia', set_value('dependencia'), ['class' => 'input-group-field', 'id' => 'dependencia']); ?>
          </div>
      </div>
      <div class="large-6 medium-6 small-6 columns">
          <?= form_label(lang('estado'), 'estado'); ?>
          <div class="input-group">
            <?= form_input('estado', set_value('ver_estado'), ['class' => 'input-group-field', 'id' => 'ver_estado','onkeyup' => 'javascript:this.value=this.value.toUpperCase();']); ?>
          </div>
      </div>
      <div class="large-12 medium-12 small-12 columns">
          <?= form_label(lang('tema'), 'tema'); ?>
          <?= form_textarea(['name' => 'tema', 'rows' => '3', 'id'=>'tema']) ?>
      </div>
      <div class="large-6 medium-6 small-6 columns">
          <?= form_label(lang('area'), 'area'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-question-circle"></i></span>
              <?= form_input('area', set_value('area'), ['class' => 'input-group-field', 'id' => 'nombre_area', 'required' => 'required','onkeyup' => 'javascript:this.value=this.value.toUpperCase();']); ?>
          </div>
      </div>
      <div class="large-6 medium-6 small-6 columns">
          <?= form_label(lang('medio'), 'medio'); ?>
          <div class="input-group">
                <?= form_input('nombre_medio', set_value('nombre_medio'), ['class' => 'input-group-field', 'id' => 'nombre_medio', 'required' => 'required','onkeyup' => 'javascript:this.value=this.value.toUpperCase();']); ?>
          </div>
          <span class="form-error" data-form-error-for="medio">
              <?= lang('campo.requerido') ?>
          </span>
      </div>
      <div class="large-6 medium-6 small-6 columns">
          <?= form_label(lang('tendencia'), 'tendencia'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-question-circle"></i></span>
            <?= form_input('nombre_tendencia', set_value('nombre_tendencia'), ['class' => 'input-group-field', 'id' => 'nombre_tendencia', 'required' => 'required','onkeyup' => 'javascript:this.value=this.value.toUpperCase();']); ?>
          </div>

      </div>
      <div class="large-6 medium-6 small-6 columns">
          <?= form_label(lang('tipo.noticia'), 'tipo_noticia'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-info-circle"></i></span>
                <?= form_input('tip_noticia', set_value('tip_noticia'), ['class' => 'input-group-field', 'id' => 'tip_noticia', 'required' => 'required','onkeyup' => 'javascript:this.value=this.value.toUpperCase();']); ?>
          </div>

      </div>
        <div class="large-12 medium-12 small-12 columns">
          <?= form_label(lang('observacion'), 'observacion'); ?>
          <?= form_textarea(['name' => 'ver_obs', 'rows' => '3', 'id'=>'ver_obs']) ?>
        </div>


        <div class="large-6 medium-6 small-6">
            <?= form_label(lang('ver.archivo'), 'ver_archivo'); ?>
           <div id="ver_archivo_reporte">
           </div>
        </div>

    </div>

    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php $this->load->view('normal/reporte/js/index') ?>
<?php $this->load->view('general/layout/footer') ?>
