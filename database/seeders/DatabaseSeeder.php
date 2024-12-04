<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TypePhone;
use App\Models\Locality;
use App\Models\Category;
use App\Models\TypePayment;
use App\Models\Customer;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear registro en la tabla users
        $user = new User;

        $user->name = 'admin';
        $user->password = bcrypt('administrador');

        $user->save();

        // Crear registros en la tabla type_phones
        $typePhone1 = new TypePhone;
        $typePhone1->type_phone_name = 'FIJO';
        $typePhone1->save();

        $typePhone2 = new TypePhone;
        $typePhone2->type_phone_name = 'CELULAR';
        $typePhone2->save();

        $typePhone3 = new TypePhone;
        $typePhone3->type_phone_name = 'SIN TELEFONO';
        $typePhone3->save();

        // Crear registros en la tabla type_payments
        $typePayment1 = new TypePayment();
        $typePayment1->type_phone_name = 'EFECTIVO';
        $typePayment1->save();

        $typePayment2 = new TypePayment();
        $typePayment2->type_phone_name = 'CREDITO';
        $typePayment2->save();

        $typePayment3 = new TypePayment();
        $typePayment3->type_phone_name = 'DEBITO';
        $typePayment3->save();

        $typePayment4 = new TypePayment();
        $typePayment4->type_phone_name = 'TRANSFERENCIA';
        $typePayment4->save();

        // Crear registros en la tabla localities
        $locality1 = new Locality;
        $locality1->locality_name = 'NO ESPECIFICA';
        $locality1->save();

        $locality2 = new Locality;
        $locality2->locality_name = 'FORMOSA';
        $locality2->save();

        $locality3 = new Locality;
        $locality3->locality_name = 'CLORINDA';
        $locality3->save();

        // Crear registros en la tabla categories
        $category1 = new Category;
        $category1->category_name = 'CUCURUCHO';
        $category1->save();
        
        $category2 = new Category;
        $category2->category_name = 'PALITO';
        $category2->save();
        
        $category3 = new Category;
        $category3->category_name = 'POTE';
        $category3->save();

        $category4 = new Category;
        $category4->category_name = 'VASITO';
        $category4->save();

        // Crear registros en la tabla customer
        $customer = new Customer;
        $customer->customer_name = 'CLIENTE OCASIONAL';
        $customer->customer_phone = '';
        $customer->customer_address = '';
        $customer->locality_id = 1;
        $customer->type_phone_id = 3;
        $customer->save();
    }
}
