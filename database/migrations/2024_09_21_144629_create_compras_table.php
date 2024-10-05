<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('cantidad');
            $table->string('soportedecompra');
            $table->integer('preciocompra');
            $table->integer('valorunidad');
            $table->foreignId('id_producto')->constrained('productos')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_proveedor')->constrained('proveedors')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
