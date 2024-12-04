@extends('layouts.app')

@section('title')
    Gesti&oacute;n - Actualizar Producto
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Actualizar producto</h1>
</div>

<!-- Contenido de la tabla -->
<div class="contentTable p-2 mb-3">
    <div class="m-4">
        <form id="updateProductForm" action="{{ route('product.update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Campo: Nombre del Producto -->
            <div class="mb-3">
                <label for="product_name" class="form-label">Nombre del Producto<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" maxlength="50">
                @error('product_name')
                    <div class="text-danger error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo: Descripción del Producto -->
            <div class="mb-3">
                <label for="product_description" class="form-label">Descripción del Producto</label>
                <textarea class="form-control" id="product_description" name="product_description">{{ $product->product_description }}</textarea>
                @error('product_description')
                    <div class="text-danger error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo: Precio -->
            <div class="mb-3">
                <label for="price" class="form-label">Precio<span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" step="0.01">
                @error('price')
                    <div class="text-danger error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo: Stock -->
            <div class="mb-3">
                <label for="stock" class="form-label">Stock<span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" min="0">
                @error('stock')
                    <div class="text-danger error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo: Categoría -->
            <div class="mb-3">
                <label for="category_id" class="form-label">Categoría<span class="text-danger">*</span></label>
                <select class="form-control" id="category_id" name="category_id">
                    <option value="">Seleccione una categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo: Imagen -->
            <div class="mb-3">
                <label for="image" class="form-label">Imagen del Producto</label>
                <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png">
                @error('image')
                    <div class="text-danger error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 d-flex justify-content-center gap-4">

                <div class="d-flex flex-column align-items-center gap-2">
                    <label for="">Imagen original</label>
                    @if ($product->image)
                        <img src="{{ asset('storage' . $product->image) }}" alt="" style="width: 100px; height: auto;">
                    @else
                        <img src="{{ asset('storage/products/no-image.jpg') }}" alt="" style="width: 100px; height: auto;">
                    @endif
                </div>

                <div class="d-flex flex-column align-items-center gap-2">
                    <label for="">Vista previa</label>
                    <div id="imagePreview"></div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('product.index') }}" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<script type="module">

    document.getElementById('image').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var reader = new FileReader();

    if (file) {
        reader.onload = function(e) {
            // Crear una imagen para la vista previa
            var imgElement = document.createElement('img');
            imgElement.src = e.target.result;
            imgElement.style.width = '100px';
            imgElement.style.height = 'auto';

            // Limpiar el contenedor de la vista previa y agregar la nueva imagen
            var previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = '';  // Limpiar el contenedor
            previewContainer.appendChild(imgElement); // Agregar la imagen
        };

        // Leer la imagen como una URL de datos (base64)
        reader.readAsDataURL(file);
    } else {
        // Limpiar la vista previa si no se seleccionó una imagen
        document.getElementById('imagePreview').innerHTML = '';
    }
});

</script>

@endsection
