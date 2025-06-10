@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="form-horizontal" action="{{ route('backend.genre.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title"> {{ $judul }} </h4>
                        <div class="form-group">
                            <label>Nama Genre</label>
                            <input type="text" name="genre_name"
                                   value="{{ old('genre_name') }}"
                                   class="form-control @error('genre_name') is-invalid @enderror"
                                   placeholder="Masukkan Nama Genre">
                            @error('genre_name')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('backend.genre.index') }}">
                                <button type="button" class="btn btn-secondary">Kembali</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 
<!-- contentAkhir --> 
@endsection
