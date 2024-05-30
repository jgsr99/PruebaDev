<?php require_once INCLUDES.'inc_header_minimal.php'; ?>

<div class="container">
  <!-- Outer Row -->
  <div class="row justify-content-center transparent-card">
      <div class="col-xl-6 col-lg-12 col-md-9">
          <div class="card o-hidden border-0 shadow-lg my-5 bg-light">
              <div class="card-body p-0">
                  <!-- Nested Row within Card Body -->
                  <div class="row">
                      <!--<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>-->
                      <div class="col-lg-12">
                          <div class="p-5">
                              <div class="text-center">
                                <img src="<?php echo get_logo(); ?>" alt="<?php echo get_sitename(); ?>" class="img fluid mb-3">
                                  <h1 class="h4 text-gray-900 mb-4"><?php echo sprintf('¡Bienvenido a %s!', get_sitename()); ?></h1>
                              </div>
                              <?php echo Flasher::flash(); ?>
                              <form class="user" action="login/post_agregar" method="post" onsubmit="return validatePassword()">
                                    <?php echo insert_inputs(); ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user"
                                        name="nombres"
                                        id="nombres" aria-describedby="emailHelp"
                                        placeholder="Ingresa tu nombre(s)..." required>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user"
                                        name="apellidos"
                                        id="apellidos" 
                                        placeholder="Ingresa tu apellido(s)..." required>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user"
                                        name="telefono"
                                        id="telefono" 
                                        placeholder="Ingresa tu número de telefono..." required>
                                    </div>

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user"
                                        name="email"
                                        id="email" aria-describedby="emailHelp"
                                        placeholder="Ingresa tu correo electrónico..." required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="Ingresa tu contraseña..." required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="conf_password" id="conf_password" placeholder="Confirma tu contraseña..." required>
                                    </div>

                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="showPassword">
                                        <label class="form-check-label" id="showPasswordLabel" for="showPassword">Mostrar contraseña</label>
                                    </div>

                                    <div class="form-group">
                                        <label for="sede">Selecciona tu ciudad</label>
                                        <select name="sede" id="sede" class="form-control">
                                            <?php foreach (get_estado_sucursal() as $e): ?>
                                                <?php echo sprintf('<option value="%s">%s</option>', $e[0], $e[1]); ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <button class="btn btn-primary btn-user btn-block" type="submit">Registrar</button>
                                </form>

                              <hr>
                              <div class="text-center">
                                  <a class="small" href="login/index">¿Ya tienes cuenta?</a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

      </div>

  </div>

</div>

<?php require_once INCLUDES.'inc_footer_minimal.php'; ?>
