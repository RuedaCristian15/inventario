<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'nit', 'correo', 'telefono'];

    //un proveedor tiene muchos productos
   public function productos()
    {
        return $this->belongsToMany(related: Producto::class, table: 'compras');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}

