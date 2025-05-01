<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Produccion;

class Proceso extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'fecha', 'produccion_id'];

    public function produccion()
    {
        return $this->belongsTo(Produccion::class);
    }
}
