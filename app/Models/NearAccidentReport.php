<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NearAccidentReport extends Model
{
    protected $fillable = [
        'empresa_id',
        'user_id',
        'reporter_name',
        'reporter_position',
        'reporter_area',
        'victim_name',
        'victim_position',
        'victim_work_location',
        'description',
        'condition_type',
        'severity_level',
        'photos',
        'follow_up_name',
        'follow_up_email',
    ];

    protected $casts = [
        'photos' => 'array', // Asegúrate de que este campo esté presente
        'condition_type' => 'array', // También casteamos 'condition_type' como array si es necesario
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
