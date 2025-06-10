<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Novel;
use App\Models\Genre;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;


class NovelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $novels = Novel::with('genre')->get();

        $favoriteNovelIds = [];
        if (Auth::check()) {
            $favoriteNovelIds = Favorite::where('user_id', Auth::id())->pluck('novel_id')->toArray();
        }

        return view('frontend.novel.library', compact('novels', 'favoriteNovelIds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('frontend.authentication.loginregister')->with('error', 'Silakan login terlebih dahulu.');
        }
        $genres = Genre::all();
        return view('frontend.novel.tambahnovel', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|exists:genres,genre_id',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp',
            'pdf' => 'required|mimes:pdf',
        ]);

        $imagePath = $request->file('image')->store('novelria-novelcover', 'public');
        $pdfPath = $request->file('pdf')->store('novelria-novel', 'public');

        Novel::create([
            'user_id' => Auth::id(),
            'genre_id' => $request->genre,
            'title' => $request->title,
            'image_path' => 'storage/' . $imagePath,
            'pdf_path' => 'storage/' . $pdfPath,
        ]);

        return redirect()->route('frontend.novel.create')->with('success', 'Novel berhasil ditambahkan!');
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
        $novel = Novel::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|exists:genres,genre_id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'pdf' => 'nullable|mimes:pdf',
        ]);

        // Update file gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('novelria-novelcover', 'public');
            $novel->image_path = 'storage/' . $imagePath;
        }

        // Update file PDF jika ada
        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('novelria-novel', 'public');
            $novel->pdf_path = 'storage/' . $pdfPath;
        }

        $novel->title = $request->title;
        $novel->genre_id = $request->genre;
        $novel->save();

        return redirect()->route('your.upload')->with('success', 'Novel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $novel = Novel::findOrFail($id);

        // Hapus file cover jika ada
        if ($novel->image_path && file_exists(public_path($novel->image_path))) {
            unlink(public_path($novel->image_path));
        }

        // Hapus file PDF jika ada
        if ($novel->pdf_path && file_exists(public_path($novel->pdf_path))) {
            unlink(public_path($novel->pdf_path));
        }

        // Hapus data novel dari database
        $novel->delete();

        return redirect()->route('your.upload')->with('success', 'Novel berhasil dihapus!');
    }
}
