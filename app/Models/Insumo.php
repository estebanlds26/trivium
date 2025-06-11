<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\EntradaDeMaterial;
use App\Models\Produccion;
use App\Models\Stock;

class Insumo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'unidad', 'marca'];

    // Relaciones

    public function entradas()
    {
        return $this->hasMany(EntradaDeMaterial::class, 'insumo_id');
    }

    public function producciones()
    {
        return $this->belongsToMany(Produccion::class, 'producciones_has_insumos')
                    ->withPivot('cantidad_usada');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'insumos_id');
    }
}
