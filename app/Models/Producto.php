<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Produccion; 
use App\Models\Pedido; 
use App\Models\Stock; 

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'imagenes', 'precio'];

    // Relaciones
    public function producciones()
    {
        return $this->hasMany(Produccion::class);
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedidos_has_productos')->withPivot('cantidad');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'productos_id');
    }

}
