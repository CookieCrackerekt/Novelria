<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Novel;
use App\Models\Favorite;

class HomeController extends Controller
{
    public function index()
    {
        $novels = Novel::with('genre')->get();

        $favoriteNovelIds = [];
        if (Auth::check()) {
            $favoriteNovelIds = Favorite::where('user_id', Auth::id())->pluck('novel_id')->toArray();
        }

        return view('frontend.home', compact('novels', 'favoriteNovelIds'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

}
