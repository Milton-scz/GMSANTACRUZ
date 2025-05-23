<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
      protected $fillable = [
        'beneficiario_id',
        'actividad_economica_id',
    ];



    public function solicitud()
{
    return $this->hasMany(Solicitud::class);
}

    public function actividadEconomica()
{
    return $this->belongsTo(ActividadEconomica::class);
}

    public function beneficiario()
{
    return $this->belongsTo(Beneficiario::class);
}
}
