<?php require_once INCLUDES.'inc_header.php'; ?>

<div class="row">
	<div class="col-xl-6 col-md-6 col-12">
		<!-- Collapsable Card Example -->
		<div class="card shadow mb-4">
			<!-- Card Header - Accordion -->
			<a href="#usuarios_data" class="d-block card-header py-3" data-toggle="collapse"
				role="button" aria-expanded="true" aria-controls="usuarios_data">
				<h6 class="m-0 font-weight-bold text-primary">
					<?php echo sprintf('Usuario %s', $d->t->nombres); ?>
					<div class="float-right">
						<?php echo format_estado_usuario($d->t->status); ?>
					</div>
				</h6>
			</a>
			<!-- Card Content - Collapse -->
			<div class="collapse show" id="usuarios_data">
				<div class="card-body">
					<form action="users/post_editar" method="post">
						<?php echo insert_inputs(); ?>
						<input type="hidden" name="id" value="<?php echo $d->t->id; ?>" required>
						
						<div class="form-group">
							<label for="nombres">Nombre(s)</label>
							<input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $d->t->nombres; ?>" required>
						</div>

						<div class="form-group">
							<label for="apellidos">Apellido(s)</label>
							<input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $d->t->apellidos; ?>" required>
						</div>

						<div class="form-group">
							<label for="email">Correo electrónico</label>
							<input type="email" class="form-control" id="email" name="email" value="<?php echo $d->t->email; ?>" required>
						</div>

						<div class="form-group">
							<label for="telefono">Teléfono</label>
							<input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $d->t->telefono; ?>">
						</div>

						<div class="form-group">
							<label for="password">Contraseña</label>
							<input type="password" class="form-control" id="password" name="password">
						</div>

						<div class="form-group">
							<label for="conf_password">Confirmar contraseña</label>
							<input type="password" class="form-control" id="conf_password" name="conf_password">
						</div>

						<div class="form-group">
							<label for="creado">Creado</label>
							<input type="text" class="form-control" id="creado" name="creado" value="<?php echo format_date($d->t->creado); ?>" disabled>
						</div>

						<button class="btn btn-success" type="submit">Guardar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once INCLUDES.'inc_footer.php'; ?>