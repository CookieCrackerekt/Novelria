<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Novel;
use App\Models\Genre;

class YouruploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $novels = Novel::where('user_id', $user->user_id)->get();
        $genres = Genre::all();
        return view('frontend.novel.yourupload', compact('novels', 'genres'));
    }

}
