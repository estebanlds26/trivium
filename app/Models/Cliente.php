<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Pedido;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'telefono', 'correo', 'direccion'];
    public function pedidos()
{
    return $this->hasMany(Pedido::class);
}
}
