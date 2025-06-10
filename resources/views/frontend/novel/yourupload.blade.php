@extends('frontend.layouts.app')
@section('content')
    @include('frontend.layouts.navbar')
    @include('frontend.layouts.sidebar')

    <div class="app">
        <div class="content">
            <h1>Your Uploaded Novels</h1>
            @if (Auth::check())
                <p style="color: green;">Logged in as: {{ Auth::user()->email }}</p>
            @else
                <p style="color: red;">Not logged in</p>
            @endif
            <p>Berikut adalah novel yang telah Anda upload</p>
            <br>
            @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p> @endif
            @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p> @endif
            <br>
            <input type="text" class="searchBar" id="searchBar" placeholder="Cari novel..." onkeyup="filterNovels()">
            <br>
            <table class="novels-table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Genre</th>
                        <th>Cover</th>
                        <th>File PDF</th>
                        <th>Update</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($novels as $novel)
                        <tr>
                            <form action="{{ route('frontend.novel.update', $novel->novel_id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <td>
                                    <input type="text" name="title" value="{{ $novel->title }}" required>
                                </td>

                                <td>
                                    <select name="genre" required>
                                        @foreach($genres as $genre)
                                            <option value="{{ $genre->genre_id }}" {{ $novel->genre_id == $genre->genre_id ? 'selected' : '' }}>
                                                {{ $genre->genre_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <img src="{{ asset($novel->image_path ?? 'img-default.jpg') }}" width="80"
                                        style="display:block; margin-bottom:5px;">
                                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp">
                                </td>

                                <td>
                                    @if($novel->pdf_path)
                                        <a href="{{ asset($novel->pdf_path) }}" target="_blank">Lihat PDF</a><br>
                                    @endif
                                    <input type="file" name="pdf" accept=".pdf">
                                </td>

                                <td>
                                    <button type="submit" class="save-btn">Simpan</button>
                                </td>
                            </form>
                            <td>
                                <form action="{{ route('frontend.novel.delete', $novel->novel_id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin hapus novel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Anda belum mengupload novel apapun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterNovels() {
            const input = document.getElementById('searchBar').value.toLowerCase();
            const rows = document.querySelectorAll('.novels-table tbody tr');

            rows.forEach(row => {
                const title = row.querySelector('input[name="new_title"]').value.toLowerCase();
                row.style.display = title.includes(input) ? '' : 'none';
            });
        }
    </script>
@endsection