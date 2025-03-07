<?php $this->load->view('general/layout/menu') ?>

<div class="row">
	<div class="large-10 large-centered columns">
		<?php $this->load->view('general/layout/message') ?>
      <div class="box no-shadow">
         
         <div class="box-header panel palette-Defecto bg">
            <h3 class="box-title palette-White"><i class="las la-pen la-2x"></i>
	            <span><?=lang('editar.funcion')?></span>
	         </h3>
         </div>

         <div class="box-body">

            <div class="row">
               <div class="large-12">
               <?=form_open('actualizar-funcion', 'data-abide no-validate'); ?>

               <div class="row">
                  <div class="large-4 columns">
                     <?=form_label( lang('funcion'), 'funcion'); ?>
                     <div class="input-group">
                        <span class="input-group-label"><i class="las la-pen"></i></span>
                        <?=form_input('funcion', set_value('funcion', $funcion->nombre_accion), ['class'=>'input-group-field', 'required'=>'required', 'id'=>'funcion']); ?>
                     </div>

                     <span class="form-error" data-form-error-for="funcion">
                        <?=lang('campo.requerido')?>
                     </span>
                  </div>

                  <div class="large-4 columns">
                     <?=form_label( lang('icono'), 'icono'); ?>
                     <div class="input-group">
                        <span class="input-group-label"><i class="las la-icons"></i></span>
                        <?=form_input('icono', set_value('icono', $funcion->icon), ['class'=>'input-group-field', 'id'=>'icono']); ?>
                     </div>
                  </div>

                  <div class="large-4 columns">
                     <?=form_label( lang('ruta.amigable'), 'ruta_amigable'); ?>
                     <div class="input-group">
                        <span class="input-group-label"><i class="las la-road"></i></span>
                        <?=form_input('ruta_amigable', set_value('ruta_amigable', $funcion->ruta_amigable), ['class'=>'input-group-field', 'id'=>'ruta_amigable']); ?>
                     </div>

                     <span class="form-error" data-form-error-for="ruta_amigable">
                        <?=lang('campo.requerido')?>
                     </span>
                  </div>
               </div>

               <div class="row">
                  <div class="large-4 columns">
                     <?=form_label( lang('es.menu'), 'es_menu'); ?>
                     <div class="input-group">
                        <span class="input-group-label"><i class="las la-sitemap"></i></span>
                        <?=form_dropdown('es_menu', $si_no, set_value('es_menu', $funcion->es_menu), ['class'=>'input-group-field', 'required'=>'required','id'=>'es_menu','onchange' => 'selectMenu();']); ?>
                     </div>

                     <span class="form-error" data-form-error-for="es_menu">
                        <?=lang('campo.requerido')?>
                     </span>
                  </div>
                  <div class="large-4 columns">
                     <?=form_label( lang('es.submenu'), 'es_submenu'); ?>
                     <div class="input-group">
                        <span class="input-group-label"><i class="las la-sitemap"></i></span>
                        <?=form_dropdown('es_submenu', $si_no, set_value('es_submenu', $funcion->es_submenu), ['class'=>'input-group-field', 'required'=>'required', 'id'=>'es_submenu','onchange' => 'selectSubmenu();']); ?>
                     </div>

                     <span class="form-error" data-form-error-for="es_submenu">
                        <?=lang('campo.requerido')?>
                     </span>
                  </div>
                  <div class="large-4 columns">
                     <?=form_label( lang('es.sub.submenu'), 'es_sub_submenu'); ?>
                     <div class="input-group">
                        <span class="input-group-label"><i class="las la-sitemap"></i></span>
                        <?=form_dropdown('es_sub_submenu', $si_no, set_value('es_sub_submenu', $funcion->es_sub_submenu), ['class'=>'input-group-field', 'required'=>'required', 'id'=>'es_sub_submenu','onchange' => 'selectSubsubmenu();']); ?>
                     </div>

                     <span class="form-error" data-form-error-for="es_sub_submenu">
                        <?=lang('campo.requerido')?>
                     </span>
                  </div>
               </div>


               <div class="row">
                  <div class="large-4 columns">
                     <?=form_label( lang('es.boton'), 'es_boton'); ?>
                     <div class="input-group">
                        <span class="input-group-label"><i class="las la-mouse"></i></span>
                        <?=form_dropdown('es_boton', $si_no, set_value('es_boton', $funcion->es_boton), ['class'=>'input-group-field', 'required'=>'required','id'=>'es_boton']); ?>
                     </div>

                     <span class="form-error" data-form-error-for="es_boton">
                        <?=lang('campo.requerido')?>
                     </span>
                  </div>

                  <div class="large-4 columns">
                     <?=form_label( lang('funcion.padre'), 'id_padre'); ?>
                     <?=form_dropdown('id_padre', $funciones, set_value('id_padre', $funcion->id_padre), ['class'=>'input-group-field', 'id'=>'id_padre']); ?>
                     <span class="form-error" data-form-error-for="id_padre">
                        <?=lang('campo.requerido')?>
                     </span>
                  </div>
                  <div class="large-4 columns">
                     <?=form_label( lang('estilos'), 'estilo'); ?>
                     <div class="input-group">
                        <span class="input-group-label"><i class="las la-brush"></i></span>
                        <?=form_input('estilo', set_value('estilo', $funcion->class), ['class'=>'input-group-field', 'required'=>'required', 'id'=>'estilo']); ?>
                     </div>

                     <span class="form-error" data-form-error-for="estilo">
                        <?=lang('campo.requerido')?>
                     </span>
                  </div>
               </div>

               <div class="row">
                  <div class="large-6 columns large-centered"> 
                     
                        <?=form_submit('send', lang('actualizar'), ['class'=>'button expanded bg palette-Defecto']);?>
                  </div>
               </div>

                  <?=form_hidden('id_funcion', $funcion->id_accion);?>
               
               <?=form_close() ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

	
<?php $this->load->view('administrador/funcion/js/registrar') ?>
<?php $this->load->view('general/layout/footer') ?>