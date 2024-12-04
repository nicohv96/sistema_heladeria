<?php

namespace App\Http\Controllers;


use App\Models\Customer;
use App\Models\Sale;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function storeUser(Request $request)
    {
        // Validar que el nombre de usuario no se repita
        $request->validate([
            'name' => 'required|unique:users,name',
            'password' => 'required|min:6'
        ]);

        // Crear el nuevo usuario si pasa la validación
        $item = new User();
        $item->name = $request->name;
        $item->password = Hash::make($request->password);
        $item->save();

        return redirect()->route('register')->with('success', '¡Se ha creado el usuario con Éxito!');
    }

    public function newLogin(Request $request)
    {
        $credentials = [
            'name' => $request->name,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return to_route('dashboard');
        } else {
            return redirect()->route('login')->with('error', 'Usuario y/o contraseña incorrectos.');
        }
    }

    public function logout()
    {
        Session::flush();
        return to_route('login');
    }

    public function dashboard()
    {
        $customerCount = Customer::count();
        $saleCount = Sale::count();
        $categoryCount = Category::count();
        $productCount = Product::count();

        return view('dashboard.index', compact('customerCount', 'saleCount', 'categoryCount', 'productCount'));
    }
}
