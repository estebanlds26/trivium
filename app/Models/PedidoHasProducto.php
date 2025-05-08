<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PedidoHasProducto extends Pivot
{
    protected $table = 'pedidos_has_productos';
    
    protected $fillable = ['pedido_id', 'producto_id', 'cantidad', 'importe'];
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}