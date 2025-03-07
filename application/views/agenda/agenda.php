<?php $this->load->view('general/layout/menu') ?>

<div class="row">
    <div class="large-11 large-centered columns">
        <?php $this->load->view('general/layout/message') ?>
        <div class="box no-shadow">
            <div class="box-header panel palette-Defecto bg">
                <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
                    <span><?= lang('dashboard') ?></span>
                </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="large-2 columns">
                        <?= form_label(lang('fecha.inicio'), 'fecha_ini'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="las la-calendar-check"></i></span>
                            <?= form_input('fecha_ini', set_value('fecha_ini'), ['class' => 'input-group-field ignore', 'id' => 'fecha_ini']); ?>
                        </div>
                    </div>
                    <div class="large-8 columns">
                        <div class="expanded button-group">
                            <button onclick='mostrarProgramas();' data-open="modalProgramas" class="button palette-Iconos bg"><i class="las la-tv la-2x"></i> PROGRAMAS <i class="las la-tv la-2x"></i></button>
                            <button onclick='mostrarInterlocutores();' data-open="modalInterlocutores" class="button palette-Iconos bg"><i class="las la-user la-2x"></i></i> INTERLOCUTORES <i class="las la-user la-2x"></i></button>
                            <button data-open="modalEspacio" class="button palette-Iconos bg"><i class="las la-calendar-plus la-2x"></i> REGISTRAR ESPACIO <i class="las la-calendar-plus la-2x"></i></button>
                        </div>
                    </div>
                    <div class="large-2 columns">
                        <?= form_label(lang('fecha.fin'), 'fecha_fin'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="las la-calendar-check"></i></span>
                            <?= form_input('fecha_fin', set_value('fecha_fin'), ['class' => 'input-group-field ignore', 'id' => 'fecha_fin']); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-4 medium-8 small-12 large-centered columns">
                        <?= form_open('imprimir-agenda', ['id' => 'form_print_agenda', 'data-abide' => '', 'no-validate' => '', 'on_submit' => 'return imprimirAgenda();']); ?>
                        <input type="hidden" id="f_ini" name="f_ini">
                        <input type="hidden" id="f_fin" name="f_fin">
                        <div class="large-6 medium-8 small-12 large-centered columns">
                            <button type="submit" title="Imprimir Agenda" class="palette-Boton bg button expanded" onclick="imprimirAgenda()"><i class="las la-print la-2x"></i>Imprimir Agenda<i class="las la-print la-2x"></i></button>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <table id="example" class="display cell-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Motivo del Espacio</th>
                                    <th>Interlocutor</th>
                                    <th>Detalle</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="small reveal" id="modalProgramas" data-reveal data-options="closeOnClick:false;">
    <div class="row">
        <center>
            <h3>REGISTRAR PROGRAMA</h3>
        </center>
        <div class="large-12 medium-6 small-12 columns">
            <?= form_label(lang('nombre.programa'), 'programa_add'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-tv"></i></span>
                <?= form_input('programa_add', set_value('programa_add'), ['class' => 'input-group-field ignore', 'id' => 'programa_add', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'required' => 'required']); ?>
            </div>
            <span class="form-error" data-form-error-for="programa_add">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
        <div class="large-12 medium-6 small-12 columns">
            <?= form_label(lang('medio'), 'medio_add'); ?>
            <?= form_dropdown('medio_add', $medios, set_value('medio_add'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'medio_add']); ?>
            <span class="form-error" data-form-error-for="medio_add">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="large-6 medium-6 small-1 large-centered columns">
            <br>
            <button title="Registrar" class="palette-Boton bg button expanded" onclick="registrarPrograma()"><i class="las la-save la-2x"></i>Registrar</button>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <table id="programas-table" class="display cell-border" style="width:100%">
            </table>
        </div>
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="small reveal" id="modalInterlocutores" data-reveal data-options="closeOnClick:false;">
    <div class="row">
        <center>
            <h3>REGISTRAR INTERLOCUTOR</h3>
        </center>
        <div class="large-12 medium-6 small-12 columns">
            <?= form_label(lang('interlocutor'), 'funcionario_add'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-user-tie"></i></span>
                <?= form_input('funcionario_add', set_value('funcionario_add'), ['class' => 'input-group-field ignore', 'id' => 'funcionario_add', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'required' => 'required']); ?>
            </div>
            <span class="form-error" data-form-error-for="funcionario_add">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
        <div class="large-12 medium-6 small-12 columns">
            <?= form_label(lang('cargo'), 'cargo_add'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-id-badge"></i></span>
                <?= form_input('cargo_add', set_value('cargo_add'), ['class' => 'input-group-field ignore', 'id' => 'cargo_add', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'required' => 'required']); ?>
            </div>
            <span class="form-error" data-form-error-for="cargo_add">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="large-6 medium-6 small-1 large-centered columns">
            <br>
            <button title="Registrar" class="palette-Boton bg button expanded" onclick="registrarInterlocutor()"><i class="las la-save la-2x"></i>Registrar</button>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <table id="interlocutores-table" class="display cell-border" style="width:100%">
            </table>
        </div>
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="small reveal" id="modalEspacio" data-reveal data-options="closeOnClick:false;">
    <?= form_open('guardar-espacio', ['id' => 'form_espacio', 'data-abide' => '', 'no-validate' => '']); ?>
    <div class="row">
        <center>
            <h3>REGISTRAR ESPACIO</h3>
        </center>
        <div class="large-12 medium-6 small-12 columns">
            <?= form_label(lang('motivo.espacio'), 'motivo_add'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-edit"></i></span>
                <?= form_input('motivo_add', set_value('motivo_add'), ['class' => 'input-group-field ignore', 'id' => 'motivo_add', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'required' => 'required']); ?>
            </div>
            <span class="form-error" data-form-error-for="motivo_add">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
        <div class="large-12 medium-6 small-12 columns">
            <?= form_label(lang('interlocutor'), 'interlocutor_add'); ?>
            <?= form_dropdown('interlocutor_add', $interlocutores, set_value('interlocutor_add'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'interlocutor_add']); ?>
            <span class="form-error" data-form-error-for="interlocutor_add">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
        <fieldset>
            <legend>Agenda</legend>
            <div class="large-12 medium-6 small-12 columns">
                <div class="large-6 medium-8 small-12 columns">
                    <?= form_label(lang('fecha'), 'fecha_add'); ?>
                    <input type="text" name="fecha" id="fecha_add" required />
                    <span class="form-error" data-form-error-for="fecha_add">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
                <div class="large-6 medium-8 small-12 columns">
                    <?= form_label(lang('hora'), 'hora'); ?>
                    <?= form_dropdown('hora', $horas, set_value('hora'), ['id' => 'hora', 'required' => 'required']); ?>
                    <span class="form-error" data-form-error-for="hora">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
            </div>
            <div class="large-12 medium-6 small-12 columns">
                <div class="large-5 medium-8 small-12 columns">
                    <?= form_label(lang('programa'), 'programa'); ?>
                    <?= form_dropdown('programa', $programas, set_value('programa'), ['id' => 'programa', 'required' => 'required']); ?>
                    <span class="form-error" data-form-error-for="programa">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
                <div class="large-6 medium-8 small-12 columns">
                    <?= form_label(lang('lugar'), 'lugar'); ?>
                    <input type="text" name="lugar" id="lugar" required onkeyup="javascript:this.value=this.value.toUpperCase();" />
                    <span class="form-error" data-form-error-for="lugar">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="row">
        <div class="large-6 medium-6 small-1 large-centered columns">
            <br>
            <button type="submit" title="Registrar" class="palette-Boton bg button expanded"><i class="las la-save la-2x"></i>Registrar</button>
        </div>
    </div>
    <?= form_close(); ?>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="small reveal" id="modalAdicion" data-reveal data-options="closeOnClick:false;">
    <div class="row">
        <center>
            <h3>AÑADIR ESPACIO</h3>
        </center>
        <input type="hidden" id="id_espacio_new" name="id_espacio_new">
        <div class="large-12 medium-6 small-12 columns">
            <?= form_label(lang('motivo.espacio'), 'motivo_new'); ?>
            <div class="input-group">
                <span class="input-group-label"><i class="las la-edit"></i></span>
                <?= form_input('motivo_new', set_value('motivo_new'), ['class' => 'input-group-field ignore', 'id' => 'motivo_new', 'onkeyup' => 'javascript:this.value=this.value.toUpperCase();', 'disabled' => 'disabled']); ?>
            </div>
            <span class="form-error" data-form-error-for="motivo_new">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
        <div class="large-12 medium-6 small-12 columns">
            <?= form_label(lang('interlocutor'), 'interlocutor_new'); ?>
            <?= form_dropdown('interlocutor_new', $interlocutores, set_value('interlocutor_new'), ['class' => 'input-group-field', 'disabled' => 'disabled', 'id' => 'interlocutor_new']); ?>
            <span class="form-error" data-form-error-for="interlocutor_new">
                <?= lang('campo.requerido') ?>
            </span>
        </div>
        <fieldset>
            <legend>Agenda</legend>
            <div class="large-12 medium-6 small-12 columns">
                <div class="large-6 medium-8 small-12 columns">
                    <?= form_label(lang('fecha'), 'fecha_new'); ?>
                    <input type="text" name="fecha_new" id="fecha_new" required />
                    <span class="form-error" data-form-error-for="fecha_new">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
                <div class="large-6 medium-8 small-12 columns">
                    <?= form_label(lang('hora'), 'hora_new'); ?>
                    <?= form_dropdown('hora_new', $horas, set_value('hora_new'), ['id' => 'hora_new', 'required' => 'required']); ?>
                    <span class="form-error" data-form-error-for="hora_new">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
            </div>
            <div class="large-12 medium-6 small-12 columns">
                <div class="large-5 medium-8 small-12 columns">
                    <?= form_label(lang('programa'), 'programa_new'); ?>
                    <?= form_dropdown('programa_new', $programas, set_value('programa_new'), ['id' => 'programa_new', 'required' => 'required']); ?>
                    <span class="form-error" data-form-error-for="programa_new">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
                <div class="large-6 medium-8 small-12 columns">
                    <?= form_label(lang('lugar'), 'lugar_new'); ?>
                    <input type="text" name="lugar_new" id="lugar_new" required onkeyup="javascript:this.value=this.value.toUpperCase();" />
                    <span class="form-error" data-form-error-for="lugar_new">
                        <?= lang('campo.requerido') ?>
                    </span>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="row">
        <div class="large-6 medium-6 small-1 large-centered columns">
            <br>
            <button type="button" title="Añadir" class="palette-Boton bg button expanded" onclick="registrar_agenda();"><i class="las la-save la-2x"></i>Registrar</button>
        </div>
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="small reveal" id="modalEspacios" data-reveal data-options="closeOnClick:false;">
    <div class="row">
        <center>
            <h3 id="titulo_motivo"></h3>
            <h4 id="titulo_interlocutor"></h4>
            <input type="hidden" id="id_espacio_modal" name="id_espacio_modal">
        </center>        
    </div>
    <div class="row">
        <div class="large-12 columns">
            <table id="spaces-table" class="display cell-border" style="width:100%">
            </table>
        </div>
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php $this->load->view('agenda/js/agenda') ?>
<?php $this->load->view('general/layout/footer') ?>