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
                    <div class="large-3 columns">
                        <?= form_label(lang('fecha.inicio'), 'fecha_ini'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="las la-calendar-check"></i></span>
                            <?= form_input('fecha_ini', set_value('fecha_ini'), ['class' => 'input-group-field ignore', 'id' => 'fecha_ini']); ?>
                        </div>
                    </div>
                    <div class="large-3 columns">
                        <?= form_label(lang('fecha.fin'), 'fecha_fin'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="las la-calendar-check"></i></span>
                            <?= form_input('fecha_fin', set_value('fecha_fin'), ['class' => 'input-group-field ignore', 'id' => 'fecha_fin']); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <table id="example" class="display cell-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tema</th>
                                    <th>Cantidad Notas</th>
                                    <th>Positivas</th>
                                    <th>Negativas</th>
                                    <th>Neutras</th>
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

<div class="large reveal" id="modalNotas" data-reveal data-options="closeOnClick:false;">    
    <div class="row">
        <center>
        <h3 id="titulo_tema"></h3>
        </center>
        <div class="large-12 columns">
            <table id="notas-table" class="display cell-border" style="width:100%">
            </table>
        </div>
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php $this->load->view('dashboard/js/dashboard') ?>
<?php $this->load->view('general/layout/footer') ?>