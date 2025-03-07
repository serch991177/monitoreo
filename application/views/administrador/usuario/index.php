<?php $this->load->view('general/layout/menu') ?>

<div class="row">
   <div class="large-11 large-centered columns">
      <?php $this->load->view('general/layout/message') ?>
      <div class="box no-shadow">
         <div class="box-header panel palette-Defecto bg">
            <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
               <span><?= lang('usuarios') ?></span>
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

<div class="reveal" id="modalRol" data-reveal data-options="closeOnClick:false; closeOnEsc:false;">

   <?= form_open('cambiar-rol'); ?>
      <input type="hidden" id="id_usuario" name="id_usuario">
      <input type="hidden" id="rol_ant" name="rol_ant">
      <h3 class="lead"><?= lang('cambio.rol') ?></h3>
      <p><label id="productormodal" style="font-weight:bold"><label></p>
      <p><?= lang('nombre.usuario') ?>: <label id="usu" style="display:inline; font-weight:bold"><label></p>
      <div class="large-12 columns">
         <?= form_label(lang('roles'), 'id_rol'); ?>
         <div class="input-group">
            <span class="input-group-label"><i class="las la-user-tie"></i></span>
            <?= form_dropdown('id_rol', $roles, set_value('id_rol'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'id_rol']); ?>
         </div>
         <span class="form-error" data-form-error-for="id_rol">
            <?= lang('campo.requerido') ?>
         </span>
      </div>
      <div class="row align-right">
         <div class="column small-6">
            <button type="button" data-close class="button expanded bg palette-Boton">Cancelar</button>
         </div>
         <div class="column small-6">
            <button type="submit" class="button expanded bg palette-Defecto">Cambiar Rol</button>
         </div>
      </div>
   <?= form_close(); ?>
</div>

<?php $this->load->view('administrador/usuario/js/index') ?>
<?php $this->load->view('general/layout/footer') ?>