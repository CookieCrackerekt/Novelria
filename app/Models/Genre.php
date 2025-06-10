<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'genres';
    protected $primaryKey = 'genre_id'; // karena primary key-nya bukan 'id'
    protected $fillable = [
        'genre_name',
    ];

    // Relasi: satu genre bisa memiliki banyak novel
    public function novels()
    {
        return $this->hasMany(Novel::class, 'genre_id','genre_id');
    }
}
