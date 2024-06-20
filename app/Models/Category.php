<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SongDetails;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['pivot'];
    public $timestamps = false;
    // protected $with = ['songDetails'];

    public function songDetails()
    {
        return $this->belongsToMany(SongDetails::class, 'category_songs', 'category_id', 'song_id');
    }
}
