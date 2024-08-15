<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    use HasFactory;

    protected $table = 'trabajadores';

    protected $fillable = [
        'empresa_id',
        'cedula',
        'nombre',
        'apellido',
        'area_trabajo',
        'firma',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
    public function registrosCharlas()
    {
        return $this->belongsToMany(RegistroCharla::class, 'registro_charla_trabajador');
    }
}
