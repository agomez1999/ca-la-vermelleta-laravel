<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
  public function verifyToken(Request $request)
  {
      // Verifica si el usuario está autenticado
      if (Auth::check()) {
          return response()->json([
              'message' => 'Token válido',
              'user' => Auth::user(),
          ], 200);
      } else {
          return response()->json([
              'message' => 'Token inválido',
          ], 401);  // Código 401 indica que no está autenticado
      }
  }

  public function store(Request $request)
  {
    $data = $request->all();
    User::create($data);

    return response()->json(['message' => 'Insertado correctamente'], 201);
  }

  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|email',
      'password' => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'Errores en el formulario',
        'errors' => $validator->errors()
      ], 422);
    }

    $user = User::where('email', $request->email)->first();
    
    if (!$user || !Hash::check($request->password, $user->password)) {
      Log::warning("Intento de login fallido para el email: " . $request->email);
      return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    $token = $user->createToken('CaLaVermelleta')->plainTextToken;

    return response()->json([
      'message' => 'Login exitoso',
      'user' => $user,
      'token' => $token
    ], 200);
  }
}