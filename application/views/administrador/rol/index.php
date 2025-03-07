<?php $this->load->view('general/layout/menu') ?>

<div class="row">
	<div class="large-7 large-centered columns">
		<?php $this->load->view('general/layout/message') ?>
      <div class="box no-shadow">
         <div class="box-header panel palette-Defecto bg">
            <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
	            <span><?=lang('roles')?></span>
	         </h3>
         </div>

         <div class="box-body">
            <div class="row">
					<div class="large-12 columns medium-12 small-12">
						<table id="table" class="hover display dataTable" style="width:100%">

						</table>
					</div>
				</div>
         </div>
      </div>
   </div>
</div>
<br>
<div class="reveal" id="modalEditar" data-reveal data-options="closeOnClick:false; closeOnEsc:false;">
   <?= form_open('editar-rol'); ?>
   <input type="hidden" id="id_rol" name="id_rol">
   <h3 class="lead"><?= lang('editar.rol') ?></h3>   
   <div class="row">
      <div class="large-12 columns">
         <?= form_label(lang('rol'), 'rol'); ?>
         <div class="input-group">
            <span class="input-group-label"><i class="las la-user-tie"></i></span>
            <?= form_input('rol', set_value('rol'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'rol']); ?>
         </div>
         <span class="form-error" data-form-error-for="rol">
            <?= lang('campo.requerido') ?>
         </span>
      </div>
   </div>
   <div class="row align-right">
      <div class="column small-6">
         <button type="button" data-close class="button expanded bg palette-Boton">Cancelar</button>
      </div>
      <div class="column small-6">
         <button type="submit" class="button expanded bg palette-Defecto">Editar Rol</button>
      </div>
   </div>
   <?= form_close(); ?>
</div>

<?php $this->load->view('administrador/rol/js/index') ?>
<?php $this->load->view('general/layout/footer') ?>