<!-- Bootstrap core JavaScript-->
<script src="<?php echo ASSETS.'vendor/jquery/jquery.min.js'; ?>"></script>
<script src="<?php echo ASSETS.'vendor/bootstrap/js/bootstrap.bundle.min.js'; ?>"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo ASSETS.'vendor/jquery-easing/jquery.easing.min.js'; ?>"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo JS.'sb-admin-2.min.js'; ?>"></script>

<!-- Page level plugins -->
<script src="<?php echo ASSETS.'vendor/chart.js/Chart.min.js'; ?>"></script>
<script src="<?php echo ASSETS.'vendor/datatables/jquery.dataTables.min.js'; ?>"></script>
<script src="<?php echo ASSETS.'vendor/datatables/dataTables.bootstrap4.min.js'; ?>"></script>

<!-- toastr js -->
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- waitme js -->
<script src="<?php echo PLUGINS.'waitme/waitMe.min.js'; ?>"></script>

<!-- Lightbox js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script src="https://kit.fontawesome.com/9d3fd7fa0c.js" crossorigin="anonymous"></script>

<!-- Objeto Bee Javascript registrado -->
<?php echo load_bee_obj(); ?>

<!-- Scripts registrados manualmente -->
<?php echo load_scripts(); ?>

<!-- Scripts personalizados Bee Framework -->
<script src="<?php echo JS.'main.js?v='.get_version(); ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    const passwordField = document.getElementById('password');

    togglePasswordBtn.addEventListener('click', function() {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            togglePasswordBtn.querySelector('i').classList.remove('fa-eye');
            togglePasswordBtn.querySelector('i').classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            togglePasswordBtn.querySelector('i').classList.remove('fa-eye-slash');
            togglePasswordBtn.querySelector('i').classList.add('fa-eye');
        }
    });
});
</script>

<script>
  document.getElementById('showPassword').addEventListener('change', function() {
    var passwordInput = document.getElementById('password');
    var confirmPasswordInput = document.getElementById('conf_password');
    var showPasswordLabel = document.getElementById('showPasswordLabel');

    if (this.checked) {
      passwordInput.type = 'text';
      confirmPasswordInput.type = 'text';
      showPasswordLabel.textContent = 'Ocultar contraseña';
    } else {
      passwordInput.type = 'password';
      confirmPasswordInput.type = 'password';
      showPasswordLabel.textContent = 'Mostrar contraseña';
    }
  });
</script>

<script>
  // Agregar item
  $('#add-item').click(function() {
      $('#items-container').append('<div class="input-group mb-3 item-input"><input type="text" class="form-control item" name="items[]" placeholder="Escribe un item" required><div class="input-group-append"><button class="btn btn-outline-secondary btn-remove-item" type="button">Eliminar</button></div></div>');
  });

  // Eliminar item
  $(document).on('click', '.btn-remove-item', function() {
      $(this).closest('.item-input').remove();
  });
</script>

<script>
    function validatePassword() {
        var password = document.getElementById("password").value;
        var re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.^#])[A-Za-z\d@$!%*?&.^#]{8,}$/;
        if (!re.test(password)) {
            alert("La contraseña debe contener al menos 8 caracteres, una letra minúscula, una letra mayúscula, un número y al menos uno de los siguientes caracteres especiales: @$!%*?&.^#");
            return false;
        }
        return true;
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var checkboxes = document.querySelectorAll('input[name="opcion_seleccionada[]"]');
        var submitButton = document.querySelector('button[type="submit"]');
        var progressBar = document.querySelector('.progress-bar');

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                var checkedCount = document.querySelectorAll('input[name="opcion_seleccionada[]"]:checked').length;
                var totalCount = checkboxes.length;

                // Calcular el progreso
                var progress = (checkedCount / totalCount) * 100;
                progressBar.style.width = progress + '%';

                // Habilitar/deshabilitar el botón según si todos los checkboxes están seleccionados
                if (checkedCount === totalCount) {
                    submitButton.removeAttribute('disabled');
                } else {
                    submitButton.setAttribute('disabled', 'disabled');
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var checkboxes = document.querySelectorAll('input[name="producto_seleccionado[]"]');
        var submitButton = document.querySelector('button[type="submit"]');

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                var checkedCount = document.querySelectorAll('input[name="producto_seleccionado[]"]:checked').length;

                // Habilitar/deshabilitar el botón según si al menos un checkbox está seleccionado
                if (checkedCount > 0) {
                    submitButton.removeAttribute('disabled');
                } else {
                    submitButton.setAttribute('disabled', 'disabled');
                }
            });
        });
    });
</script>

<script>
    // Obtener referencia al formulario y al botón de agregar compra
    const compraForm = document.getElementById('compraForm');
    const agregarCompraBtn = document.getElementById('agregarCompraBtn');

    // Agregar un event listener para el cambio en los checkboxes
    compraForm.addEventListener('change', function() {
        // Obtener todos los checkboxes seleccionados
        const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');

        // Habilitar el botón de agregar compra si hay al menos un checkbox seleccionado, de lo contrario, deshabilitarlo
        if (checkboxes.length > 0) {
            agregarCompraBtn.disabled = false;
        } else {
            agregarCompraBtn.disabled = true;
        }
    });
</script>