<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCharla extends Model
{
    use HasFactory;

    protected $table = 'registros_charlas';

    protected $fillable = [
        'empresa_id',
        'user_id',
        'departamento',
        'responsable_area',
        'responsable_charla',
        'area',
        'fecha_charla',
        'tema_brindado',
        'temas_discutidos_notas',
        'fotos'
    ];

    protected $casts = [
        'tema_brindado' => 'array',
        'fotos' => 'array',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trabajadores()
    {
        return $this->belongsToMany(Trabajador::class, 'registro_charla_trabajador');
    }
}