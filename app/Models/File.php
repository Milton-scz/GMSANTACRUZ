<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
     protected $fillable = [
        'hash'
    ];
   public function solicitud()
{
    return $this->belongsTo(Solicitud::class);
}

}
