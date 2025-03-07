<?php $this->load->view('general/layout/menu') ?>

<div class="row">
	<div class="large-11 large-centered columns">
		<?php $this->load->view('general/layout/message') ?>
      <div class="box no-shadow">
         <div class="box-header panel palette-Defecto bg">
            <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
               <span><?=lang('funciones')?> DE <u><?=$usuario?></u></span>
	         </h3>
         </div>

         <div class="box-body">
            <div class="row">
               <div class="large-12">
                  <table id="table" class="hover">
                                       
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>



<?php $this->load->view('administrador/usuario/js/funciones') ?>
<?php $this->load->view('general/layout/footer') ?>