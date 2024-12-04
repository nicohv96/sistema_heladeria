@extends('layouts.app')

@section('title')
    Gesti&oacute;n - Crear Venta
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Nueva Venta</h1>
</div>

@if ($errors->any())
    <div id="error-container" data-errors='@json($errors->all())'></div>
@endif

<!-- Contenido del formulario -->
<div class="contentTable p-2 mb-3">
    <div class="m-4">
        <form id="createSaleForm" action="{{ route('sale.store') }}" method="POST">
            @csrf
            @method('POST')

            <!-- Campo: Cliente -->
            <div class="mb-3">
                <label for="customer_id" class="form-label">Cliente<span class="text-danger">*</span></label>
                <select class="form-select" name="customer_id" id="customer_id">
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                    @endforeach
                </select>
                @error('customer_id')
                    <div class="text-danger error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Productos -->
            <div id="products">
                <label for="products[0][product_id]" class="form-label">Producto/s</label>
                <div class="product-row mb-3">
                    <div class="d-flex">
                        <select name="products[${index}][product_id]" class="form-select product-select">
                            <option value="">Seleccione un producto</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">{{ $product->product_name }} - Stock: {{ $product->stock }} - P/U: $ {{ $product->price }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="products[${index}][quantity]" min="1" class="form-control product-quantity" placeholder="Cantidad">
                        <button type="button" class="btn btn-danger remove-product" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Botón para agregar productos -->
            <div class="d-flex justify-content-center mt-4">
                <button type="button" id="add-product" class="btn btn-primary">
                    <span class="d-flex justify-content-center align-items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                        </svg>
                        Agregar otro
                    </span>
                </button>
            </div>

            <!-- Campo: Total -->
            <div class="mb-3">
                <label for="total" class="form-label">Total</label>
                <input type="text" id="total" class="form-control fs-4" value="$0" readonly>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('sale.index') }}" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script type="module">
    // Funcionalidad para agregar un nuevo producto
    document.getElementById('add-product').addEventListener('click', function() {
        // Crear un índice único para los productos nuevos
        const index = Date.now();

        // Crear una nueva fila para agregar otro producto
        const productRow = document.createElement('div');
        productRow.classList.add('product-row', 'mb-3');
        
        // Contenido de la fila (select de productos y campo de cantidad)
        productRow.innerHTML = `
        <div class="d-flex">
            <select name="products[${index}][product_id]" class="form-select product-select">
                <option value="">Seleccione un producto</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">{{ $product->product_name }} - Stock: {{ $product->stock }} - P/U: $ {{ $product->price }}</option>
                @endforeach
            </select>
            <input type="number" name="products[${index}][quantity]" min="1" class="form-control product-quantity" placeholder="Cantidad">
            <button type="button" class="btn btn-danger remove-product">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                </svg>
            </button>
        </div>
        `;
        
        // Agregar la nueva fila al contenedor de productos
        document.getElementById('products').appendChild(productRow);
    });

    // Delegar eventos para eliminar productos
    document.getElementById('products').addEventListener('click', function(event) {
        if (event.target.closest('.remove-product')) {
            const productRow = event.target.closest('.product-row');
            // Eliminar la fila solo si no es la primera
            if (document.querySelectorAll('.product-row').length > 1) {
                productRow.remove();
                updateTotal();
            }
        }
    });

    // Función para actualizar el total
    function updateTotal() {
    let total = 0;

    // Iterar sobre todas las filas de productos
        document.querySelectorAll('.product-row').forEach(function(row) {
            const productSelect = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.product-quantity');

            // Verificar que el select y el campo de cantidad existan y estén válidos
            if (productSelect && quantityInput) {
                const selectedOption = productSelect.selectedOptions[0];
                if (selectedOption) {
                    const price = parseFloat(selectedOption.dataset.price) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;

                    // Sumar al total
                    total += price * quantity;
                }
            }
        });

        // Mostrar el total actualizado
        document.getElementById('total').value = `$${total.toFixed(2)}`;
    }

    // Delegar evento para actualizar el total cuando cambie la cantidad
    document.getElementById('products').addEventListener('input', function(event) {
        if (event.target.classList.contains('product-quantity')) {
            updateTotal();
        }
        if (event.target.classList.contains('product-select')) {
            updateTotal();
        }
    });

    // Mostrar errores con SweetAlert2
    const errorContainer = document.getElementById('error-container');
    if (errorContainer) {
        const errorMessages = JSON.parse(errorContainer.getAttribute('data-errors'));
        if (errorMessages.length) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Error',
                html: `${errorMessages.map(msg => `<p>${msg}</p>`).join('')}`,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        }
    }
</script>



@endsection
