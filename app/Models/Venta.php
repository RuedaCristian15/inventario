<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
class Venta extends Model
{
    use HasFactory;
    
    protected $fillable = ['stock', 'id_producto', 'id_cliente'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function Cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    protected static function booted()
    {
        static::created(function ($venta) { 
            Log::info('Venta creada', ['venta' => $venta]);
    
            // Encuentra el producto y actualiza el stock
            $producto = Producto::find($venta->id_producto);
            if ($producto) {
                Log::info('Producto encontrado', ['producto' => $producto]);
    
                // Verifica si hay suficiente stock para la venta
                if ($producto->stock >= $venta->stock) {
                    $producto->stock -= $venta->stock; 
                    $producto->save();
                    Log::info('Stock actualizado tras la venta', ['producto' => $producto]);
                } else {
                    Log::warning('Stock insuficiente para el producto', ['producto' => $producto]);
                }
            } else {
                Log::warning('Producto no encontrado', ['id_producto' => $venta->id_producto]);
            }
        });
    }
}

