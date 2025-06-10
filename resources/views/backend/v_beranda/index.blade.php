@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body border-top">
                <h5 class="card-title"> {{$judul}}</h5>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading"> Selamat Datang, {{ Auth::user()->nama }}</h4>
                    Web Novelria dengan hak akses yang anda miliki sebagai 
                    <b>
                        @if (Auth::user()->role == 1) Admin
                        @elseif(Auth::user()->role == 0) Super Admin 
                        @endif
                    </b> ini adalah halaman dashboard admin untuk website Novelria
                    <hr>
                    <p class="mb-0">Baca Novel...? ya di Novelria dong!!</p>
                </div>
            </div>
        </div>
    </div>
</div> 
<!-- contentAkhir -->
@endsection
