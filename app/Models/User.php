<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\PhotoProfile;
use App\Models\SongDetails;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;
  public $timestamps = false;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  // protected $fillable = [
  //     'name',
  //     'email',
  //     'password',
  // ];

  protected $guarded = ['id'];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function photoProfile()
  {
    return $this->hasOne(PhotoProfile::class);
  }

  public function songDetails()
  {
    return $this->hasMany(SongDetails::class);
  }

  public function password(): Attribute
  {
    return new Attribute(
      set: fn ($value) => Hash::make($value)
    );
  }
}
