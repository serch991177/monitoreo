<?php $this->load->view('general/layout/head') ?>

<body class="fondoclass">
	<?php $this->load->view('general/layout/message') ?>
	<center>
		<br>
		<div class="card" style="width:40%; margin-top:12%;">
			<div class="card-section">
				<?= img('public/images/logo.png') ?>
			</div>
			<div class="card-section">
				<?= form_open('iniciar-sesion', 'data-abide no-validate'); ?>
				<div class="row column">
					<div class="large-8 medium-10 small-12">
						<?= form_label(lang('dni'), 'dni'); ?>
						<div class="input-group">
							<span class="input-group-label"><i class="las la-id-card"></i></span>
							<?= form_input('dni', set_value('dni'), ['class' => 'input-group-field', 'required' => 'required', 'id' => 'login_dni']); ?>
						</div>
						<span class="form-error" data-form-error-for="login_dni">
							<?= lang('campo.requerido') ?>
						</span>
					</div>
					<div class="large-8 medium-10 small-12">
						<?= form_label(lang('contrasenia'), 'password'); ?>
						<div class="input-group">
							<span class="input-group-label"><i class="las la-key"></i></span>
							<?= form_password('password', null, ['class' => 'input-group-field', 'required' => 'required', 'id' => 'login_password']); ?>
						</div>
						<span class="form-error" data-form-error-for="login_password">
							<?= lang('campo.requerido') ?>
						</span>
					</div>
					<div class="large-8 medium-10 small-12">
						<?= form_submit('send', lang('iniciar.sesion'), ['class' => 'button expanded bg palette-NInstitucional']); ?>
					</div>
				</div>
				<?= form_close() ?>
			</div>
		</div>
	</center>

	<?php $this->load->view('general/layout/footer-login') ?>
	<?php $this->load->view('general/login/js/login') ?>