<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Producto extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['nombre', 'descripcion', 'stock', 'preciocompra', 'precioventa', 'id_proveedor'];

    public function Proveedores(){
        return $this->belongsTo(Proveedor::class,'id_proveedor');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}

