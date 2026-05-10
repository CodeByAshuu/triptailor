<nav
    id="navbar"
    class="landing-navbar dark-mode px-6 py-6 flex items-center relative transition-all duration-300"
>

    <!-- Logo -->
    <div class="flex items-center gap-3">
        <img src="{{ asset('images/favicon.png') }}" 
             alt="TripTailor Logo" 
             class="h-8 w-auto">

        <h1 id="navLogo"
            class="text-2xl text-white font-semibold font-heading transition-colors duration-300">
            triptailor
        </h1>
    </div>

    <!-- Links -->
    <div id="navLinks"
         class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 uppercase font-medium text-sm text-white font-heading flex gap-8 tracking-widest transition-colors duration-300">

        <a href="/dashboard">Dashboard</a>
        <a href="/trips">Trips</a>
        <a href="/explore">Explore</a>

    </div>

</nav>

<a href="/login"
   id="loginBtn"
   class="login-btn dark-mode fixed top-6 right-8 z-50 px-8 py-4 rounded-lg uppercase text-sm font-semibold font-heading tracking-widest transition-all duration-300 shadow-lg">

    Login →

</a>