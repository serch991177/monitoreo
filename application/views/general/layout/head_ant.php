<head>
	<meta charset="utf-8">
	<title>Sistema de Monitoreo</title>

	<?php echo link_tag('node_modules/responsive-tabs/css/responsive-tabs.css'); ?>
	<?php echo link_tag('node_modules/responsive-tabs/css/style.css'); ?>
	<?php echo link_tag('node_modules/foundation-sites/dist/css/foundation-float.css'); ?>
	<?php echo link_tag('node_modules/foundation-sites/dist/css/foundation.css'); ?>
	<?php echo link_tag('node_modules/line-awesome/dist/line-awesome/css/line-awesome.css'); ?>
	<?php echo link_tag('node_modules/datatables/media/css/jquery.dataTables.css'); ?>

	<!-- MIS ESTILOS -->
	<?php echo link_tag('public/css/palette.css'); ?>
	<?php echo link_tag('public/css/theme.css'); ?>
	<?php echo link_tag('public/css/mystyle.css'); ?>
	<?php echo link_tag('public/css/datatableresponsive.css'); ?>

	<!-- JQUERY -->
	<script src="<?= base_url('node_modules/jquery/dist/jquery.js') ?>"></script>
	<script src="<?= base_url('node_modules/jquery-validation/dist/jquery.validate.js') ?>"></script>

	<!-- SELECT2 -->
	<?php echo link_tag('node_modules/select2/dist/css/select2.css'); ?>
	<script src="<?= base_url('node_modules/select2/dist/js/select2.js') ?>"></script>

	<!-- DATATABLE RESPONSIVE -->
	<script src="<?= base_url('node_modules/datatables/media/js/jquery.dataTables.js') ?>"></script>
	<script src="<?= base_url('node_modules/datatables.net-responsive/js/dataTables.responsive.js') ?>"></script>

	<!-- LEAFLET -->
	<script src="<?= base_url('node_modules/leaflet/dist/leaflet.js') ?>"></script>
	<?php echo link_tag('node_modules/leaflet/dist/leaflet.css'); ?>

	<!--PIACKADATE-->
	<script src="<?= base_url('node_modules/pickadate/lib/picker.js') ?>"></script>
	<script src="<?= base_url('node_modules/pickadate/lib/picker.date.js') ?>"></script>
	<?php echo link_tag('node_modules/pickadate/lib/themes/classic.css'); ?>
	<?php echo link_tag('node_modules/pickadate/lib/themes/classic.date.css'); ?>

	<!-- BOOTSTRAP -->
	<!-- <script src="<?= base_url('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
	<?php echo link_tag('node_modules/bootstrap/dist/css/bootstrap.min.css'); ?> -->

	<!--  CKEDITOR -->
	<script src="<?= base_url('node_modules/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') ?>"></script>

	<!-- MULTIPLE SELECT -->
	<?php echo link_tag('public/multiple_select/MSFmultiSelect.css'); ?>
	<script src="public/multiple_select/MSFmultiSelect.js"></script>

	<!-- SWEETALERT -->
	<script src="<?= base_url('node_modules/sweetalert/dist/sweetalert.min.js') ?>"></script>

	<!-- CHART.JS -->
	<script src="node_modules/chart.js/dist/chart.js"></script>
	<script src="node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.js"></script>

	<link rel=" icon" href="favicon.png" type="image/png" />
</head>