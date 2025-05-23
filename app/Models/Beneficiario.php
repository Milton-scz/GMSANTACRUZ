<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
     protected $fillable = [

       'nombre',
        'cedula',
        'celular',
        'direccion',
        'tipo_persona',
        'email'
    ];
   public function solicitudes()
{
    return $this->hasMany(Solicitud::class);
}

}
