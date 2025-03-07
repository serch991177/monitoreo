<?php $this->load->view('general/layout/menu') ?>

<div class="row">
	<div class="large-7 large-centered columns">
		<?php $this->load->view('general/layout/message') ?>
      <div class="box no-shadow">
         <div class="box-header panel palette-Defecto bg">
            <h3 class="box-title palette-White"><i class="las la-info"></i>
	            <span><?=lang('informacion')?></span>
	         </h3>
         </div>

         <div class="box-body">
            <div class="row">
               <div class="large-12">
                  <table>
                     <tr>
                        <th width="35%"><?=lang('version.php')?></th>

                        <td width="65%"><h6><?=phpversion()?></h6></td>
                     </tr>

                     <tr>
                        <th width="35%"><?=lang('nombre.base.datos')?></th>

                        <td width="65%"><h6><?=pg_dbname()?></h6></td>
                     </tr>

                     <tr>
                        <th width="35%"><?=lang('version.base.datos')?></th>

                        <td width="65%"><h6><?=pg_version()['server']?></h6></td>
                     </tr>

                     <tr>
                        <th width="35%"><?=lang('servidor')?></th>

                        <td width="65%"><h6><?= pg_host()?></h6></td>
                     </tr>


                     <tr>
                        <th width="35%"><?=lang('zona.horaria')?></th>

                        <td width="65%"><h6><?=pg_version()['TimeZone']?></h6></td>
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