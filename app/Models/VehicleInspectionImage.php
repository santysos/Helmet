<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInspectionImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_inspection_id',
        'image_path',
    ];

    public function inspection()
    {
        return $this->belongsTo(VehicleInspection::class, 'vehicle_inspection_id');
    }
}
