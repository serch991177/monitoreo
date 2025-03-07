<?php $this->load->view('general/layout/menu') ?>

<div class="row">
   <div class="large-6 large-centered columns">
      <?php $this->load->view('general/layout/message') ?>
      <div class="box no-shadow">

         <div class="box-header panel palette-Defecto bg">
            <h3 class="box-title palette-White"><i class="lab la-wpforms la-2x"></i>
               <span><?= lang('registrar.dni.especial') ?></span>
            </h3>
         </div>

         <div class="box-body">

            <div class="row">
               <div class="large-12">
                  <?= form_open('guardar-dni', 'data-abide no-validate'); ?>

                  <div class="row">
                     <div class="large-12 columns">
                        <?= form_label(lang('roles'), 'rol'); ?>
                        <div class="input-group">
                           <span class="input-group-label"><i class="las la-user-tie"></i></span>
                           <?= form_dropdown('id_rol', $roles, set_value('rol'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'rol']); ?>
                        </div>
                        <span class="form-error" data-form-error-for="rol">
                           <?= lang('campo.requerido') ?>
                        </span>
                     </div>
                  </div>

                  <div class="row" id="dynamic_field">
                     <div class="large-12 columns">
                        <?= form_label(lang('dni'), 'dni[0]'); ?>
                        <div class="input-group">
                           <span class="input-group-label"><i class="las la-address-card"></i></span>
                           <?= form_input('dni[0]', set_value('dni'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'dni']); ?>
                           <span class="input-group-label" id="add"><i class="las la-plus-circle"></i></span>
                        </div>

                        <span class="form-error" data-form-error-for="dni">
                           <?= lang('campo.requerido') ?>
                        </span>
                     </div>
                  </div>

                  <div class="row">
                     <div class="large-6 columns large-centered">
                        <?= form_submit('send', lang('registrar'), ['class' => 'button expanded bg palette-Defecto']); ?>
                     </div>
                  </div>

                  <?= form_close() ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php $this->load->view('administrador/especial/js/registrar') ?>
<?php $this->load->view('general/layout/footer') ?>