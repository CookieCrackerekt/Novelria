<!-- Menu toggle button for mobile screens -->
<div class="menu-toggle">
    <div class="hamburger">
        <span></span>
    </div>
</div>
<!-- Sidebar for mobile screens -->
<aside class="sidebar">
    <h3>Novelria</h3>
    <nav class="menu">
        <a href="{{ route('home') }}" class="menu-item {{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
        <a href="{{ route('novel.index') }}" class="menu-item {{ request()->routeIs('novel.index') ? 'is-active' : '' }}">Library</a>
        <a href="{{ route('favorit.index') }}" class="menu-item {{ request()->routeIs('favorite.index') ? 'is-active' : '' }}">Your Favorite</a>
        <a href="{{ route('your.upload') }}" class="menu-item {{ request()->routeIs('your.upload') ? 'is-active' : '' }}">Your Upload</a>
        <a href="{{ route('frontend.novel.create') }}" class="menu-item {{ request()->routeIs('novel.create') ? 'is-active' : '' }}">Add Novel</a>
        <a href="{{ route('contact') }}" class="menu-item {{ request()->routeIs('contact') ? 'is-active' : '' }}">Contact</a>

        @auth
            <a href="{{ route('logout') }}" class="menu-item"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               Log out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}" class="menu-item">Log in</a>
        @endauth
    </nav>
</aside>

