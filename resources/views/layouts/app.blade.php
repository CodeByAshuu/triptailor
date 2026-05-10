<!DOCTYPE html>
<html>
<head>
    <title>TripTailor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-bg font-sans">
    @yield('content')
</body>
</html>