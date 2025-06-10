@extends('frontend.layouts.authapp')
@section('content')
    @include('frontend.layouts.navbar')
    @include('frontend.layouts.sidebar')

    <div class="login-bg">
        <div class="form-box">
            <br>
            <br>
            <h1>NOVELRIA</h1>
            <div class="logreg-box">
                <div id="logreg-btn"></div>
                <button type="button" class="logreg-toggle-btn" onclick="login()">Log in</button>
                <button type="button" class="logreg-toggle-btn" onclick="register()">Register</button>
            </div>

            {{-- Form Login --}}
            <form method="POST" action="{{ route('login.process') }}" id="login" class="input-group">
                @csrf
                <input type="email" name="email" class="input-field" placeholder="Email" required>
                <input type="password" name="password" class="input-field" placeholder="Password" required>
                <br></br>
                <button type="submit" class="submit-btn">Log in</button>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </form>

            {{-- Form Register --}}
            <form method="POST" action="{{ route('register.process') }}" id="register" class="input-group">
                @csrf
                <input type="text" name="nama" class="input-field" placeholder="Nama Anda" required>
                <input type="text" name="hp" class="input-field" placeholder="Nomor HP" required>
                <input type="email" name="email" class="input-field" placeholder="Email" required>
                <input type="password" name="password" class="input-field" placeholder="Password" required>
                <input type="password" name="password_confirmation" class="input-field" placeholder="Konfirmasi Password"
                    required>
                <br></br>
                <button type="submit" class="submit-btn">Register</button>
                @if (session('status'))
                    <div class="success-message">{{ session('status') }}</div>
                @endif
            </form>
        </div>
    </div>

    <script>
        const x = document.getElementById("login");
        const y = document.getElementById("register");
        const z = document.getElementById("logreg-btn");

        function login() {
            x.style.left = "50px";
            y.style.left = "450px";
            z.style.left = "0px";
        }

        function register() {
            x.style.left = "-400px";
            y.style.left = "50px";
            z.style.left = "110px";
        }
    </script>
@endsection