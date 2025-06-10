<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@gmail.com',
            'role' => '0',
            'status' => 1,
            'password' => bcrypt('P@55word'),
            'hp' => '0812345678901',
        ]);
        User::create([
            'nama' => 'Muhammad Hammam Afif',
            'email' => 'afiflsils@gmail.com',
            'role' => '2',
            'status' => 1,
            'password' => bcrypt('P@55word'),
            'hp' => '081212533541',
        ]);
        
        Genre::create(['genre_name' => 'Fantasi',]);
        Genre::create(['genre_name' => 'Misteri',]);
        Genre::create(['genre_name' => 'Sci-Fi',]);
        Genre::create(['genre_name' => 'Horror',]);
        Genre::create(['genre_name' => 'Comedi',]);
    }
}
