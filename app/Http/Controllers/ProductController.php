<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:50|unique:products,product_name',
            'product_description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ], [
            'product_name.required' => 'El nombre del producto es obligatorio.',
            'product_name.string' => 'El nombre del producto debe ser una cadena de texto.',
            'product_name.max' => 'El nombre del producto no debe exceder los 50 caracteres.',
            'product_name.unique' => 'El nombre del producto ya está en uso.',

            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',

            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',

            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo: jpg, png o jpeg.',
            'image_path.max' => 'La imagen no debe exceder los 2MB.',

            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
        ]);

        // Convertir los campos a mayúsculas
        $product_name = strtoupper($request->product_name);
        $product_description = strtoupper($request->product_description);

        // Crear el producto con los datos modificados
        $product = Product::create([
            'product_name' => $product_name,
            'product_description' => $product_description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $request->image, // si existe
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('image')) {
            // Generar un nombre único para la imagen
            $name = $product->id . '.' . $request->file('image')->getClientOriginalExtension();

            // Guardar la imagen en storage/app/public/img
            $img = $request->file('image')->storeAs('products', $name, 'public');

            // Guardar la ruta relativa en la base de datos
            $product->image = '/products/' . $name;
            $product->save();
        }

        return redirect()->route('product.index')->with('success', 'Producto creado exitosamente.');
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
        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('product.update', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de datos del producto
        $request->validate([
            'product_name' => 'required|string|max:50|unique:products,product_name,' . $id,
            'product_description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ], [
            'product_name.required' => 'El nombre del producto es obligatorio.',
            'product_name.string' => 'El nombre del producto debe ser una cadena de texto.',
            'product_name.max' => 'El nombre del producto no debe exceder los 50 caracteres.',
            'product_name.unique' => 'El nombre del producto ya está en uso.',

            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',

            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',

            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo: jpg, png o jpeg.',
            'image.max' => 'La imagen no debe exceder los 2MB.',

            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
        ]);

        // Obtener el producto existente
        $product = Product::findOrFail($id);

        // Actualizar el producto, convirtiendo nombre y descripción a mayúsculas
        $product->update([
            'product_name' => strtoupper($request->product_name),
            'product_description' => strtoupper($request->product_description),
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('image')) {

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Generar un nombre único para la imagen
            $name = $product->id . '.' . $request->file('image')->getClientOriginalExtension();

            // Guardar la imagen en storage/app/public/img
            $img = $request->file('image')->storeAs('products', $name, 'public');

            // Guardar la ruta relativa en la base de datos
            $product->image = '/products/' . $name;
            $product->save();
        }

        return redirect()->route('product.index')->with('success', 'Producto actualizado exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return redirect()->route('product.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('product.index')->with('error', 'No se puede eliminar el producto porque hay ventas asociados a el.');
        }
    }
}
