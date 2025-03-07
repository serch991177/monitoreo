<?php $this->load->view('general/layout/menu') ?>

<div class="row">
	<div class="large-6 large-centered columns">
		<?php $this->load->view('general/layout/message') ?>
      <div class="box no-shadow">
         
         <div class="box-header panel palette-Defecto bg">
            <h3 class="box-title palette-White"><i class="lab la-wpforms la-2x"></i>
	            <span><?=lang('registrar.gestion')?></span>
	         </h3>
         </div>

         <div class="box-body">

            <div class="row">
               <div class="large-12">
               <?=form_open('guardar-gestion', 'data-abide no-validate'); ?>


               <div class="row">
                  <div class="large-12 columns">
                  <?=form_label( lang('gestion'), 'gestion'); ?>
                     <div class="input-group">
                        <span class="input-group-label"><i class="las la-calendar"></i></span>
                        <?=form_input('gestion', set_value('gestion'), ['class'=>'input-group-field','required'=>'required','id'=>'gestion']); ?>
                     </div>

                     <span class="form-error" data-form-error-for="gestion">
                        <?=lang('campo.requerido')?>
                     </span>
                  </div>
               </div>

               <div class="row">
                  <div class="large-12 columns">
                     <?=form_label( lang('nombre.alcalde'), 'nombre_alcalde'); ?>
                     <div class="input-group">
                        <span class="input-group-label"><i class="las la-user-tie"></i></span>
                        <?=form_input('nombre_alcalde', set_value('nombre_alcalde'), ['class'=>'input-group-field', 'required'=>'required', 'id'=>'nombre_alcalde']); ?>
                     </div>

                     <span class="form-error" data-form-error-for="nombre_alcalde">
                        <?=lang('campo.requerido')?>
                     </span>
                  </div>
               </div>

               <div class="row">
                  <div class="large-12 columns">
                     <?=form_label( lang('cargo.alcalde'), 'cargo_alcalde'); ?>
                     <div class="input-group">
                        <span class="input-group-label"><i class="las la-user-cog"></i></span>
                        <?=form_input('cargo_alcalde', set_value('cargo_alcalde'), ['class'=>'input-group-field', 'required'=>'required', 'id'=>'cargo_alcalde']); ?>
                     </div>

                     <span class="form-error" data-form-error-for="cargo_alcalde">
                        <?=lang('campo.requerido')?>
                     </span>
                  </div>
               </div>

               <div class="row">
                  <div class="large-6 columns large-centered">  
                        <?=form_submit('send', lang('registrar'), ['class'=>'button expanded bg palette-Defecto']);?>
                  </div>
               </div>

               <?=form_close() ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

	
<?php $this->load->view('administrador/gestion/js/registrar') ?>
<?php $this->load->view('general/layout/footer') ?>