<?php

namespace App\Http\Controllers;

use App\Models\Locality;
use Illuminate\Http\Request;

class LocalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $localities = Locality::all();
        return view('locality.index', compact('localities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('locality.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'locality_name' => 'required|string|max:30|unique:localities,locality_name',
        ], [
            'locality_name.required' => 'El nombre de la categoría es obligatorio.',
            'locality_name.unique' => 'El nombre de la categoría ya está en uso.',
            'locality_name.string' => 'El nombre de la categoría debe ser un texto.',
            'locality_name.max' => 'El nombre de la categoría no debe exceder los 30 caracteres.',
        ]);

        // Convertir locality_name a mayúsculas
        $localityName = strtoupper($request->locality_name);

        // Crear la categoría con el nombre en mayúsculas
        Locality::create([
            'locality_name' => $localityName,
        ]);

        return redirect()->route('locality.index')->with('success', 'Localidad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $locality = Locality::findOrFail($id);
        return view('locality.index', compact('locality'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $locality = Locality::findOrFail($id);
        return view('locality.update', compact('locality'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'update_locality_name' => 'required|string|max:30|unique:localities,locality_name,' . $id,
        ], [
            'update_locality_name.required' => 'El nombre de la categoría es obligatorio.',
            'update_locality_name.unique' => 'El nombre de la categoría ya está en uso.',
            'update_locality_name.string' => 'El nombre de la categoría debe ser un texto.',
            'update_locality_name.max' => 'El nombre de la categoría no debe exceder los 30 caracteres.',
        ]);

        // Convertir locality_name a mayúsculas
        $localityName = strtoupper($request->update_locality_name);

        $locality = Locality::findOrFail($id);
        $locality->update([
            'locality_name' => $localityName,
        ]);

        return redirect()->route('locality.index')->with('success', 'Localidad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $locality = Locality::findOrFail($id);
            $locality->delete();

            return redirect()->route('locality.index')->with('success', 'Localidad eliminada exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('locality.index')->with('error', 'No se puede eliminar la localidad porque hay clientes asociados a ella.');
        }
    }
}
