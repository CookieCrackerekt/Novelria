<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNovelsTable extends Migration
{
    public function up()
    {
        Schema::create('novels', function (Blueprint $table) {
            $table->id('novel_id'); // primary key
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('genre_id');
            $table->string('title');
            $table->string('image_path')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('genre_id')->references('genre_id')->on('genres')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('novels');
    }
}
