@extends('backend.v_layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('backend.novel.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <h4 class="card-title">{{ $judul }}</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cover Novel : jpg,png,jpeg & webp</label>
                                        <img src="{{ asset('storage/img-user/img-default.jpg') }}" class="foto-preview"
                                            width="100%">
                                        <p></p>
                                        <input type="file" name="foto"
                                            class="form-control @error('foto') is-invalid @enderror"
                                            onchange="previewFoto()">
                                        @error('foto')
                                            <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Judul Novel</label>
                                        <input type="text" name="title" value="{{ old('title') }}"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="Masukkan Judul Novel" required>
                                        @error('title')
                                            <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Genre</label>
                                        <select name="genre" class="form-control @error('genre') is-invalid @enderror"
                                            required>
                                            <option value="" selected disabled>Pilih Genre</option>
                                            @foreach($genres as $genre)
                                                <option value="{{ $genre->genre_id }}" {{ old('genre') == $genre->genre_id ? 'selected' : '' }}>
                                                    {{ $genre->genre_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('genre')
                                            <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>File Novel (pdf only)</label>
                                        <input type="file" name="pdf"
                                            class="form-control @error('pdf') is-invalid @enderror" accept=".pdf" required>
                                        @error('pdf')
                                            <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Tambah Novel</button>
                                <a href="{{ route('backend.novel.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection