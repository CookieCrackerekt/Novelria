@extends('frontend.layouts.app')

@section('content')
    @include('frontend.layouts.navbar')
    @include('frontend.layouts.sidebar')
    
    <div class="app">
        <div class="content">
            <h1>Home</h1>
            @if (Auth::check())
                <p style="color: green;">Logged in as: {{ Auth::user()->email }}</p>
            @else
                <p style="color: red;">Not logged in</p>
            @endif
            <p>Silahkan jelajahi beberapa novel yang disediakan</p>
            <br><br>
            <h3>Popular Book!</h3>
            <div class="carousel-container">
                <button class="carousel-btn prev" onclick="moveCarousel(-1)">&#10094;</button>
                <div class="card-carousel">
                    <div class="card-wrapper">
                        @foreach($novels as $novel)
                            <div class="card">
                                <img src="{{ asset($novel->image_path) }}" class="card-img" alt="Card Image" height="345"
                                    width="240" style="border-radius:7%">
                                <div class="card-body">
                                    <h3 class="card-title">{{ $novel->title }}</h3>
                                    <br>
                                    <p class="card-genre">Genre: {{ $novel->genre->genre_name ?? 'Tidak diketahui' }}</p>
                                    @if ($novel->pdf_path)
                                        <a href="{{ asset($novel->pdf_path) }}" class="card-btn" target="_blank">Buka PDF</a>
                                    @endif
                                    <br>
                                    @auth
                                        <form action="{{ route('favorit.toggle') }}" method="POST" class="favorite-form">
                                            @csrf
                                            <input type="hidden" name="novel_id" value="{{ $novel->novel_id ?? $novel->id }}">
                                            <button type="submit" class="favorite-btn">
                                                {{ in_array($novel->novel_id ?? $novel->id, $favoriteNovelIds ?? $favorites) ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="favorite-btn">Login untuk Favorit</a>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button class="carousel-btn next" onclick="moveCarousel(1)">&#10095;</button>
            </div>
        </div>
    </div>

    <script>
        let currentIndex = 0;

        function moveCarousel(direction) {
            const cardCarousel = document.querySelector('.card-carousel');
            const cards = document.querySelectorAll('.card');
            const cardWidth = cards[0].offsetWidth + 20;

            currentIndex += direction;
            const maxIndex = cards.length - Math.floor(cardCarousel.offsetWidth / cardWidth);

            if (currentIndex < 0) currentIndex = 0;
            if (currentIndex > maxIndex) currentIndex = maxIndex;

            cardCarousel.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
        }
    </script>
@endsection