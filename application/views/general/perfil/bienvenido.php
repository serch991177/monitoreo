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

               </div>
            </div>
         </div>
      </div>
   </div>
</div>



<?php $this->load->view('general/perfil/js/bienvenido') ?>
<?php $this->load->view('general/layout/footer') ?>
