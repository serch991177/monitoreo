<head>
	<meta charset="utf-8">
	<title>Sistema de Monitoreo</title>

	<?php echo link_tag('node_modules/responsive-tabs/css/responsive-tabs.css'); ?>
	<?php echo link_tag('node_modules/responsive-tabs/css/style.css'); ?>
	<?php echo link_tag('node_modules/foundation-sites/dist/css/foundation-float.css'); ?>
	<?php echo link_tag('node_modules/foundation-sites/dist/css/foundation.css'); ?>
	<?php echo link_tag('node_modules/line-awesome/dist/line-awesome/css/line-awesome.css'); ?>

	<!-- MIS ESTILOS -->
	<?php echo link_tag('public/css/palette.css'); ?>
	<?php echo link_tag('public/css/theme.css'); ?>
	<?php echo link_tag('public/css/mystyle.css'); ?>

	<!-- DATA TABLE CSS -->
	<?php echo link_tag("public/css/data-table/jquery.dataTables.min.css") ?>
	<?php echo link_tag("public/css/data-table/buttons.dataTables.min.css") ?>
	<?php echo link_tag("public/css/data-table/responsive.dataTables.min.css") ?>

	<!-- JQUERY -->
	<script src="<?= base_url('node_modules/jquery/dist/jquery.js') ?>"></script>
	<script src="<?=base_url('node_modules/jquery-validation/dist/jquery.validate.js')?>"></script>	

	<!-- DATA TABLE JS -->
	<script src="<?php echo base_url('public/js/data-table/jquery.dataTables.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('public/js/data-table/dataTables.buttons.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('public/js/data-table/jszip.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('public/js/data-table/buttons.html5.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('public/js/data-table/dataTables.responsive.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('public/js/data-table/pdfmake.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('public/js/data-table/vfs_fonts.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('public/js/data-table/jquery.twbsPagination.js') ?>" type="text/javascript"></script>

	<!-- SELECT2 -->
	<?php echo link_tag('node_modules/select2/dist/css/select2.css'); ?>
	<script src="<?= base_url('node_modules/select2/dist/js/select2.js') ?>"></script>

	<!-- LEAFLET -->
	<script src="<?= base_url('node_modules/leaflet/dist/leaflet.js') ?>"></script>
	<script src="<?= base_url('node_modules/Proj4Leaflet-master/lib/proj4-compressed.js') ?>"></script>
	<script src="<?= base_url('node_modules/Proj4Leaflet-master/src/proj4leaflet.js') ?>"></script>	

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

	<!-- CHART.JS -->
	<script src="node_modules/chart.js/dist/chart.js"></script>
	<script src="node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.js"></script>

	<!-- LIGHTGALLERY -->
	<?php echo link_tag('node_modules/lightgallery/css/lightgallery.css'); ?>

	<!-- lightgallery plugins -->
	<?php echo link_tag('node_modules/lightgallery/css/lg-zoom.css'); ?>
	<?php echo link_tag('node_modules/lightgallery/css/lg-thumbnail.css'); ?>

	<script src="node_modules/lightgallery/lightgallery.umd.js"></script>

	<script src="node_modules/lightgallery/plugins/thumbnail/lg-thumbnail.umd.js"></script>
	<script src="node_modules/lightgallery/plugins/zoom/lg-zoom.umd.js"></script>

	<!-- SWEETALERT2 -->
	<?php echo link_tag('node_modules/sweetalert2/sweetalert2.min.css') ?>
	<script src="<?php echo base_url('node_modules/sweetalert2/sweetalert.min.js') ?>"></script>

	<!-- LIGHTBOX -->
	<?php echo link_tag('node_modules/lightbox2/dist/css/lightbox.css') ?>
	<script src="<?php echo base_url('node_modules/lightbox2/dist/js/lightbox.js') ?>"></script>

	<!-- TINYMCE -->
	<script src="<?php echo base_url('node_modules/tinymce/tinymce.min.js') ?>"  referrerpolicy="origin"></script>

	<!-- UTM -->
	<script src="<?= base_url('public/js/L.LatLng.UTM.js') ?>"></script>

	<link rel=" icon" href="favicon.png" type="image/png" />
</head>