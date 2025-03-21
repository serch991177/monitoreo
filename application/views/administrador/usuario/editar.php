<?php $this->load->view('general/layout/menu') ?>
<div class="row">
	<div class="large-10 large-centered columns">
		<?php $this->load->view('general/layout/message') ?>
		<div class="box no-shadow">

			<div class="box-header panel palette-Defecto bg">
				<h3 class="box-title palette-White"><i class="lab la-wpforms la-2x"></i>
					<span><?= lang('editar.usuario') ?></span>
				</h3>
			</div>

			<div class="box-body">

				<div class="row">
					<div class="large-12">

						<?= form_open('modificar-usuario', 'data-abide no-validate'); ?>

						<div class="row">
							<div class="large-4 column">
								<?= form_label(lang('dni'), 'dni'); ?>
								<div class="input-group">
									<span class="input-group-label"><i class="las la-id-card"></i></span>
									<?= form_input('dni', $usuario->dni, ['class' => 'input-group-field', 'required' => 'required', 'id' => 'dni', 'readonly'=>'readonly']); ?>
								</div>
								<span class="form-error" data-form-error-for="dni">
									<?= lang('campo.requerido') ?>
								</span>
							</div>
							<div class="large-8 column">
								<?= form_label(lang('nombre.completo'), 'nombre_completo'); ?>
								<div class="input-group">
									<span class="input-group-label"><i class="las la-user"></i></span>
									<?= form_input('nombre_completo', $usuario->nombre_completo, ['class' => 'input-group-field', 'id' => 'nombre_completo', 'required' => 'required']); ?>
								</div>
								<span class="form-error" data-form-error-for="nombre_completo">
									<?= lang('campo.requerido') ?>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="large-7 column">
								<?= form_label(lang('unidad.organizacional'), 'unidad_organizacional'); ?>
								<div class="input-group">
									<span class="input-group-label"><i class="las la-briefcase"></i></span>
									<?= form_input('unidad_organizacional', $usuario->unidad_organizacional, ['class' => 'input-group-field', 'id' => 'unidad_organizacional', 'required' => 'required']); ?>
								</div>
								<span class="form-error" data-form-error-for="unidad_organizacional">
									<?= lang('campo.requerido') ?>
								</span>
							</div>
							<div class="large-5 column">
								<?= form_label(lang('cargo'), 'cargo'); ?>
								<div class="input-group">
									<span class="input-group-label"><i class="las la-user-tie"></i></span>
									<?= form_input('cargo', $usuario->cargo, ['class' => 'input-group-field', 'id' => 'cargo', 'required' => 'required']); ?>
								</div>
								<span class="form-error" data-form-error-for="cargo">
									<?= lang('campo.requerido') ?>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="large-4 column">
								<?= form_label(lang('nro.item'), 'nro_item'); ?>
								<div class="input-group">
									<span class="input-group-label"><i class="las la-list-ol"></i></span>
									<?= form_input('nro_item', $usuario->nro_item, ['class' => 'input-group-field', 'id' => 'nro_item']); ?>
								</div>
							</div>
							<div class="large-8 column">
								<?= form_label(lang('correo'), 'register_correo'); ?>
								<div class="input-group">
									<span class="input-group-label"><i class="las la-envelope"></i></span>
									<?= form_input('register_correo', $usuario->correo_municipal, ['class' => 'input-group-field', 'id' => 'register_correo', 'pattern' => 'email']); ?>
								</div>
								<span class="form-error" data-form-error-for="register_correo">
									<?= lang('correo.invalido') ?>
								</span>
							</div>
						</div>						
						<div class="large-8 large-centered columns">
                            <input type="hidden" name="usuario" value="<?= $usuario->id_usuario; ?>">
                            <input type="hidden" name="persona" value="<?= $usuario->id_persona; ?>">
							<?= form_submit('send', lang('registrarse'), ['class' => 'button expanded bg palette-Defecto']); ?>
						</div>
					</div>
					<?= form_close() ?>

				</div>
				</fieldset>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('general/layout/footer') ?>