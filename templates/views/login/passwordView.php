<?php require_once INCLUDES.'inc_header_minimal.php'; ?>

<div class="container">
  <!-- Outer Row -->
  <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-12 col-md-9">

          <div class="card o-hidden border-0 shadow-lg my-5 bg-light">
              <div class="card-body p-0">
                  <!-- Nested Row within Card Body -->
                  <div class="row">
                      <div class="col-lg-12">
                          <div class="p-5">
                              <div class="text-center">
                                <img src="<?php echo get_logo(); ?>" alt="<?php echo get_sitename(); ?>" class="img fluid mb-3" style="width: 300px;">
                                  <h1 class="h4 text-gray-900 mb-4"><?php echo $d->title; ?></h1>
                              </div>

                              <?php echo Flasher::flash(); ?>

                              <form class="user" action="login/post_password" method="post" onsubmit="return validatePassword()">
                                  <?php echo insert_inputs(); ?>
                                  <input type="hidden" name="id" value="<?php echo $d->id; ?>">
                                  <input type="hidden" name="token" value="<?php echo $d->token; ?>">

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
                                  
                                  <button class="btn btn-primary btn-user btn-block" type="submit">Actualizar contraseña</button>
                              </form>
                              <hr>
                              <div class="text-center">
                                  <a class="small" href="login">¿Ya tienes cuenta?</a>
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