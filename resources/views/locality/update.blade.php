@extends('layouts.app')

@section('title')
    Gesti&oacute;n - Actualizar Localidad
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        Actualizar localidad
    </h1>
</div>

<!-- Contenido de la tabla -->
<div class="contentTable p-2 mb-3">
    <div class="m-4">
        <form id="createLocalityForm" action="{{ route('locality.update', ['id' => $locality->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="update_locality_name" class="form-label">Nombre de la Localidad<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="update_locality_name" name="update_locality_name" value="{{ $locality->locality_name }}">
                @error('update_locality_name')
                    <div class="text-danger error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('locality.index') }}" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>

@endsection
