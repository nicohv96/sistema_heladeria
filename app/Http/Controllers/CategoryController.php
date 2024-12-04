<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:30|unique:categories,category_name',
        ], [
            'category_name.required' => 'El nombre de la categoría es obligatorio.',
            'category_name.unique' => 'El nombre de la categoría ya está en uso.',
            'category_name.string' => 'El nombre de la categoría debe ser un texto.',
            'category_name.max' => 'El nombre de la categoría no debe exceder los 30 caracteres.',
        ]);

        // Convertir category_name a mayúsculas
        $categoryName = strtoupper($request->category_name);

        // Crear la categoría con el nombre en mayúsculas
        Category::create([
            'category_name' => $categoryName,
        ]);

        return redirect()->route('category.index')->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('category.index', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.update', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'update_category_name' => 'required|string|max:30|unique:categories,category_name,' . $id,
        ], [
            'update_category_name.required' => 'El nombre de la categoría es obligatorio.',
            'update_category_name.unique' => 'El nombre de la categoría ya está en uso.',
            'update_category_name.string' => 'El nombre de la categoría debe ser un texto.',
            'update_category_name.max' => 'El nombre de la categoría no debe exceder los 30 caracteres.',
        ]);

        // Convertir category_name a mayúsculas
        $categoryName = strtoupper($request->update_category_name);

        $category = Category::findOrFail($id);
        $category->update([
            'category_name' => $categoryName,
        ]);

        return redirect()->route('category.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return redirect()->route('category.index')->with('success', 'Categoría eliminada exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('category.index')->with('error', 'No se puede eliminar la categoría porque hay productos asociados a ella.');
        }
    }
}
