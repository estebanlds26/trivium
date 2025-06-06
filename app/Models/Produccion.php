<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    protected $table= "producciones";


    protected $fillable = [
        'fecha',
        'cantidad',
        'active_step',
        'proceso_steps_copy',
        'user_id',
        'producto_id',
        'proceso_id',
        'estado'
    ];

    protected $casts = [
        'proceso_steps_copy' => 'array',
    ];

        public function insumos()
{
    return $this->belongsToMany(Insumo::class, 'producciones_has_insumos')->withPivot('cantidad_usada', 'precio_unitario');
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function proceso()
{
    return $this->belongsTo(Proceso::class);
}

public function producto()
{
    return $this->belongsTo(Producto::class);
}
}
