<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspeccion extends Model
{
    use HasFactory;

    protected $table = 'inspecciones';


    protected $fillable = [
        'empresa_id', 'user_id', 'area', 'fecha_inspeccion', 'responsable_inspeccion', 'departamento', 'responsable_area',
    ];

    public function detalles()
    {
        return $this->hasMany(InspeccionDetalle::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
