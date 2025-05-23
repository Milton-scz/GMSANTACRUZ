<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
     protected $fillable = [
        'solicitud_id',
        'signed',
        'firma',
        'urlPdfSigned',

    ];
      public function solicitud()
{
    return $this->belongsTo(Solicitud::class);
}
}
