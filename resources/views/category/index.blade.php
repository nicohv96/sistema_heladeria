@extends('layouts.app')

@section('title')
    Gesti&oacute;n - Categorias
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            Categorias
        </h1>
        <!-- Botón para abrir el modal de creación -->
        <a href="{{ route('category.create') }}"
            class="btn btn-success d-flex justify-content-center align-items-center gap-1">
            <span class="d-flex justify-content-center align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                </svg>
            </span>
            Agregar registro
        </a>
    </div>

    @include('category.delete')

    @if (session('success'))
        <div id="success-container" data-success='@json(session('success'))'></div>
    @elseif (session('error'))
        <div id="error-container" data-error='@json(session('error'))'></div>
    @endif

    <!-- Contenido de la tabla -->
    <div class="contentTable p-2 mb-3">
        <div class="m-4">
            <table class="table table-striped table-bordered" id="tableCategory">
                <thead>
                    <tr>
                        <th style="display:none;">ID</th>
                        <th>Nombres</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td style="display:none;">{{ $category->id }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td class="lastCol">
                                <!-- Modal de eliminar -->
                                <a href="{{ route('category.edit', ['id' => $category->id]) }}" title="Editar"
                                    class="btn btn-warning">
                                    <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                    </i>
                                </a>
                                <!-- Modal de eliminar -->
                                <a href="#" title="Eliminar" class="btn btn-danger deleteCategoryButton"
                                    data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                    data-id="{{ $category->id }}">
                                    <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                        </svg>
                                    </i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar mensaje de éxito con SweetAlert2
            const successContainer = document.getElementById('success-container');
            if (successContainer) {
                const successMessage = JSON.parse(successContainer.getAttribute('data-success'));
                if (successMessage) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: successMessage,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            }
            const errorContainer = document.getElementById('error-container');
            if (errorContainer) {
                const errorMessage = JSON.parse(errorContainer.getAttribute('data-error'));
                if (errorMessage) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: errorMessage,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            }
        });

        // Lógica para abrir el modal de confirmación de eliminación
        document.querySelectorAll('.deleteCategoryButton').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Eliminar cualquier fondo modal anterior
                const existingBackdrop = document.querySelector('.modal-backdrop');
                if (existingBackdrop) {
                    existingBackdrop.remove();
                }

                // Obtener el ID de la categoría
                let categoryId = this.getAttribute('data-id');
                let formAction = '{{ url('category') }}/' + categoryId; // Generar la URL de eliminación

                // Establecer la acción del formulario de eliminación
                document.getElementById('delete-form').action = formAction;

                // Crear y mostrar el modal de confirmación de eliminación
                let deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                deleteModal.show();
            });
        });

        $(document).ready(function() {
            $('#tableCategory').DataTable({
                // Opciones adicionales de configuración
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "order": [
                    [0, 'desc']
                ],
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "columnDefs": [{
                        "targets": -1,
                        "orderable": false,
                        "width": "1%",
                        "className": "text-center text-nowrap"
                    } // Última columna
                ],
                "language": {
                    "url": "/js/datatables-es.json"
                }
            });
        });
    </script>
@endsection
