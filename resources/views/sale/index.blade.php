@extends('layouts.app')

@section('title')
    Gesti&oacute;n - Ventas
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        Ventas
    </h1>
    <!-- Botón para abrir el modal de creación -->
    <a href="{{ route('sale.create') }}" class="btn btn-success d-flex justify-content-center align-items-center gap-1">
        <span class="d-flex justify-content-center align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
            </svg>
        </span>
        Agregar registro
    </a>
</div>

@include('sale.delete')

@if (session('success'))
    <div id="success-container" data-success='@json(session("success"))'></div>
@elseif (session('error'))
    <div id="error-container" data-error='@json(session("error"))'></div>
@endif

<!-- Contenido de la tabla -->
<div class="contentTable p-2 mb-3 overflow-auto">
    <div class="m-4">
        <table class="table table-striped table-bordered" id="tableSales">
            <thead>
                <tr>
                    <th style="display:none;">ID</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Fecha de Venta</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td style="display:none;">{{ $sale->id }}</td>
                        <td class="text-center">{{ $sale->customer->customer_name }}</td>
                        <td class="text-center">{{ $sale->created_at }}</td>
                        <td class="text-center">${{ number_format($sale->total, 2) }}</td>
                        <td class="lastCol text-center">
                            <a href="{{ route('sale.show', ['id' => $sale->id]) }}" title="Ver mas" class="btn btn-info text-white">
                                <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                      </svg>
                                </i>
                            </a>
                            <a href="#" title="Eliminar" class="btn btn-danger deleteSaleButton" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="{{ $sale->id }}">
                                <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
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
document.addEventListener('DOMContentLoaded', function () {
    // Mostrar mensaje de éxito con SweetAlert2
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

    // Lógica para abrir el modal de confirmación de eliminación
    document.querySelectorAll('.deleteSaleButton').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            // Eliminar cualquier fondo modal anterior
            const existingBackdrop = document.querySelector('.modal-backdrop');
            if (existingBackdrop) {
                existingBackdrop.remove();
            }

            // Obtener el ID de la categoría
            let saleId = this.getAttribute('data-id'); 
            let formAction = '{{ url('sale') }}/' + saleId; // Generar la URL de eliminación
            
            // Establecer la acción del formulario de eliminación
            document.getElementById('delete-form').action = formAction;

            // Crear y mostrar el modal de confirmación de eliminación
            let deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            deleteModal.show();
        });
    });

    $('#tableSales').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "order": [[0, 'desc']],
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "columnDefs": [
            { "targets": 0, "visible": false },
            { "targets": -1, "orderable": false, "width": "1%", "className": "text-center text-nowrap" },
        ],
        "language": {
            "url": "/js/datatables-es.json"
        },
        "createdRow": function(row, data, dataIndex) {
            $('td', row).each(function(index) {
                var cell = $(this);
                if (index !== $('td', row).length - 1 && cell.text().trim() === '') {
                    cell.text('-');
                }
            });
        }
    });
});
</script>

@endsection
