<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'emails',
        'actividad',
        'logotipo',
    ];

    protected $casts = [
        'emails' => 'array', // Cast de emails como array
    ];
    
    public function trabajadores()
    {
        return $this->hasMany(Trabajador::class);
    }
    public function nearAccidentReports()
    {
        return $this->hasMany(NearAccidentReport::class);
    }
    public function registrosCharlas()
    {
        return $this->hasMany(RegistroCharla::class);
    }
}
