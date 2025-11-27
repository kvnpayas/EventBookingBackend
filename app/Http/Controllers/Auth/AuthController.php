<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required|string',
      'email' => 'required|email|unique:users',
      'password' => 'required|min:6|confirmed',
      'phone' => 'nullable|string',
      'role' => 'in:admin,organizer,customer',
    ]);

    $validatedData['password'] = Hash::make($validatedData['password']);

    $user = User::create($validatedData);

    $token = $user->createToken(name: 'api_token')->plainTextToken;


    return response()->json([
      'message' => 'User registered successfully',
      'token' => $token,
      'user' => $user
    ], 201);
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
      return response()->json([
        'message' => 'Invalid Credentials'
      ], 401);
    }

    $token = $user->createToken('api_token')->plainTextToken;

    return response()->json([
      'message' => 'Login successfully',
      'token' => $token,
      'user' => $user
    ], 200);
  }

  public function logout(Request $request)
  {

    $request->user()->tokens()->delete();

    return response()->json(['message' => 'Logged out successfully']);
  }

  public function me(Request $request)
  {
    return response()->json($request->user());
  }
}
