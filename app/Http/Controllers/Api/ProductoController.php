<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with(['producciones.producto', 'producciones.insumos','pedidos.user'])->get();
        // Decode imagenes for each product
        $productos->transform(function ($producto) {
            $producto->imagenes = $producto->imagenes ? json_decode($producto->imagenes) : [];
            return $producto;
        });

        return response()->json([
            'success' => true,
            'data' => $productos,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45',
            'descripcion' => 'required|string',
            'imagenes' => 'nullable|array',
            'precio' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $imagePaths = [];

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $image) {
                $path = $image->store('images', 'public');
                $imagePaths[] = $path;
            }
        }

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'imagenes' => json_encode($imagePaths),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto creado con éxito',
            'data' => $producto,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::with(['producciones.producto', 'producciones.insumos', 'pedidos'])->find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        // Decode imagenes for single product
        $producto->imagenes = $producto->imagenes ? json_decode($producto->imagenes) : [];

        return response()->json([
            'success' => true,
            'data' => $producto,
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        // Debug log to check incoming request data
        \Log::info('Update Request Data:', $request->all());

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45',
            'descripcion' => 'required|string',
            'precio' => 'required|integer',
            'existing' => 'nullable|array',
            'existing.*' => 'string',
            'imagenes' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            // Debug log to check validation errors
            \Log::error('Validation Errors:', $validator->errors()->toArray());

            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Save current state for image comparison
        $oldImages = json_decode($producto->imagenes, true) ?? [];

        // Combine existing and new paths
        $existingPaths = $request->input('existing', []);
        $imagePaths = $existingPaths;

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $image) {
                $imagePaths[] = $image->store('images', 'public');
            }
        }

        // Remove deleted images from storage
        $deletedImages = array_diff($oldImages, $imagePaths);
        foreach ($deletedImages as $img) {
            $imgPath = storage_path('app/public/' . $img);
            if (file_exists($imgPath)) {
                @unlink($imgPath);
            }
        }

        $producto->update([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
            'imagenes' => json_encode($imagePaths),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado con éxito',
            'data' => $producto,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        // Remove all linked images from storage
        $imagenes = json_decode($producto->imagenes, true) ?? [];
        foreach ($imagenes as $img) {
            $imgPath = storage_path('app/public/' . $img);
            if (file_exists($imgPath)) {
                @unlink($imgPath);
            }
        }

        $producto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado con éxito',
        ], Response::HTTP_OK);
    }
}