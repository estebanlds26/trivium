<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Cliente;
use App\Models\Producto;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['fecha', 'estado', 'cliente_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'pedidos_has_productos')
        ->using(PedidoHasProducto::class)
        ->withPivot('cantidad', 'importe')
        ->withTimestamps();
    }
}
