<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_address',
        'locality_id',
        'type_phone_id',
    ];

    public function locality()
    {
        return $this->belongsTo(Locality::class);
    }

    public function typePhone()
    {
        return $this->belongsTo(TypePhone::class, 'type_phone_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
