@extends('layouts.app')

@section('title')
    Gesti&oacute;n - Detalle de Venta
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detalle de Venta</h1>
</div>

<!-- Contenido del detalle -->
<div class="contentTable p-2 mb-3">
    <div class="m-4">
        <!-- Información de la venta -->
        <h5 class="mb-4 pb-2 border-bottom">Información de la venta:</h5>
        <ul>
            <li>
                <p><strong>Cliente:</strong> {{ $sale->customer->customer_name }}</p>
            </li>
            <li>
                <p><strong>Fecha de la venta:</strong> {{ $sale->created_at }}</p>
            </li>
            <li>
                <p><strong>Total:</strong> ${{ number_format($sale->total, 2) }}</p>
            </li>
        </ul>

        <!-- Tabla de productos -->
        <h5 class="mt-4 mb-3 text-center">Listado de productos</h5>
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="text-center">
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->saleDetails as $index => $detail)
                    <tr class="text-center">
                        <td>{{ $detail->product->product_name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>${{ number_format($detail->price, 2) }}</td>
                        <td>${{ number_format($detail->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div id="container-buttons" class="d-flex justify-content-end mt-3 gap-2">
            <a href="{{ route('sale.index') }}" class="btn btn-secondary">Volver</a>
            <button onclick="window.print()" class="btn btn-primary">Imprimir Detalle</button>
        </div>
    </div>
</div>

<style>
    @media print {
        /* Eliminar márgenes y padding predeterminados */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        /* Asegurarse de que todo el contenido está visible */
        body * {
            visibility: hidden;
        }

        /* Mostrar solo la tabla y el contenido relevante */
        .contentTable, .contentTable * {
            visibility: visible;
        }

        /* Ocultar el encabezado de la página (como título y fecha/hora) */
        .d-flex.justify-content-between {
            display: none !important;
        }

        /* Ocultar los botones de la página */
        #container-buttons {
            display: none !important;
        }

        /* Ajustar el contenido para que ocupe toda la página */
        .contentTable {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        /* Configurar la página para que solo se imprima una hoja */
        @page {
            size: A4; /* Asegúrate de que el tamaño de página sea A4 */
            margin: 0; /* Márgenes en blanco */
        }
    }
</style>

@endsection