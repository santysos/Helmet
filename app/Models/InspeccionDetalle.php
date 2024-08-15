<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspeccionDetalle extends Model
{
    use HasFactory;

    protected $table = 'inspeccion_detalles';


    protected $fillable = [
        'inspeccion_id', 'pregunta', 'respuesta', 'observaciones', 'photo',
    ];

    public function inspeccion()
    {
        return $this->belongsTo(Inspeccion::class);
    }
}
