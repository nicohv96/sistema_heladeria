<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gesti&oacute;n - Registro de usuarios</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: #eeeeee !important;
        }

        .btn {
            border-radius: 0 !important;
        }

        .btn-primary {
            background-color: #212529 !important;
            border-color: #212529 !important;
        }

        .btn-primary:hover {
            background-color: #33363a !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- registerForm -->
        <div class="row d-flex justify-content-center align-items-center vh-100">
            <div class="col-lg-5 col-md-8 col-sm-10">
                <h1 class="mb-3 text-center">GESTI&Oacute;N HELADERIA</h1>
                <div class="card shadow rounded-3">
                    <div class="card-header p-4 bg-dark text-white">
                        <h3 class="mb-0 text-center">Registro de usuarios</h3>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar errores aquí con SweetAlert2 -->
                        @if ($errors->any())
                        <div id="error-container" data-errors='@json($errors->all())'></div>
                        @endif

                        @if (session('success'))
                        <div id="success-container" data-success='@json(session("success"))'></div>
                        @endif

                        <form id="registerForm" action="{{ route('storeUser') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Usuario:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nuevo usuario">
                                <div class="error-message text-danger" id="error-name"></div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese la nueva contraseña">
                                <div class="error-message text-danger" id="error-password"></div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Crear usuario</button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer text-center pt-4">
                        <p>¿Ya tienes una cuenta?<a style="margin-left: 2px;" href="{{ route('login') }}">Ingresar.</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el contenedor de éxito
            const successContainer = document.getElementById('success-container');

            // Comprobar si el contenedor existe
            if (successContainer) {
                // Parsear el mensaje de éxito desde el atributo data-success
                const successMessage = JSON.parse(successContainer.getAttribute('data-success'));

                // Mostrar el mensaje de éxito usando SweetAlert2
                if (successMessage) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: successMessage,
                        text: 'Se lo redirigirá al inicio de sesión',
                        showConfirmButton: false,
                        timerProgressBar: true,
                        timer: 3000
                    }).then(() => {
                        window.location.href = "{{ route('login') }}"; // Redirecciona al login
                    });
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el elemento que contiene los errores
            const errorContainer = document.getElementById('error-container');
            if (errorContainer) {
                const errores = JSON.parse(errorContainer.getAttribute('data-errors') || '[]');

                function mostrarErroresEnInputs(errores) {
                    // Limpiar mensajes de error previos
                    document.getElementById('error-name').innerHTML = '';
                    document.getElementById('error-password').innerHTML = '';

                    errores.forEach(error => {
                        let mensajePersonalizado = '';

                        if (error.includes('unique')) {
                            mensajePersonalizado = 'El nombre de usuario ya está en uso.';
                            document.getElementById('error-name').innerHTML = mensajePersonalizado;
                        } else if (error.includes('required')) {
                            const nameInput = document.getElementById('name').value;
                            const passwordInput = document.getElementById('password').value;

                            if (nameInput.trim() === '') {
                                mensajePersonalizado = 'El campo usuario es obligatorio.';
                                document.getElementById('error-name').innerHTML = mensajePersonalizado;
                            }
                            if (passwordInput.trim() === '') {
                                mensajePersonalizado = 'El campo contraseña es obligatorio.';
                                document.getElementById('error-password').innerHTML = mensajePersonalizado;
                            }
                        } else if (error.includes('min')) {
                            mensajePersonalizado = 'La contraseña debe tener un mínimo de 6 caracteres.';
                            document.getElementById('error-password').innerHTML = mensajePersonalizado;
                        } else {
                            mensajePersonalizado = error; // Mensaje de error por defecto
                            document.getElementById('error-password').innerHTML = mensajePersonalizado; // Asigna a un contenedor específico
                        }
                    });
                }

                if (errores && errores.length > 0) {
                    mostrarErroresEnInputs(errores);
                }
            }
        });
    </script>

</body>

</html>