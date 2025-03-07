<?php $this->load->view('general/layout/menu') ?>

<div class="row">
	<div class="large-11 large-centered columns">
		<?php $this->load->view('general/layout/message') ?>
      <div class="box no-shadow">
         <div class="box-header panel palette-Defecto bg">
            <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
	            <span><?=lang('funciones.defecto')?></span>
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


<?php $this->load->view('administrador/defecto/js/index') ?>
<?php $this->load->view('general/layout/footer') ?>