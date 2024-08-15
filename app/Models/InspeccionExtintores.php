<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspeccionExtintores extends Model
{
    use HasFactory;

    protected $table = 'inspeccion_extintores';

    protected $fillable = [
        'empresa_id',
        'area',
        'fecha_inspeccion',
        'responsable_inspeccion',
        'departamento',
        'comentarios',
        'riesgos_recomendaciones'
    ];

    // Agregar propiedad de fechas
    protected $dates = ['fecha_inspeccion'];


    // Relación con Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    // Relación muchos a muchos con Extintores a través de la tabla pivote inspeccion_extintor
    public function extintores()
    {
        return $this->belongsToMany(Extintor::class, 'inspeccion_extintor', 'inspeccion_id', 'extintor_id')
            ->withTimestamps();
    }


    // Relación uno a muchos con InspeccionesExtintoresDetalle
    public function detalles()
    {
        return $this->hasMany(InspeccionExtintoresDetalle::class, 'inspeccion_extintor_id');
    }

    public function imagenes()
    {
        return $this->hasMany(InspeccionExtintoresImagen::class, 'inspeccion_extintor_id');
    }
}
