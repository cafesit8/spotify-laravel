<?php

namespace App\Http\Controllers;

use App\Models\PhotoProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilePhotoController extends Controller
{
  public function index()
  {
    try {
      $photo = PhotoProfile::with('user')->paginate(5);
      return response($photo, 200);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function store(Request $request)
  {
    try {
      $validate = Validator::make($request->all(), [
        'url' => 'required',
      ]);
      if ($validate->fails()) {
        return response()->json(['message' => $validate->errors(), 'status' => 401], 401);
      }

      $photo = PhotoProfile::create($request->all());

      return response($photo, 201);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage(), 'status' => 500, 'error' => 'Something went wrong'], 500);
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $photo = PhotoProfile::find($id);
      if (!$photo) {
        $response = [
          'status' => 404,
          'message' => 'Photo not found.',
        ];
        return response()->json($response, 404);
      }

      $validator = Validator::make($request->all(), [
        'url' => 'required',
      ]);

      if ($validator->fails()) {
        return response()->json(['error' => $validator->errors(), 'status' => 401], 401);
      }

      $photo->update($request->all());
      $response = [
        'status' => 201,
        'message' => 'Photo updated successfully.',
        'data' => $photo
      ];

      return response()->json($response, 201);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function destroy($id)
  {
    try {
      $photo = PhotoProfile::find($id);
      if (!$photo) {
        $response = [
          'status' => 404,
          'message' => 'Photo not found.',
        ];
        return response()->json($response, 404);
      }
      $photo->delete();
      $response = [
        'status' => 201,
        'message' => 'Photo deleted successfully.',
      ];
      return response()->json($response, 201);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }
}
