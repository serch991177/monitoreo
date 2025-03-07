<?php $this->load->view('general/layout/menu') ?>

<div class="row">
    <div class="large-11 large-centered columns">
        <?php $this->load->view('general/layout/message') ?>
        <div class="box no-shadow">
            <div class="box-header panel palette-Defecto bg">
                <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
                    <span><?= lang('reporte.medio') ?></span>
                </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="large-3 columns">
                        <?= form_label(lang('medio'), 'medio'); ?>
                        <?= form_dropdown('medio', $medios, 'medio', ['class' => 'input-group-field', 'id' => 'medio']); ?>
                        <span class="form-error" data-form-error-for="medio">
                            <?= lang('campo.requerido') ?>
                        </span>
                    </div>
                    <div class="large-3 columns">
                        <?= form_label(lang('fecha.inicio'), 'fecha_ini'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="las la-calendar-check"></i></span>
                            <?= form_input('fecha_ini', set_value('fecha_ini'), ['class' => 'input-group-field', 'id' => 'fecha_ini']); ?>
                        </div>
                    </div>
                    <div class="large-3 columns">
                        <?= form_label(lang('fecha.fin'), 'fecha_fin'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="las la-calendar-check"></i></span>
                            <?= form_input('fecha_fin', set_value('fecha_fin'), ['class' => 'input-group-field', 'id' => 'fecha_fin']); ?>
                        </div>
                    </div>
                    <div class="large-3 columns">
                        <?= form_label(lang('tendencia'), 'tendencia'); ?>
                        <?= form_dropdown('tendencia', $tendencias, 'tendencia', ['class' => 'input-group-field', 'id' => 'tendencia']); ?>
                        <span class="form-error" data-form-error-for="tendencia">
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
                                    <th>Medio</th>
                                    <th>Tema</th>
                                    <th>Detalle Nota</th>
                                    <th>Turno</th>
                                    <th>Fecha</th>
                                    <th>Tendencia</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('dashboard/js/reporte') ?>
<?php $this->load->view('general/layout/footer') ?>