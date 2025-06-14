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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('nama');
            $table->string('email')->unique();
            $table->enum('role', [0, 1, 2])->default(2); // 0 = Admin, 1 = SuperAdmin, 2=user
            $table->boolean('status'); // 0 = Belum aktif, 1=Aktif
            $table->string('password');
            $table->string('hp', 13);
            $table->string('foto')->nullable();
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
