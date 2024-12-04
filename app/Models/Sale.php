<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'type_payment_id', 'sale_date', 'total'];

    // Evento "deleting" para eliminar detalles y recuperar stock
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($sale) {
            foreach ($sale->saleDetails as $detail) {
                // Recuperar el stock del producto
                $detail->product->increment('stock', $detail->quantity);

                // Eliminar el detalle
                $detail->delete();
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function typePayment()
    {
        return $this->belongsTo(TypePayment::class, 'type_payment_id');
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
