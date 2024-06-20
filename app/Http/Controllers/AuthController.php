<?php

namespace App\Http\Controllers;

use App\Models\PhotoProfile;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'name' => 'required|max:45',
        'surname' => 'required|max:150',
        'username' => 'required|max:45|unique:users',
        'created_at' => '',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8',
        'url' => 'required',
      ]);

      if ($validator->fails()) {
        return response()->json(['error' => $validator->errors(), 'status' => 401], 401);
      }

      $user = User::create($request->all());
      PhotoProfile::create(['url' => $request->url, 'user_id' => $user->id]);
      $userInfo = $user->load('photoProfile');
      $token = $user->createToken('auth_token')->plainTextToken;

      return response()->json(['access_token' => $token, 'token_type' => 'Bearer', 'data' => $userInfo], 201);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function login(Request $request)
  {
    try {
      $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
      ]);

      if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Invalid login details'], 401);
      }

      $user = Auth::user();
      $userInfo = $user->load('photoProfile');
      $token = $user->createToken('auth_token')->plainTextToken;

      return response()->json(['access_token' => $token, 'token_type' => 'Bearer', 'data' => $userInfo], 200);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function logout(Request $request)
  {
    try {
      $request->user()->currentAccessToken()->delete();

      return response()->json(['message' => 'You have successfully logged out']);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function user(Request $request)
  {
    return response()->json($request->user());
  }
}
