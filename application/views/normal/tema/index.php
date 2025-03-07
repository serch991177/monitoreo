<?php $this->load->view('general/layout/menu') ?>

<div class="row">
    <div class="large-11 large-centered columns">
        <?php $this->load->view('general/layout/message') ?>
        <div class="box no-shadow">Tema
            <div class="box-header panel palette-Defecto bg">
                <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
                    <span><?= lang('lista.temas') ?></span>
                </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="large-4 medium-8 small-12 large-offset-10 medium-offset-8 small-offset-6 columns">
                        <button title="Registrar Tema" class="list-bt palette-Defecto bg button" onclick="nuevoTema()"; data-open="modalTema">Nuevo Tema<i class="las la-plus la-2x"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <table id="example" class="display cell-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tema</th>
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

<div class="small reveal" id="modalTema" data-reveal data-options="closeOnClick:false;">
    <?= form_open('guardar-tema', ['id' => 'form_tema', 'data-abide' => '', 'no-validate' => '', 'onsubmit' => 'return validarForm();']); ?>
    <input type="hidden" id="id_tema" name="id_tema">
    <h3 id="titulo-modal" class="center"><?= lang('agregar.tema') ?></h3>
    <div class="row">
        <div class="large-12 medium-12 small-12 columns">
            <?= form_label(lang('tema'), 'tema'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-info-circle"></i></span>
                <?= form_input('tema', set_value('tema'), ['class' => 'input-group-field ignore', 'id' => 'tema', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'maxlength' => '110', 'required' => 'required']); ?>
            </div>
            <span class="form-error" data-form-error-for="tema">
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
            <button title="Registrar Tema" id="btn_reg_tem" class="list-bt palette-Defecto button expanded bg">Registrar Tema</button>
        </div>
    </div>
    <?= form_close(); ?>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>


<?php $this->load->view('normal/tema/js/index') ?>
<?php $this->load->view('general/layout/footer') ?>
