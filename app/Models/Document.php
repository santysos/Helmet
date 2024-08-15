<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'file_path',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
