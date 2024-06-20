<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorySong extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['category_id', 'song_id'];

    protected $hidden = ['pivot'];
}
