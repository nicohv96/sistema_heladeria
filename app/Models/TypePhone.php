<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePhone extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_phone_name',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'type_phone_id');
    }
}
