<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in | {{ config('app.name', 'TripTailor') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-gray-900">
    <main class="grid min-h-screen grid-cols-1 lg:grid-cols-2">
        <section class="relative flex min-h-136 flex-col overflow-hidden bg-bg px-6 py-8 text-white lg:min-h-screen lg:px-10">
            <a href="{{ route('home') }}" class="flex w-fit items-center gap-3">
                <img src="{{ asset('images/favicon.png') }}" alt="TripTailor Logo" class="h-8 w-auto">
                <span class="text-2xl font-semibold">triptailor</span>
            </a>

            <div class="flex flex-1 items-center">
                <div class="max-w-xl">
                    <p class="mb-4 text-xs font-semibold uppercase tracking-[0.3em] text-orange-500">Travel smarter</p>
                    <h1 class="mb-5 text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-6xl">
                        Plan, explore, and tailor every trip.
                    </h1>
                    <p class="max-w-lg text-base leading-7 text-white/65 lg:text-lg">
                        Create your account, save trips, and keep every journey organized in one place.
                    </p>
                </div>
            </div>
        </section>

        <section class="flex min-h-screen items-center justify-center px-4 py-10 sm:px-6 lg:px-10">
            <div class="w-full max-w-xl overflow-hidden">
                @if (session('status'))
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="mb-5 grid grid-cols-2 rounded-lg bg-gray-100 p-1">
                    <button type="button" id="login-tab" onclick="switchTab('login')" class="rounded-md px-4 py-2.5 text-sm font-bold transition">
                        Login
                    </button>
                    <button type="button" id="register-tab" onclick="switchTab('register')" class="rounded-md px-4 py-2.5 text-sm font-bold transition">
                        Register
                    </button>
                </div>

                <div id="auth-slider" class="flex w-[200%] transition-transform duration-500 ease-in-out" style="{{ $errors->register->any() ? 'transform: translateX(-50%)' : '' }}">
                    <section class="w-1/2 shrink-0 pr-0">
                        <div class="mb-6">
                            <h2 class="text-3xl font-extrabold tracking-tight">Welcome back</h2>
                            <p class="mt-2 text-sm text-gray-500">Sign in to continue planning your adventures.</p>
                        </div>

                        <form method="POST" action="{{ route('login.store') }}" class="space-y-4" novalidate>
                            @csrf

                            <div>
                                <label for="login-email" class="mb-1.5 block text-xs font-semibold text-gray-700">Email address</label>
                                <input
                                    id="login-email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    required
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10"
                                    placeholder="you@example.com"
                                >
                                @error('email', 'login')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <div class="mb-1.5 flex items-center justify-between gap-3">
                                    <label for="login-password" class="block text-xs font-semibold text-gray-700">Password</label>
                                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-orange-600 hover:text-orange-700">Forgot password?</a>
                                </div>
                                <input
                                    id="login-password"
                                    name="password"
                                    type="password"
                                    autocomplete="current-password"
                                    required
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10"
                                    placeholder="Your password"
                                >
                                @error('password', 'login')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <label class="flex items-center gap-2.5 text-sm text-gray-600">
                                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500" {{ old('remember') ? 'checked' : '' }}>
                                Remember me
                            </label>

                            <button type="submit" class="w-full rounded-lg bg-orange-500 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-orange-500/25 transition hover:bg-orange-600">
                                Sign in
                            </button>
                        </form>
                    </section>

                    <section class="w-1/2 shrink-0 pl-6">
                        <div class="mb-6">
                            <h2 class="text-3xl font-extrabold tracking-tight">Start your journey</h2>
                            <p class="mt-2 text-sm text-gray-500">Create an account and plan your first adventure.</p>
                        </div>

                        <form method="POST" action="{{ route('register.store') }}" class="space-y-4" novalidate>
                            @csrf

                            <div class="grid gap-3 sm:grid-cols-2">
                                <div>
                                    <label for="first-name" class="mb-1.5 block text-xs font-semibold text-gray-700">First name</label>
                                    <input
                                        id="first-name"
                                        name="first_name"
                                        type="text"
                                        value="{{ old('first_name') }}"
                                        autocomplete="given-name"
                                        required
                                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10"
                                    >
                                    @error('first_name', 'register')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="last-name" class="mb-1.5 block text-xs font-semibold text-gray-700">Last name</label>
                                    <input
                                        id="last-name"
                                        name="last_name"
                                        type="text"
                                        value="{{ old('last_name') }}"
                                        autocomplete="family-name"
                                        required
                                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10"
                                    >
                                    @error('last_name', 'register')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="register-email" class="mb-1.5 block text-xs font-semibold text-gray-700">Email address</label>
                                <input
                                    id="register-email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    required
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10"
                                    placeholder="you@example.com"
                                >
                                @error('email', 'register')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="register-password" class="mb-1.5 block text-xs font-semibold text-gray-700">Password</label>
                                <input
                                    id="register-password"
                                    name="password"
                                    type="password"
                                    autocomplete="new-password"
                                    required
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10"
                                    placeholder="At least 8 characters with letters and numbers"
                                >
                                @error('password', 'register')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password-confirmation" class="mb-1.5 block text-xs font-semibold text-gray-700">Confirm password</label>
                                <input
                                    id="password-confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    autocomplete="new-password"
                                    required
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10"
                                >
                            </div>

                            <label class="flex items-start gap-2.5 text-sm leading-6 text-gray-600">
                                <input type="checkbox" name="terms" value="1" required class="mt-1 h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500" {{ old('terms') ? 'checked' : '' }}>
                                <span>I agree to the Terms of Service and Privacy Policy.</span>
                            </label>
                            @error('terms', 'register')
                                <p class="-mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror

                            <button type="submit" class="w-full rounded-lg bg-orange-500 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-orange-500/25 transition hover:bg-orange-600">
                                Create account
                            </button>
                        </form>
                    </section>
                </div>
            </div>
        </section>
    </main>

    <script>
        const hasRegisterErrors = @json($errors->register->any());

        function setButtonState(tab) {
            const loginTab = document.getElementById('login-tab');
            const registerTab = document.getElementById('register-tab');
            const activeClasses = ['bg-white', 'text-gray-950', 'shadow-sm'];
            const inactiveClasses = ['text-gray-500'];

            loginTab.classList.remove(...activeClasses, ...inactiveClasses);
            registerTab.classList.remove(...activeClasses, ...inactiveClasses);

            if (tab === 'register') {
                registerTab.classList.add(...activeClasses);
                loginTab.classList.add(...inactiveClasses);
                return;
            }

            loginTab.classList.add(...activeClasses);
            registerTab.classList.add(...inactiveClasses);
        }

        function switchTab(tab) {
            const slider = document.getElementById('auth-slider');
            slider.style.transform = tab === 'register' ? 'translateX(-50%)' : 'translateX(0)';
            setButtonState(tab);
        }

        switchTab(hasRegisterErrors ? 'register' : 'login');
    </script>
</body>
</html>
