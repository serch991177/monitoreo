<?php $this->load->view('general/layout/menu') ?>

<div class="row">
    <div class="large-11 large-centered columns">
        <?php $this->load->view('general/layout/message') ?>
        <div class="box no-shadow">
            <div class="box-header panel palette-Defecto bg">
                <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
                    <span><?= lang('lista.dependencias') ?></span>
                </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="large-4 medium-8 small-12 large-offset-10 medium-offset-8 small-offset-6 columns">
                        <button title="Registrar Dependencia" class="list-bt palette-Defecto bg button" onclick="nuevaDependencia()"; data-open="modalDependencia">Nueva Dependencia<i class="las la-plus la-2x"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <table id="example" class="display cell-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Dependencia</th>
                                    <!--th>Detalle</th-->
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

<div class="small reveal" id="modalDependencia" data-reveal data-options="closeOnClick:false;">
    <?= form_open('guardar-dependencia', ['id' => 'form_dependencia', 'data-abide' => '', 'no-validate' => '', 'onsubmit' => 'return validarForm();']); ?>
    <input type="hidden" id="id_dependencia" name="id_dependencia">
    <h3 id="titulo-modal" class="center"><?= lang('agregar.dependencia') ?></h3>
    <div class="row">
        <div class="large-12 medium-12 small-12 columns">
            <?= form_label(lang('dependencia'), 'dependencia'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-info-circle"></i></span>
                <?= form_input('dependencia', set_value('dependencia'), ['class' => 'input-group-field ignore', 'id' => 'dependencia', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'maxlength' => '110', 'required' => 'required']); ?>
            </div>
            <span class="form-error" data-form-error-for="dependencia">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
        <!--div class="large-12 medium-12 small-12 columns">
            <?= form_label(lang('detalle'), 'detalle'); ?>
            <?= form_textarea(['name' => 'detalle', 'rows' => '3', 'id'=>'detalle', 'class' => 'basicEditor', 'value' => html_entity_decode(set_value('detalle'))]) ?>
        </div-->
        <!--div class="large-12 medium-12 small-12 columns">
            <?= form_label(lang('estado'), 'estado'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-question-circle"></i></span>
                <?=form_dropdown('estado', $estados, set_value('estado'), ['class'=>'input-group-field', 'required'=>'required', 'id'=>'estado']); ?>
            </div>
            <span class="form-error" data-form-error-for="estado">
                <?= lang('campo.requerido') ?>
            </span>
        </div-->
        <div class="large-6 medium-8 small-12 large-centered medium-centered small-centered columns">
            <br>
            <button title="Registrar Dependencia" id="btn_reg_dep" class="list-bt palette-Defecto button expanded bg">Registrar Dependencia</button>
        </div>
    </div>
    <?= form_close(); ?>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>


<?php $this->load->view('normal/dependencia/js/index') ?>
<?php $this->load->view('general/layout/footer') ?>