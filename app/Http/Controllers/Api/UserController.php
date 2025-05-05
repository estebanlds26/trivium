<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::with('rol')->get();

        return response()->json([
            'success' => true,
            'data' => $users,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'cellphone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|exists:roles,id', // Assuming you have a roles table
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash the password
            'rol_id' => $request->rol_id,
        ]);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Usuario creado exitosamente',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified user.
     */
    public function show(string $id)
    {
        $user = User::with('rol')->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $user,
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|required|string|max:255|unique:users,username,' . $id,
            'name' => 'sometimes|required|string|max:255',
            'cellphone' => 'sometimes|required|string|max:15',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8|confirmed',
            'rol_id' => 'sometimes|required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Update user fields
        $user->update(array_filter($request->all())); // Use array_filter to ignore null values

        if ($request->has('password')) {
            $user->password = bcrypt($request->password); // Hash the password if it's being updated
            $user->save();
        }

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Usuario actualizado exitosamente',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado satisfactoriamente',
        ], Response::HTTP_OK);
    }
}       