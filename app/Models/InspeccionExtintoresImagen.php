<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspeccionExtintoresImagen extends Model
{
    use HasFactory;

    protected $table = 'inspecciones_extintores_imagenes';

    protected $fillable = [
        'inspeccion_extintor_id',
        'extintor_id',
        'ruta_imagen',
    ];

    /**
     * Relación con el modelo InspeccionExtintoresDetalle
     */
    public function detalle()
    {
        return $this->belongsTo(InspeccionExtintoresDetalle::class, 'inspeccion_extintor_id');
    }

    /**
     * Relación con el modelo Extintor
     */
    public function extintor()
    {
        return $this->belongsTo(Extintor::class, 'extintor_id');
    }
}
