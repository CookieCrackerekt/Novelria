<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $primaryKey = 'favorite_id'; // karena bukan 'id'
    protected $table = 'favorites';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'novel_id',
    ];

    // Relasi: favorite milik user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: favorite milik novel
    public function novel()
    {
        return $this->belongsTo(Novel::class, 'novel_id');
    }
}
