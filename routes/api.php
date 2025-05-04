<?php

use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\InsumoController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\ProcesoController;
use App\Http\Controllers\Api\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('produccion', ProductoController::class);

Route::apiResource('proceso', ProcesoController::class);

Route::apiResource('pedido', PedidoController::class);

Route::apiResource('insumo', InsumoController::class);

Route::apiResource('cliente', ClienteController::class);
