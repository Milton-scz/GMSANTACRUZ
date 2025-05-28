<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $fillable = [
        'formulario_id',
        'beneficiario_id',
        'estado',

    ];

   public function beneficiario()
{
    return $this->belongsTo(Beneficiario::class);
}

   public function actividadEconomica()
{
    return $this->belongsTo(ActividadEconomica::class);
}

   public function formulario()
{
    return $this->belongsTo(Formulario::class);
}

   public function certificado()
{
    return $this->belongsTo(Certificado::class);
}

public function files()
{
    return $this->belongsToMany(File::class);
}
public function notificacion()
{
    return $this->hasOne(Notificacion::class);
}

}
