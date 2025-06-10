<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Novel;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        $favorites = Novel::select('novels.*', 'genres.genre_name')
            ->join('favorites', 'favorites.novel_id', '=', 'novels.novel_id')
            ->leftJoin('genres', 'novels.genre_id', '=', 'genres.genre_id')
            ->where('favorites.user_id', $user->user_id)
            ->get();

        $favoriteNovelIds = $favorites->pluck('novel_id')->toArray();$favoriteNovelIds = $favorites->pluck('novel_id')->toArray();
        
        return view('frontend.novel.favorit', compact('favorites','favoriteNovelIds'));
    }

    public function toggle(Request $request)
    {
        \Log::info('Toggle Favorit - Auth ID', ['id' => auth()->id()]);

        if (!auth()->check()) {
            return redirect()->route('frontend.authentication.loginregister')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'novel_id' => 'required|exists:novels,novel_id',
        ]);

        $userId = auth()->id();
        $novelId = $request->input('novel_id');

        $favorite = Favorite::where('user_id', $userId)
            ->where('novel_id', $novelId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Novel dihapus dari favorit.';
        } else {
            Favorite::create([
                'user_id' => $userId,
                'novel_id' => $novelId,
            ]);
            $message = 'Novel ditambahkan ke favorit.';
        }

        return redirect()->back()->with('status', $message);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
