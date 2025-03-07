<?php $this->load->view('general/layout/menu') ?>

<div class="row">
    <div class="large-7 large-centered columns">
        <?php $this->load->view('general/layout/message') ?>
        <div class="box no-shadow">
            <div class="box-header panel palette-Defecto bg">
                <h3 class="box-title palette-White"><i class="lab la-wpforms la-2x"></i>
                    <span><?= lang('cambiar.contrasenia') ?></span>
                </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="large-12 medium-6 small-12 columns ">
                        <?= form_open_multipart('registrar-cambiar-contrasenia', 'data-abide no-validate'); ?>

                        <?= form_label(lang('contrasenia.antigua'), 'old_password'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="icon las la-key"></i></span>
                            <?= form_password('old_password', null, ['class' => 'input-group-field', 'required' => 'required', 'id' => 'old_password']); ?>
                        </div>
                        <span class="form-error" data-form-error-for="old_password">
                            <?= lang('campo.requerido') ?>
                        </span>
                        <?= form_label(lang('contrasenia.nueva'), 'new_password'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="icon las la-key"></i></span>
                            <?= form_password('new_password', null, ['class' => 'input-group-field', 'required' => 'required', 'id' => 'new_password', 'pattern' => '^(?=\w*\d)(?=\w*[A-Z])\S{8,}$']); ?>
                        </div>
                        <span class="form-error" data-form-error-for="new_password">
                            <?= lang('formato.contrasenia') ?>
                        </span>

                        <?= form_label(lang('repetir.contrasenia'), 're_password'); ?>
                        <div class="input-group">
                            <span class="input-group-label"><i class="icon las la-key"></i></span>
                            <?= form_password('re_password', null, ['class' => 'input-group-field', 'required' => 'required', 'id' => 're_password', 'data-equalto' => 'new_password']); ?>
                        </div>
                        <span class="form-error" data-form-error-for="re_password">
                            <?= lang('contrasenia.diferentes') ?>
                        </span>
                    </div>
                    <div class="large-6 medium-6 small-12 large-centered columns">
                        <p>
                            <?= form_button(['type' => 'submit', 'class' => 'button expanded bg palette-Defecto', 'content' => '<i class="icon las la-key la-2x"></i><span class="text-button">' . lang('cambiar.contrasenia') . '</span>']); ?>
                        </p>
                    </div>

                    <?= form_close() ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('general/layout/footer') ?>