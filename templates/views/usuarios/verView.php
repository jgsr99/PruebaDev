<?php require_once INCLUDES.'inc_header.php'; ?>

<div class="row">
    <div class="col-xl-6 col-md-6 col-12">
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#alumno_data" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="alumno_data">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $d->title; ?></h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="alumno_data">
                <div class="card-body">
                    <form action="usuarios/post_editar" method="post" enctype="multipart/form-data" onsubmit="return validatePassword()">
                        <?php echo insert_inputs(); ?>
                        <input type="hidden" name="id" value="<?php echo $d->a->id; ?>" required>

                        <div class="form-group">
							<label for="perfil">Foto de perfil</label>
							<input type="file" class="form-control" id="perfil" name="perfil" accept="image/png, image/gif, image/jpeg">
						</div>

						<div class="card-body">
                            <?php if (property_exists($d->a, 'perfil') && $d->a->perfil !== null): ?>
								<?php if(is_file(UPLOADS.$d->a->perfil)): ?>
									<a href="<?php echo UPLOADED.$d->a->perfil; ?>" data-lightbox="Perfil" title="<?php echo sprintf('Foto de perfil %s', $d->a->nombres) ?>">
										<img src="<?php echo UPLOADED.$d->a->perfil; ?>" alt="<?php echo sprintf('Foto de perfil %s', $d->a->nombres) ?>" class="img-fluid img-thumbnail">						
									</a>						
								<?php else: ?>
									<a href="<?php echo get_image('broken.png'); ?>" data-lightbox="Perfil" title="<?php echo sprintf('Foto de perfil %s', $d->a->nombres) ?>">
										<img src="<?php echo get_image('broken.png'); ?>" alt="<?php echo sprintf('Foto de perfil %s', $d->a->nombres) ?>" class="img-fluid img-thumbnail">						
									</a>
									<p class="text-muted"><?php echo sprintf('El archivo <b>%s</b> no existe o esta dañado.', $d->a->nombres) ?></p>
								<?php endif; ?>											
							<?php else: ?>
								No hay una foto de perfil definido aún.	
							<?php endif; ?>
						</div>

                        <div class="form-group">
                            <label for="nombres">Nombre(s)</label>
                            <input type="text" class="form-control" id="nombres" name="nombres"
                                value="<?php echo $d->a->nombres; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="apellidos">Apellido(s)</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos"
                                value="<?php echo $d->a->apellidos; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo $d->a->email; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                value="<?php echo $d->a->telefono; ?>">
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control form-control-user" name="password" id="password">
                        </div>

                        <div class="form-group">
                            <label for="conf_password">Confirmar contraseña</label>
                            <input type="password" class="form-control form-control-user" name="conf_password" id="conf_password">
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="showPassword">
                            <label class="form-check-label" id="showPasswordLabel" for="showPassword">Mostrar contraseña</label>
                        </div>

                        <hr>

                        <button class="btn btn-success" type="submit">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once INCLUDES.'inc_footer.php'; ?>
