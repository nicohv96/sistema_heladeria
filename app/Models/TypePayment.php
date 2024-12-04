<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_payment_name',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class, 'type_payment_id');
    }
}
