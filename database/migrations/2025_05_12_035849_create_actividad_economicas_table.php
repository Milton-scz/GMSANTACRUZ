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
        Schema::create('actividad_economicas', function (Blueprint $table) {
            $table->id();
            $table->string('rubro');
            $table->string('actividad_economica');
            $table->string('ubicacion');
            $table->string('nit');
            $table->string('distrito');
            $table->string('unidad_vecinal');
            $table->string('manzano');
            $table->string('lote');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
           // $table->string('urlnit')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividad_economicas');
    }
};
