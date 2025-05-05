<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{
    /**
     * Mostrar todos los roles.
     */
    public function index()
    {
        $roles = Rol::all();

        return response()->json([
            'success' => true,
            'data' => $roles,
        ], Response::HTTP_OK);
    }

    /**
     * Crear un nuevo rol.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|unique:rols,nombre',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $rol = Rol::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $rol,
            'message' => 'Rol creado exitosamente',
        ], Response::HTTP_CREATED);
    }

    /**
     * Mostrar un rol específico.
     */
    public function show(string $id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $rol,
        ], Response::HTTP_OK);
    }

    /**
     * Actualizar un rol existente.
     */
    public function update(Request $request, string $id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|unique:rols,nombre,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $rol->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $rol,
            'message' => 'Rol actualizado exitosamente',
        ], Response::HTTP_OK);
    }

    /**
     * Eliminar un rol.
     */
    public function destroy(string $id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $rol->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rol eliminado exitosamente',
        ], Response::HTTP_OK);
    }
}
