@extends('layouts.app')

@section('title')
    Gesti&oacute;n - Actualizar Cliente
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Actualizar Cliente</h1>
</div>

<div class="contentTable p-2 mb-3">
    <div class="m-4">
        <form id="updateClientForm" action="{{ route('customer.update', ['id' => $customer->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Campo: Nombre -->
            <div class="mb-3">
                <label for="customer_name" class="form-label">Nombre y Apellido<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" 
                    value="{{ old('customer_name', $customer->customer_name) }}" maxlength="50">
                @error('customer_name')
                    <div class="text-danger error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo: Tipo de Teléfono -->
            <div class="mb-3">
                <label for="type_phone_id" class="form-label">Tipo de Teléfono<span class="text-danger">*</span></label>
                <select class="form-select" id="type_phone_id" name="type_phone_id" onchange="togglePhoneInput()">
                    <option value="">Seleccione un tipo de teléfono</option>
                    @foreach($type_phones as $type)
                        <option value="{{ $type->id }}" 
                            {{ old('type_phone_id', $customer->type_phone_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->type_phone_name }}
                        </option>
                    @endforeach
                </select>
                @error('type_phone_id')
                    <div class="text-danger error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo: Teléfono -->
            <div class="mb-3">
                <label for="customer_phone" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="customer_phone" name="customer_phone" 
                    value="{{ old('customer_phone', $customer->customer_phone) }}" maxlength="20">
                @error('customer_phone')
                    <div class="text-danger error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo: Dirección -->
            <div class="mb-3">
                <label for="customer_address" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="customer_address" name="customer_address" 
                    value="{{ old('customer_address', $customer->customer_address) }}" maxlength="100">
                @error('customer_address')
                    <div class="text-danger error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo: Localidad -->
            <div class="mb-3">
                <label for="locality_id" class="form-label">Localidad<span class="text-danger">*</span></label>
                <select class="form-select" id="locality_id" name="locality_id">
                    <option value="">Seleccione una localidad</option>
                    @foreach($localities as $locality)
                        <option value="{{ $locality->id }}" 
                            {{ old('locality_id', $customer->locality_id) == $locality->id ? 'selected' : '' }}>
                            {{ $locality->locality_name }}
                        </option>
                    @endforeach
                </select>
                @error('locality_id')
                    <div class="text-danger error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('customer.index') }}" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        togglePhoneInput();
    });

    function togglePhoneInput() {
    const phoneInput = document.getElementById('customer_phone');
    const typePhoneSelect = document.getElementById('type_phone_id');

    const selectedValue = typePhoneSelect.value;

    if (selectedValue === '3') {
        phoneInput.value = '';
        phoneInput.setAttribute('disabled', 'disabled');
    } else {
        phoneInput.removeAttribute('disabled');
    }
}

</script>
@endsection
