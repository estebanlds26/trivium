<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    protected $table= "producciones";


    protected $fillable = [
        'fecha',
        'cantidad',
        'user_id',
        'producto_id',
    ];
        public function insumos()
{
    return $this->belongsToMany(Insumo::class, 'producciones_has_insumos')->withPivot('cantidad_usada', 'precio_unitario');
}

public function user()
{
    return $this->belongsTo(User::class);
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
