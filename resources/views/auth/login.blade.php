<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gesti&oacute;n - Inicio de sesión</title>
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

        .card {
            border: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- loginForm -->
        <div class="row d-flex justify-content-center align-items-center vh-100">
            <div class="col-lg-5 col-md-8 col-sm-10">
                <h1 class="mb-3 text-center">GESTI&Oacute;N HELADERIA</h1>
                <div class="card shadow rounded-3">
                    <div class="card-header p-4 bg-dark text-white">
                        <h3 class="mb-0 text-center">Inicio de sesión</h3>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                        <div id="error-container" data-error='@json(session("error"))'></div>
                        @endif

                        <form id="loginForm" action="{{ route('newLogin') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Usuario:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa tu usuario">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center pt-4">
                        <p>¿No tienes una cuenta?<a style="margin-left: 2px;" href="{{ route('register') }}">Reg&iacute;strate.</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el contenedor de error
            const errorContainer = document.getElementById('error-container');

            // Comprobar si el contenedor existe
            if (errorContainer) {
                // Parsear el mensaje de error desde el atributo data-error
                const errorMessage = JSON.parse(errorContainer.getAttribute('data-error'));

                // Mostrar el mensaje de error usando SweetAlert2
                if (errorMessage) {
                    Swal.fire({
                        toast: true, // Activar el modo toast
                        position: 'top-end', // Posición del toast
                        icon: 'error',
                        title: errorMessage,
                        showConfirmButton: false,
                        timer: 3000, // Duración en milisegundos
                        timerProgressBar: true, // Mostrar barra de progreso
                    });
                }
            }
        });
    </script>

</body>

</html>