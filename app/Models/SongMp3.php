<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SongDetails;

class SongMp3 extends Model
{
  use HasFactory;
  public $timestamps = false;
  protected $guarded = [];
  protected $hidden = ['song_details_id'];
  function songDetails()
  {
    return $this->belongsTo(SongDetails::class);
  }
}
