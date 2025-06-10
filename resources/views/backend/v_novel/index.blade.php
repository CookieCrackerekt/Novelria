@extends('backend.v_layouts.app')
@section('content')
<!-- contentAwal -->
<div class="row">
    <div class="col-12">
        <a href="{{ route('backend.novel.create') }}">
            <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
        </a>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"> {{ $judul }} </h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Genre</th>
                                <th>Uploader</th>
                                <th>Cover</th>
                                <th>PDF</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($novels as $novel)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $novel->title }}</td>
                                    <td>{{ $novel->genre->genre_name ?? '-' }}</td>
                                    <td>{{ $novel->user->nama ?? 'Unknown' }}</td>
                                    <td>
                                        <img src="{{ asset($novel->image_path) }}" width="60" alt="cover">
                                    </td>
                                    <td>
                                        <a href="{{ asset($novel->pdf_path) }}" target="_blank" class="btn btn-sm btn-info">
                                            Lihat PDF
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('backend.novel.edit', $novel->novel_id) }}" class="btn btn-sm btn-cyan">
                                            <i class="far fa-edit"></i> Ubah
                                        </a>
                                        <form action="{{ route('backend.novel.destroy', $novel->novel_id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger show_confirm"
                                                data-konf-delete="{{ $novel->title }}">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contentAkhir -->
@endsection
