<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActividadEconomica extends Model
{
     protected $fillable = [
        'rubro',
        'actividad_economica',
        'ubicacion',
        'nit',
       // 'urlnit'

    ];
    public function formulario()
    {
        return $this->hasMany(Formulario::class);
    }

}
