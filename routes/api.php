<?php

use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\EntradaDeMaterialController;
use App\Http\Controllers\Api\InsumoController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\ProcesoController;
use App\Http\Controllers\Api\ProduccionController;
use App\Http\Controllers\Api\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('produccion', ProduccionController::class);

Route::post('produccion/{produccion}/insumos', [ProduccionController::class, 'addInsumo']);
Route::post('produccion/{produccion}/insumos/clear', [ProduccionController::class, 'clearInsumos']);
Route::put('produccion/{produccion}/steps', [ProduccionController::class, 'updateSteps']);

Route::apiResource('proceso', ProcesoController::class);

Route::apiResource('pedido', PedidoController::class);

Route::post('pedido/{pedido}/productos', [PedidoController::class, 'addProduct']);

Route::apiResource('insumo', InsumoController::class);

Route::apiResource('cliente', ClienteController::class);

Route::apiResource('producto', ProductoController::class);

Route::apiResource('entrada-de-material', EntradaDeMaterialController::class);
