<?php

namespace App\Http\Controllers;

use App\Models\CategorySong;
use App\Models\SongCover;
use App\Models\SongDetails;
use App\Models\SongMp3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SongDetailsController extends Controller
{
  public function index()
  {
    try {
      $song_list = SongDetails::with(['user', 'songMp3', 'songCover', 'categories'])->paginate(10);

      $response = [
        'message' => 'Songs retrieved successfully.',
        'data' => $song_list,
        'status' => 200
      ];

      return response()->json($response, 200);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function show($id)
  {
    try {
      $song = SongDetails::find($id);
      if ($song) {
        $response = [
          'message' => 'Song retrieved successfully.',
          'data' => $song,
          'status' => 200
        ];
      } else {
        $response = [
          'message' => 'Song not found.',
          'data' => [],
          'status' => 404
        ];
      }
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
        'artist' => 'required|max:100',
        'album' => 'max:50',
        'realease_date' => 'required',
        'duration' => 'required',
        'user_id' => 'required|exists:users,id',
        'cover' => 'required|max:255',
        'url' => 'required|max:255',
        'category_id' => 'required|exists:categories,id',
      ]);

      if ($validator->fails()) {
        return response()->json(['error' => $validator->errors(), 'status' => 401, 'message' => 'Validation error'], 401);
      }

      $song = SongDetails::create(['name' => $request->name, 'artist' => $request->artist, 'album' => $request->album, 'realease_date' => $request->realease_date, 'duration' => $request->duration, 'user_id' => $request->user_id]);
      SongCover::create(['url' => $request->cover, 'song_details_id' => $song->id]);
      SongMp3::create(['url' => $request->url, 'song_details_id' => $song->id]);
      CategorySong::create(['song_id' => $song->id, 'category_id' => $request->category_id]);

      $response = [
        'message' => 'Song created successfully.',
        'data' => $song,
        'status' => 201
      ];

      return response()->json($response, 201);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage(), 'status' => 500, 'error' => 'Something went wrong'], 500);
    }
  }

  public function destroy($id)
  {
    try {
      $song = SongDetails::find($id);
      if (!$song) {
        $response = [
          'status' => 404,
          'message' => 'Song not found.',
        ];
        return response()->json($response, 404);
      }
      $song->delete();
      $response = [
        'status' => 201,
        'message' => 'Song deleted successfully.',
      ];
      return response()->json($response, 201);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  function getByCategory($id)
  {
    try {
      $song_list = SongDetails::with(['user', 'songMp3', 'songCover', 'categories'])->whereHas('categories', function ($query) use ($id) {
        $query->where('category_id', $id);
      })->paginate(10);
      return response()->json($song_list, 200);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function search($query)
  {
    try {
      $songs = SongDetails::with(['user', 'songMp3', 'songCover'])->where('name', 'like', "%$query%")
        ->orWhere('artist', 'like', "%$query%")
        ->paginate(10);

      return response()->json($songs);
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }
}
