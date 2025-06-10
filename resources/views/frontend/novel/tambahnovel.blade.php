@extends('frontend.layouts.app')

@section('content')
    @include('frontend.layouts.navbar')
    @include('frontend.layouts.sidebar')

    <div class="app">
        <div class="content">
            <h1>Add Novel</h1>
            @if (Auth::check())
                <p style="color: green;">Logged in as: {{ Auth::user()->email }}</p>
            @else
                <p style="color: red;">Not logged in</p>
            @endif
            <p>Silahkan tambahkan novel buatan anda atau novel lainnya</p>
            <br>
            @if(session('success')) <p style="color: green;">{{ session('success') }}</p> @endif
            @if(session('error')) <p style="color: red;">{{ session('error') }}</p> @endif
            <br>
            <form action="{{ route('frontend.novel.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="title">Judul:</label><br>
                <input type="text" class="novel-title" name="title" value="{{ old('title') }}" required><br><br>
                <label for="genre">Genre:</label><br>
                <select name="genre" class="novel-genre" required>
                    <option value="" disabled selected>Pilih Genre Novel</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->genre_id }}">{{ $genre->genre_name }}</option>
                    @endforeach
                </select><br><br>
                <label for="image">Cover Novel (jpg, png, webp):</label><br><br>
                <input type="file" class="upload-box" name="image" accept=".jpg,.jpeg,.png,.webp" required><br><br>
                <label for="pdf">File Novel (pdf only):</label><br><br>
                <input type="file" class="upload-box" name="pdf" accept=".pdf" required><br><br><br>
                <input type="submit" class="submit-novel" value="Tambah Novel">
            </form>
        </div>
    </div>
@endsection