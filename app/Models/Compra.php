<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;
class Compra extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['cantidad', 'soportedecompra', 'preciocompra', 'valorunidad', 'id_producto', 'id_proveedor'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function proveedor() 
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    protected static function booted()
    {
        static::created(function ($compra) {
            Log::info('Compra creada', ['compra' => $compra]);
        
            // Encuentra el producto y actualiza el stock
            $producto = Producto::find($compra->id_producto);
            if ($producto) {
                Log::info('Producto encontrado', ['producto' => $producto]);
        
                // Sumar la cantidad comprada al stock
                $producto->stock += $compra->cantidad; // Sumar la cantidad comprada al stock
                $producto->save();
                Log::info('Stock actualizado', ['producto' => $producto]);
            } else {
                Log::warning('Producto no encontrado', ['id_producto' => $compra->id_producto]);
            }
        });
    }
}
