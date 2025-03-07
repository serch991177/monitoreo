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
                        <button title="Registrar Nota" class="list-bt palette-Defecto bg button" onclick="nuevaNota()"; data-open="modalNota">Nuevo Nota<i class="las la-plus la-2x"></i></button>
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
                                    <th>Area</th>
                                    <th>Medio</th>
                                    <th>Tendencia</th>
                                    <th>Estado</th>
                                    <th>Operaciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="small reveal" id="modalNota" data-reveal data-options="closeOnClick:false;">
    <?= form_open('guardar-nota', ['id' => 'nota', 'data-abide' => '', 'no-validate' => '', 'onsubmit' => 'return validarForm();']); ?>
    <input type="hidden" id="id_nota" name="id_nota">
    <h3 id="titulo-modal" class="center"><?= lang('agregar.nota') ?></h3>
    <div class="row">
      <div class="large-6 medium-6 small-6 columns">
          <?= form_label(lang('dependencia'), 'dependencia'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-question-circle"></i></span>
              <?=form_dropdown('dependencia', $dependencias, set_value('dependencia'), ['class'=>'input-group-field', 'required'=>'required', 'id'=>'dependencia']); ?>
          </div>
          <span class="form-error" data-form-error-for="dependencia">
              <?= lang('campo.requerido') ?>
          </span>
      </div>
      <div class="large-12 medium-12 small-12 columns">
          <?= form_label(lang('tema'), 'tema'); ?>
          <?= form_textarea(['name' => 'tema', 'rows' => '3', 'id'=>'tema', 'class' => 'basicEditor', 'value' => html_entity_decode(set_value('tema'))]) ?>
      </div>
      <div class="large-6 medium-6 small-6 columns">
          <?= form_label(lang('area'), 'area'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-question-circle"></i></span>
              <?=form_dropdown('area', $areas, set_value('area'), ['class'=>'input-group-field', 'required'=>'required', 'id'=>'area']); ?>
          </div>
          <span class="form-error" data-form-error-for="area">
              <?= lang('campo.requerido') ?>
          </span>
      </div>
      <div class="large-6 medium-6 small-6 columns">
          <?= form_label(lang('medio'), 'medio'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-question-circle"></i></span>
              <?=form_dropdown('medio', $medios, set_value('medio'), ['class'=>'input-group-field', 'required'=>'required', 'id'=>'medio']); ?>
          </div>
          <span class="form-error" data-form-error-for="medio">
              <?= lang('campo.requerido') ?>
          </span>
      </div>
      <div class="large-6 medium-6 small-6 columns">
          <?= form_label(lang('tendencia'), 'tendencia'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-question-circle"></i></span>
              <?=form_dropdown('tendencia', $tendencias, set_value('tendencia'), ['class'=>'input-group-field', 'required'=>'required', 'id'=>'tendencia']); ?>
          </div>
          <span class="form-error" data-form-error-for="tendencia">
              <?= lang('campo.requerido') ?>
          </span>
      </div>
      <div class="large-6 medium-6 small-6 columns">
          <?= form_label(lang('tipo.noticia'), 'tipo_noticia'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-info-circle"></i></span>
                <?=form_dropdown('tipo_noticia',$tipo_noticias, set_value('tipo_noticia'), ['class' => 'input-group-field ignore', 'id' => 'tipo_noticia', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'maxlength' => '110', 'required' => 'required']); ?>
          </div>
          <span class="form-error" data-form-error-for="tipo_noticia">
              <?= lang('campo.requerido') ?>
          </span>
      </div>
        <div class="large-12 medium-12 small-12 columns">
            <?= form_label(lang('observacion'), 'observacion'); ?>
            <?= form_textarea(['name' => 'observacion', 'rows' => '3', 'id'=>'observacion', 'class' => 'basicEditor', 'value' => html_entity_decode(set_value('observacion'))]) ?>
        </div>

        <div class="large-6 medium-6 small-6 columns">
            <?= form_label(lang('turno'), 'turno'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-question-circle"></i></span>
                <?=form_dropdown('turno', $turnos, set_value('turno'), ['class'=>'input-group-field', 'required'=>'required', 'id'=>'turno']); ?>
            </div>
            <span class="form-error" data-form-error-for="turno">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
        <div class="large-6 medium-6 small-6 columns">
            <?= form_label(lang('estado'), 'estado'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-question-circle"></i></span>
                <?=form_dropdown('estado', $estados, set_value('estado'), ['class'=>'input-group-field', 'required'=>'required', 'id'=>'estado']); ?>
            </div>
            <span class="form-error" data-form-error-for="estado">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
        <div class="large-6 medium-8 small-12 large-centered medium-centered small-centered columns">
            <br>
            <button title="Registrar Nota" id="btn_reg_nota" class="list-bt palette-Defecto button expanded bg">Registrar Nota</button>
        </div>
    </div>
    <?= form_close(); ?>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
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
