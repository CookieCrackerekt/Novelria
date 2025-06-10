<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
     /**
     * Tampilkan semua genre.
     */
    public function index()
    {
        $genre = Genre::orderBy('genre_name', 'asc')->get();
        return view('backend.v_genre.index', [
            'judul' => 'Genre',
            'index' => $genre
        ]);
    }

    /**
     * Tampilkan form tambah genre.
     */
    public function create()
    {
        return view('backend.v_genre.create', [
            'judul' => 'Tambah Genre',
        ]);
    }

    /**
     * Simpan genre baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'genre_name' => 'required|max:255|unique:genres',
        ]);

        Genre::create($validated);
        return redirect()->route('backend.genre.index')->with('success', 'Genre berhasil ditambahkan');
    }

    /**
     * Tampilkan form edit genre.
     */
    public function edit(string $id)
    {
        $genre = Genre::findOrFail($id);
        return view('backend.v_genre.edit', [
            'judul' => 'Edit Genre',
            'edit' => $genre
        ]);
    }

    /**
     * Update genre.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'genre_name' => 'required|max:255|unique:genres,genre_name,' . $id . ',genre_id',
        ]);

        Genre::where('genre_id', $id)->update($validated);
        return redirect()->route('backend.genre.index')->with('success', 'Genre berhasil diperbarui');
    }

    /**
     * Hapus genre.
     */
    public function destroy(string $id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();
        return redirect()->route('backend.genre.index')->with('success', 'Genre berhasil dihapus');
    }
}
