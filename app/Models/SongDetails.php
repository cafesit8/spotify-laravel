<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SongMp3;
use App\Models\SongCover;
use App\Models\Category;

class SongDetails extends Model
{
  use HasFactory;
  public $timestamps = false;
  protected $guarded = [];

  protected $hidden = ['user_id', 'pivot'];

  function user()
  {
    return $this->belongsTo(User::class);
  }

  function songMp3()
  {
    return $this->hasOne(SongMp3::class);
  }

  function songCover()
  {
    return $this->hasOne(SongCover::class);
  }

  function categories() {
    return $this->belongsToMany(Category::class, 'category_songs', 'song_id', 'category_id');
  }
}
