<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Customer;
use App\Models\TypePayment;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::all();
        return view('sale.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $customers = Customer::all();
        $typePayments = TypePayment::all();
        return view('sale.create', compact('products', 'customers', 'typePayments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ], [
            // Mensajes para customer_id
            'customer_id.required' => 'Debe seleccionar un cliente.',
            'customer_id.exists' => 'El cliente seleccionado no existe en nuestros registros.',

            // Mensajes para products
            'products.required' => 'Debe agregar al menos un producto.',
            'products.array' => 'Los productos deben estar en un formato válido.',

            // Mensajes para cada producto
            'products.*.product_id.required' => 'Debe seleccionar un producto.',
            'products.*.product_id.exists' => 'El producto seleccionado no existe en nuestros registros.',
            'products.*.quantity.required' => 'Debe ingresar la cantidad para el producto seleccionado.',
            'products.*.quantity.integer' => 'La cantidad debe ser un número entero.',
            'products.*.quantity.min' => 'La cantidad debe ser al menos 1.',
        ]);

        $total = 0;

        // Validar stock para todos los productos antes de crear la venta
        foreach ($validated['products'] as $productData) {
            $product = Product::find($productData['product_id']);
            $quantity = $productData['quantity'];

            if ($product->stock < $quantity) {
                return redirect()->route('sale.create')
                    ->withErrors(["Stock insuficiente para {$product->product_name}"])
                    ->withInput();
            }

            // Calcular el total de la venta (se usa después para actualizar)
            $total += $product->price * $quantity;
        }

        // Crear la venta después de validar el stock
        $sale = Sale::create([
            'customer_id' => $validated['customer_id'],
            'total' => 0, // Temporal, se actualizará luego
        ]);

        // Crear los detalles de la venta y descontar stock
        foreach ($validated['products'] as $productData) {
            $product = Product::find($productData['product_id']);
            $quantity = $productData['quantity'];
            $subtotal = $product->price * $quantity;

            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'subtotal' => $subtotal,
            ]);

            // Descontar el stock del producto
            $product->decrement('stock', $quantity);
        }

        // Actualizar el total de la venta
        $sale->update(['total' => $total]);

        return redirect()->route('sale.index')
            ->with('success', "Venta realizada exitosamente. Total: $" . number_format($total, 2));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = Sale::with(['customer', 'saleDetails.product'])->findOrFail($id);

        return view('sale.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        $sale->delete();

        return redirect()->route('sale.index')->with('success', 'Venta eliminada correctamente y stock recuperado.');
    }
}
