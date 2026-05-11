<nav
    id="navbar"
    class="landing-navbar dark-mode px-6 py-6 flex items-center relative transition-all duration-300"
>
    <a href="{{ route('home') }}" class="flex items-center gap-3">
        <img src="{{ asset('images/favicon.png') }}"
             alt="TripTailor Logo"
             class="h-8 w-auto">

        <h1 id="navLogo"
            class="text-2xl text-white font-semibold font-heading transition-colors duration-300">
            triptailor
        </h1>
    </a>

    <div id="navLinks"
         class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 uppercase font-medium text-sm text-white font-heading flex gap-8 tracking-widest transition-colors duration-300">
        @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('trips.index') }}">Trips</a>
        @else
            <a href="{{ route('login') }}">Dashboard</a>
            <a href="{{ route('login') }}">Trips</a>
        @endauth

        <a href="{{ route('explore') }}">Explore</a>
    </div>
</nav>

<div class="fixed top-6 right-8 z-50">
    @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    id="loginBtn"
                    class="login-btn dark-mode px-8 py-4 rounded-lg uppercase text-sm font-semibold font-heading tracking-widest transition-all duration-300 shadow-lg">
                Logout ->
            </button>
        </form>
    @else
        <a href="{{ route('login') }}"
           id="loginBtn"
           class="login-btn dark-mode px-8 py-4 rounded-lg uppercase text-sm font-semibold font-heading tracking-widest transition-all duration-300 shadow-lg">
            Login ->
        </a>
    @endauth
</div>
