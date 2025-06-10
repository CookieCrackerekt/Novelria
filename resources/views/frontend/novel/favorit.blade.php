@extends('frontend.layouts.app')

@section('content')
    @include('frontend.layouts.navbar')
    @include('frontend.layouts.sidebar')

    <div class="app">
        <div class="content">
            <h1>Your Favorite Novels</h1>
            @if (Auth::check())
                <p style="color: green;">Logged in as: {{ Auth::user()->email }}</p>
            @else
                <p style="color: red;">Not logged in</p>
            @endif
            <p>Berikut adalah novel yang telah Anda tambahkan ke favorit Anda</p>
            <br>
            @if(session('success')) <p style="color: green;">{{ session('success') }}</p> @endif
            @if(session('error')) <p style="color: red;">{{ session('error') }}</p> @endif
            <br>
            <input type="text" class="searchBar" id="searchBar" placeholder="Cari novel favorit..." onkeyup="filterFavorites()">
            <br>
            <div class="card-container">
                @forelse ($favorites as $novel)
                    <div class="card">
                        <img src="{{ asset($novel->image_path) }}" class="card-img" alt="Card Image" height="345" width="240"
                            style="border-radius:7%">
                        <div class="card-body">
                            <h3 class="card-title">{{ $novel->title }}</h3>
                            <br>
                            <p class="card-genre">Genre: {{ $novel->genre_name }}</p>
                            @if ($novel->pdf_path)
                                <a href="{{ asset($novel->pdf_path) }}" class="card-btn" target="_blank">Buka PDF</a>
                            @endif
                            <br>
                            @auth
                                <form action="{{ route('favorit.toggle') }}" method="POST" class="favorite-form">
                                    @csrf
                                    <input type="hidden" name="novel_id" value="{{ $novel->novel_id ?? $novel->id }}">
                                    <button type="submit" class="favorite-btn">
                                        {{ in_array($novel->novel_id ?? $novel->id, $favoriteNovelIds) ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="favorite-btn">Login untuk Favorit</a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <p>Anda belum menambahkan novel apa pun ke favorit Anda</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function filterFavorites() {
            let input = document.getElementById('searchBar').value.toLowerCase();
            let cards = document.getElementsByClassName('card');

            for (let i = 0; i < cards.length; i++) {
                let title = cards[i].getElementsByClassName('card-title')[0].innerText.toLowerCase();
                cards[i].style.display = title.includes(input) ? "" : "none";
            }
        }
    </script>
@endpush