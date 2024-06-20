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
        Schema::create('song_covers', function (Blueprint $table) {
            $table->id();
            $table->string('url');

            $table->unsignedBigInteger('song_details_id');
            $table->foreign('song_details_id')->references('id')->on('song_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('song_covers');
    }
};
