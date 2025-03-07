<?php $this->load->view('general/layout/menu') ?>

<div class="row">
	<div class="large-6 large-centered columns">
		<?php $this->load->view('general/layout/message') ?>
      <div class="box no-shadow">
         
         <div class="box-header panel palette-Defecto bg">
            <h3 class="box-title palette-White"><i class="lab la-wpforms la-2x"></i>
	            <span><?=lang('registrar.rol')?></span>
	         </h3>
         </div>

         <div class="box-body">

            <div class="row">
               <div class="large-12">
               <?=form_open('guardar-rol', 'data-abide no-validate'); ?>


               <div class="row">
                  <div class="large-12 columns">
                  <?=form_label( lang('rol'), 'rol'); ?>
                     <div class="input-group">
                        <span class="input-group-label"><i class="las la-user-tag"></i></span>
                        <?=form_input('rol', set_value('rol'), ['class'=>'input-group-field','required'=>'required','id'=>'rol']); ?>
                     </div>

                     <span class="form-error" data-form-error-for="rol">
                        <?=lang('campo.requerido')?>
                     </span>
                  </div>
               </div>

               <div class="row">
                  <div class="large-6 columns large-centered">  
                        <?=form_submit('send', lang('registrar'), ['class'=>'button expanded bg palette-Defecto'])?>
                  </div>
               </div>

               <?=form_close() ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

	
<?php $this->load->view('administrador/rol/js/registrar') ?>
<?php $this->load->view('general/layout/footer') ?>