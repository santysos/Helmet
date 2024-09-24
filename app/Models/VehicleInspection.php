<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'user_id',
        'driver_name',
        'plate',
        'vehicle_number',
        'inspection_date',
        'supervised_by',
        'observations_general',
    ];

    public function details()
    {
        return $this->hasMany(VehicleInspectionDetail::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function images()
    {
        return $this->hasMany(VehicleInspectionImage::class);
    }
}
