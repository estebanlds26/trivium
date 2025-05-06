<?php

use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\InsumoController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\ProcesoController;
use App\Http\Controllers\Api\ProduccionController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\EntradaDeMaterialController;
use App\Http\Controllers\Api\ProveedorController;
use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('produccion', ProduccionController::class);

Route::apiResource('proceso', ProcesoController::class);

Route::apiResource('pedido', PedidoController::class);

Route::post('pedido/{pedido}/productos', [PedidoController::class, 'addProduct']);

Route::apiResource('insumo', InsumoController::class);

Route::apiResource('cliente', ClienteController::class);

Route::apiResource('producto', ProductoController::class);

Route::apiResource('entradas-de-material', EntradaDeMaterialController::class);

Route::apiResource('proveedores', ProveedorController::class);

Route::apiResource('roles', RolController::class);

Route::apiResource('stocks', StockController::class);

Route::apiResource('users', UserController::class);