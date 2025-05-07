<?php

use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\InsumoController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\ProcesoController;
use App\Http\Controllers\Api\ProduccionController;
use App\Http\Controllers\Api\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('produccion', ProduccionController::class);

Route::post('produccion/{produccion}/insumos', [ProduccionController::class, 'addInsumo']);

Route::apiResource('proceso', ProcesoController::class);

Route::apiResource('pedido', PedidoController::class);

Route::post('pedido/{pedido}/productos', [PedidoController::class, 'addProduct']);

Route::apiResource('insumo', InsumoController::class);

Route::apiResource('cliente', ClienteController::class);

Route::apiResource('producto', ProductoController::class);
