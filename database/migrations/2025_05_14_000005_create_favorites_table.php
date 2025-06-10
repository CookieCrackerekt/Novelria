<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id('favorite_id'); // primary key
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('novel_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('novel_id')->references('novel_id')->on('novels')->onDelete('cascade');

            // Optional: mencegah duplikasi favorit
            $table->unique(['user_id', 'novel_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
