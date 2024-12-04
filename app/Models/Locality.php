<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
    use HasFactory;

    protected $fillable = [
        'locality_name',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'locality_id');
    }
}
