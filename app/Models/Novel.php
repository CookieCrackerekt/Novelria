<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Novel extends Model
{
    use HasFactory;

    protected $primaryKey = 'novel_id'; // karena bukan 'id' default
    protected $table = 'novels';
    protected $fillable = [
        'user_id',
        'genre_id',
        'title',
        'image_path',
        'pdf_path',
    ];

    // Relasi ke User (setiap novel dimiliki oleh satu user)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relasi ke Genre
    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'genre_id');
    }

    public function favorites()
    {   
    return $this->hasMany(Favorite::class, 'novel_id');
    }

}
