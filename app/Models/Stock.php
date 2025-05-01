<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Insumo;
use App\Models\Producto;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['cantidad', 'insumos_id', 'productos_id'];

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'insumos_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'productos_id');
    }
}
