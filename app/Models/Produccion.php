<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    protected $table= "producciones";

    public function insumos()
{
    return $this->belongsToMany(Insumo::class, 'producciones_has_insumos')->withPivot('cantidad_usada');
}

public function procesos()
{
    return $this->hasMany(Proceso::class);
}

public function producto()
{
    return $this->belongsTo(Producto::class);
}
}
