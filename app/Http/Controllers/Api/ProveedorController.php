<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProveedorController extends Controller
{
    /**
     * Mostrar todos los proveedores.
     */
    public function index()
    {
        $proveedores = Proveedor::all();

        return response()->json([
            'success' => true,
            'data' => $proveedores,
        ], Response::HTTP_OK);
    }

    /**
     * Crear un nuevo proveedor.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|email|max:255|unique:proveedores,correo',
            'direccion' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $proveedor = Proveedor::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $proveedor,
            'message' => 'Proveedor creado exitosamente',
        ], Response::HTTP_CREATED);
    }

    /**
     * Mostrar un proveedor específico.
     */
    public function show(string $id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $proveedor,
        ], Response::HTTP_OK);
    }

    /**
     * Actualizar un proveedor.
     */
    public function update(Request $request, string $id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|email|max:255|unique:proveedores,correo,' . $id,
            'direccion' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $proveedor->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $proveedor,
            'message' => 'Proveedor actualizado exitosamente',
        ], Response::HTTP_OK);
    }

    /**
     * Eliminar un proveedor.
     */
    public function destroy(string $id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $proveedor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Proveedor eliminado exitosamente',
        ], Response::HTTP_OK);
    }
}
