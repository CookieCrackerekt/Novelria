@extends('frontend.layouts.app')

@section('content')
    @include('frontend.layouts.navbar')
    @include('frontend.layouts.sidebar')
    
    <div class="app">
        <div class="content">
            <h1>Contact</h1>
            @if (Auth::check())
                <p style="color: green;">Logged in as: {{ Auth::user()->email }}</p>
            @else
                <p style="color: red;">Not logged in</p>
            @endif
            <p>Jika ada masalah hak cipta tolong hubungi kontak dibawah</p>
            <br>
            <div class="card-container">
                <div class="contact-card">
                    <img src="{{ asset('frontend/novelria/images/WA.jpeg') }}" class="card-contact-img" alt="Card Image" style="border-radius:7%">
                    <div class="card-body">
                        <h1 class="card-contact-title" style="font-size: 20px; color:#FFFFFF">Whatsapp</h1>
                        <a href="https://chat.whatsapp.com/K5J0wYxD1BbHQCWZeGsnMi" class="card-btn" target="_blank">Buka Link</a>
                    </div>
                </div> 
                <div class="contact-card">
                    <img src="{{ asset('frontend/novelria/images/GMAIL.jpeg') }}" class="card-contact-img" alt="Card Image" style="border-radius:7%">
                    <div class="card-body">
                        <h1 class="card-contact-title" style="font-size: 20px; color:#FFFFFF">Email</h1>
                        <a href="mailto:karcan2356@gmail.com" class="card-btn" target="_blank">Buka Link</a>
                    </div>
                </div>
                <div class="contact-card">
                    <img src="{{ asset('frontend/novelria/images/IG.jpeg') }}" class="card-contact-img" alt="Card Image" style="border-radius:7%">
                    <div class="card-body">
                        <h1 class="card-contact-title" style="font-size: 20px; color:#FFFFFF">Instagram</h1>
                        <a href="https://instagram.com/n.afkaar_2356?igshid=MTNiYzNiMzkwZA==" class="card-btn" target="_blank">Buka Link</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
