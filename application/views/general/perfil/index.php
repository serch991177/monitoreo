<?php $this->load->view('general/layout/menu') ?>

<div class="row">
	<div class="large-7 large-centered columns">
		<?php $this->load->view('general/layout/message') ?>
      <div class="box no-shadow">
         <div class="box-header panel palette-Defecto bg">
            <h3 class="box-title palette-White"><i class="las la-info"></i>
	            <span><?=lang('mis.datos')?></span>
	         </h3>
         </div>

         <div class="box-body">
            <div class="row">
               <div class="large-12">
                  <table>
                     <tr>
                        <th width="35%"><?=lang('nombre.completo')?></th>

                        <td width="65%"><h6><?=$usuario->nombre_completo?></h6></td>
                     </tr>

                     <tr>
                        <th width="35%"><?=lang('dni')?></th>

                        <td width="65%"><h6><?=$usuario->dni?></h6></td>
                     </tr>

                     <tr>
                        <th width="35%"><?=lang('cargo')?></th>

                        <td width="65%"><h6><?=$usuario->cargo?></h6></td>
                     </tr>

                     <tr>
                        <th width="35%"><?=lang('nro.item')?></th>

                        <td width="65%"><h6><?=$usuario->nro_item?></h6></td>
                     </tr>


                     <tr>
                        <th width="35%"><?=lang('unidad.organizacional')?></th>

                        <td width="65%"><h6><?=$usuario->unidad_organizacional?></h6></td>
                     </tr>

                     <tr>
                        <th width="35%"><?=lang('correo')?></th>

                        <td width="65%"><h6><?=$usuario->correo_municipal?></h6></td>
                     </tr>

                     <tr>
                        <th width="35%"><?=lang('rol')?></th>

                        <td width="65%"><h6><?=$usuario->nombre_rol?></h6></td>
                     </tr>


                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>



<?php $this->load->view('general/perfil/js/informacion') ?>
<?php $this->load->view('general/layout/footer') ?>
