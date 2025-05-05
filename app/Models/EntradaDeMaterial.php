<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Insumo;

class EntradaDeMaterial extends Model
{
    use HasFactory;

    protected $table = 'entrada_de_material'; // Laravel lo nombraría mal por defecto

    protected $fillable = ['fecha', 'cantidad', 'insumos_id'];

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'insumos_id');
    }
}
