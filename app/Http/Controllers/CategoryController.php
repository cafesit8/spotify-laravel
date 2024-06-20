<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  function index()
  {
    try {
      $categories = Category::paginate(10);
      $reponse = [
        'message' => 'Categories retrieved successfully.',
        'data' => $categories,
        'status' => 200
      ];

      return response()->json($reponse, 200);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  function show($id)
  {
    try {
      $category = Category::find($id);
      if (!$category) {
        $response = [
          'message' => 'Category not found.',
          'data' => [],
          'status' => 404
        ];
        return response()->json($response, 200);
      }

      $response = [
        'message' => 'Category retrieved successfully.',
        'data' => $category,
        'status' => 200
      ];
      return response()->json($response, 200);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }
}
