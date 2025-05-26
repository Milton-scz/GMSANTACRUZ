<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudFile extends Model
{
    protected $fillable = [
        'solicitud_id',
        'file_id',
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
