<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Produccion;

class Proceso extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'steps', 'insumos'];

    protected $casts = [
        'steps' => 'array',
        'insumos' => 'array',
    ];

    public function produccion()
    {
        return $this->belongsTo(Produccion::class);
    }

    public function producciones()
    {
        return $this->hasMany(Produccion::class, 'proceso_id');
    }
}
