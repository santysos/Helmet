<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extintor extends Model
{
    use HasFactory;

    protected $table = 'extintores';

    protected $fillable = [
        'codigo',
        'tipo',
        'peso',
        'area',
        'empresa_id',
        'user_id',
        'fecha_mantenimiento',
        'imagen'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalles()
    {
        return $this->hasMany(InspeccionExtintoresDetalle::class);
    }
    
    public function imagenes()
    {
        return $this->hasMany(InspeccionExtintoresImagen::class, 'extintor_id');
    }
}
