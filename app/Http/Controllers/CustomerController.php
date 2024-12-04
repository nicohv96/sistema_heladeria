<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\TypePhone;
use App\Models\Locality;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->get();
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_phones = TypePhone::all();
        $localities = Locality::all();
        return view('customer.create', compact('type_phones', 'localities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:50|unique:customers,customer_name',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string|max:200',
            'locality_id' => 'required|exists:localities,id',
            'type_phone_id' => 'required|exists:type_phones,id',
        ], [
            'customer_name.required' => 'El nombre del cliente es obligatorio.',
            'customer_name.string' => 'El nombre del cliente debe ser una cadena de texto.',
            'customer_name.max' => 'El nombre del cliente no debe exceder los 50 caracteres.',
            'customer_name.unique' => 'El nombre del cliente ya está en uso.',

            'customer_phone.string' => 'El teléfono debe ser una cadena de texto.',
            'customer_phone.max' => 'El teléfono no debe exceder los 20 caracteres.',

            'customer_address.string' => 'La dirección debe ser una cadena de texto.',
            'customer_address.max' => 'La dirección no debe exceder los 200 caracteres.',

            'locality_id.required' => 'La localidad es obligatoria.',
            'locality_id.exists' => 'La localidad seleccionada no existe.',

            'type_phone_id.required' => 'El tipo de teléfono es obligatorio.',
            'type_phone_id.exists' => 'El tipo de teléfono seleccionado no existe.',
        ]);

        $customer = Customer::create([
            'customer_name' => strtoupper($request->customer_name),
            'customer_phone' => $request->customer_phone,
            'customer_address' => strtoupper($request->customer_address),
            'locality_id' => $request->locality_id,
            'type_phone_id' => $request->type_phone_id,
        ]);

        return redirect()->route('customer.index')->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $type_phones = TypePhone::all();
        $localities = Locality::all();
        $customer = Customer::findOrFail($id);
        return view('customer.update', compact('type_phones', 'localities', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:50|unique:customers,customer_name,' . $id,
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string|max:200',
            'locality_id' => 'required|exists:localities,id',
            'type_phone_id' => 'required|exists:type_phones,id',
        ], [
            'customer_name.required' => 'El nombre del cliente es obligatorio.',
            'customer_name.string' => 'El nombre del cliente debe ser una cadena de texto.',
            'customer_name.max' => 'El nombre del cliente no debe exceder los 50 caracteres.',
            'customer_name.unique' => 'El nombre del cliente ya está en uso.',

            'customer_phone.string' => 'El teléfono debe ser una cadena de texto.',
            'customer_phone.max' => 'El teléfono no debe exceder los 20 caracteres.',

            'customer_address.string' => 'La dirección debe ser una cadena de texto.',
            'customer_address.max' => 'La dirección no debe exceder los 200 caracteres.',

            'locality_id.required' => 'La localidad es obligatoria.',
            'locality_id.exists' => 'La localidad seleccionada no existe.',

            'type_phone_id.required' => 'El tipo de teléfono es obligatorio.',
            'type_phone_id.exists' => 'El tipo de teléfono seleccionado no existe.',
        ]);

        $customer = Customer::findOrFail($id);

        $customer->update([
            'customer_name' => strtoupper($request->customer_name),
            'customer_phone' => $request->customer_phone,
            'customer_address' => strtoupper($request->customer_address),
            'locality_id' => $request->locality_id,
            'type_phone_id' => $request->type_phone_id,
        ]);

        return redirect()->route('customer.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);

            $customer->delete();

            return redirect()->route('customer.index')->with('success', 'Cliente eliminado exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('customer.index')->with('error', 'No se puede eliminar el cliente porque hay ventas asociados a el.');
        }
        
    }
}
