<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspeccionExtintoresDetalle extends Model
{
    use HasFactory;

    protected $table = 'inspecciones_extintores_detalle';

    protected $fillable = [
        'inspeccion_extintor_id',
        'extintor_id',
        'pregunta',
        'respuesta',
        'observaciones'
    ];

    public function inspeccionExtintor()
    {
        return $this->belongsTo(InspeccionExtintores::class, 'inspeccion_extintor_id');
    }

    public function extintor()
    {
        return $this->belongsTo(Extintor::class);
    }

    public function imagenes()
    {
        return $this->hasMany(InspeccionExtintoresImagen::class, 'inspeccion_extintor_id')
                    ->where('extintor_id', $this->extintor_id);
    }
    
}