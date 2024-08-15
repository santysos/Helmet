<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInspectionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_inspection_id',
        'question',
        'answer',
        'observations',
    ];

    public function inspection()
    {
        return $this->belongsTo(VehicleInspection::class);
    }
}
