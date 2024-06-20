<?php

namespace App\Http\Controllers;

use App\Models\PhotoProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  public function index()
  {
    try {
      $users = User::with('photoProfile')->paginate(5);

      $response = [
        'success' => true,
        'message' => 'Users retrieved successfully.',
        'data' => $users
      ];

      return response()->json($response, 200);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function show($id)
  {
    try {
      $user = User::with('photoProfile')->find($id);
      $response = [
        'status' => 201,
        'message' => 'User retrieved successfully.',
        'data' => $user
      ];

      return response()->json($response, 200);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function store(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'name' => 'required|max:45',
        'surname' => 'required|max:150',
        'username' => 'required|max:45|unique:users',
        'created_at' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required',
        'url' => 'required',
      ]);

      if ($validator->fails()) {
        return response()->json(['error' => $validator->errors(), 'status' => 401], 401);
      }

      $user = User::create($request->all());
      $photoProfile = PhotoProfile::create(['url' => $request->url, 'user_id' => $user->id]);
      $user['photoProfile'] = $photoProfile;

      $response = [
        'status' => 201,
        'message' => 'User created successfully.',
        'data' => $user
      ];

      return response()->json($response, 201);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $user = User::with('photoProfile')->find($id);

      if (!$user) {
        $response = [
          'status' => 404,
          'message' => 'User not found.',
        ];
        return response()->json($response, 404);
      }

      $validator = Validator::make($request->all(), [
        'name' => 'max:45',
        'surname' => 'max:150',
        'username' => 'max:45|unique:users',
        'email' => 'email',
      ]);

      if ($validator->fails()) {
        return response()->json(['error' => $validator->errors(), 'status' => 401], 401);
      }

      $user->update($request->all());
      $response = [
        'status' => 201,
        'message' => 'User updated successfully.',
        'data' => $user
      ];

      return response()->json($response, 201);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function destroy($id)
  {
    try {
      $user = User::find($id);
      if (!$user) {
        $response = [
          'status' => 404,
          'message' => 'User not found.',
        ];
        return response()->json($response, 404);
      }
      $user->delete();
      $response = [
        'status' => 201,
        'message' => 'User deleted successfully.',
      ];
      return response()->json($response, 201);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }
}
