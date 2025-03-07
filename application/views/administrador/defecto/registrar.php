<?php $this->load->view('general/layout/menu') ?>

<div class="row">
	<div class="large-6 large-centered columns">
		<?php $this->load->view('general/layout/message') ?>
      <div class="box no-shadow">
         
         <div class="box-header panel palette-Defecto bg">
            <h3 class="box-title palette-White"><i class="lab la-wpforms la-2x"></i>
	            <span><?=lang('registrar.funcion.defecto')?></span>
	         </h3>
         </div>

         <div class="box-body">

            <div class="row">
               <div class="large-12">
               <?=form_open('guardar-funcion-defecto', 'data-abide no-validate'); ?>


               <div class="row">
                  <div class="large-12 columns">
                     <?=form_label( lang('funcion'), 'id_accion'); ?>
                    
                        <?=form_dropdown('id_accion', $funciones, set_value('id_accion'), ['class'=>'input-group-field', 'required'=>'required','id'=>'id_accion']); ?>

                        <span class="form-error" data-form-error-for="id_accion">
                           <?=lang('campo.requerido')?>
                        </span>
                  </div>
               </div>

               <div class="row">
                  <div class="large-12 columns">
                     <?=form_label( lang('roles'), 'id_rol'); ?>
                    
                        <?=form_dropdown('id_rol', $roles, set_value('id_rol'), ['class'=>'input-group-field', 'required'=>'required','id'=>'id_rol']); ?>

                        <span class="form-error" data-form-error-for="id_rol">
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

	
<?php $this->load->view('administrador/defecto/js/registrar') ?>
<?php $this->load->view('general/layout/footer') ?>