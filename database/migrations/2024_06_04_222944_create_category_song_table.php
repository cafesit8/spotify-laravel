<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('category_songs', function (Blueprint $table) {
      $table->foreignId('song_id')->constrained('song_details')->onDelete('cascade');
      $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
      $table->primary(['song_id', 'category_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('category_songs');
  }
};
