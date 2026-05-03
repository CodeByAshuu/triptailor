<!DOCTYPE html>
<html>
<head>
    <title>TripTailor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg  font-sans">

    <!-- Navbar -->
    <nav class="bg-bg shadow px-6 py-4 flex items-center justify-between">
        <h1 class="text-2xl text-white font-semibold font-heading">
            triptailor
        </h1>

        <div class="uppercase font-medium text-sm text-white font-heading flex gap-8 tracking-widest">
            <a href="/dashboard">Dashboard</a>
            <a href="/trips">Trips</a>
            <a href="/explore">Explore</a>
        </div>

        <a href="/login" class="bg-white hover:bg-orange text-sm text-black hover:text-white px-8 py-4 rounded-lg uppercase font-semibold font-heading tracking-widest">
            Login &rarr;
        </a>

    </nav>

    <!-- Content -->
    <div class="p-6">
        @yield('content')
    </div>

</body>
</html>