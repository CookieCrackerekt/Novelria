<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Novel;
use App\Models\Genre;
use App\Models\User;

class NovelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $novels = Novel::with(['genre', 'user'])->get();
        $judul = 'Daftar Seluruh Novel';

        return view('backend.v_novel.index', compact('novels', 'judul'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $judul = 'Tambah Novel';
        $genres = Genre::all();
        return view('backend.v_novel.create', compact('genres', 'judul'));
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

        return redirect()->route('backend.novel.index')->with('success', 'Novel berhasil ditambahkan!');
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
        $novels = Novel::findOrFail($id);
        $genres = Genre::all();
        $judul = 'Edit Novel';

        return view('backend.v_novel.edit', compact('novels', 'genres', 'judul'));
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

        return redirect()->route('backend.novel.index')->with('success', 'Novel berhasil diperbarui!');
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

        return redirect()->route('backend.novel.index')->with('success', 'Novel berhasil dihapus!');
    }
    public function formNovel()
    {
        return view('backend.v_novel.form', ['judul' => 'Laporan Data Novel',]);
    } // Method untuk Cetak Laporan Produk 
    public function cetakNovel(Request $request)
    { // Menambahkan aturan validasi 
        $request->validate(['tanggal_awal' => 'required|date', 'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',], ['tanggal_awal.required' => 'Tanggal Awal harus diisi.', 'tanggal_akhir.required' => 'Tanggal Akhir harus diisi.', 'tanggal_akhir.after_or_equal' => 'Tanggal Akhir harus lebih besar atau sama dengan Tanggal Awal.',]);
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $query = Novel::whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir])->orderBy('novel_id', 'desc');
        $novel = $query->get();
        return view('backend.v_novel.cetak', ['judul' => 'Laporan Novel', 'tanggalAwal' => $tanggalAwal, 'tanggalAkhir' => $tanggalAkhir, 'cetak' => $novel]);
    }
}
