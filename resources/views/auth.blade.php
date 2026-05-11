<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triptailor</title>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
        }
    </style>
</head>
<body class="bg-[#080D10] min-h-screen overflow-x-hidden">

    <div class="grid min-h-screen grid-cols-1 lg:grid-cols-2">

        <!-- Left Side -->
        <div class="relative bg-[#080D10] text-white flex flex-col overflow-hidden rounded-b-[2rem] lg:rounded-r-[3.5rem] lg:rounded-b-none">
            <div class="pl-5 mx-3 my-6">
                <h2 class="text-4xl lg:text-5xl text-white">Triptailor</h2>
            </div>

            <div class="flex-1 flex items-center justify-center px-6 lg:px-10 py-10">
                <div class="max-w-xl text-center lg:text-left">
                    <p class="text-orange-500 uppercase tracking-[0.3em] text-xs font-semibold mb-4">
                        Travel smarter
                    </p>
                    <h1 class="text-4xl lg:text-6xl font-extrabold leading-tight mb-4">
                        Plan, explore, and tailor every trip.
                    </h1>
                    <p class="text-white/60 text-base lg:text-lg max-w-lg">
                        Build unforgettable journeys with a modern travel experience designed for discovery.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="bg-white h-full min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-10 py-10 overflow-hidden">
            <div class="w-full max-w-md sm:max-w-lg lg:max-w-xl overflow-hidden">
                <div id="auth-slider" class="flex w-[200%] transition-transform duration-700 ease-in-out" style="{{ $errors->register->any() ? 'transform: translateX(-50%)' : '' }}">
                    
                    <!-- Login Panel -->
                    <div class="form-panel w-1/2 flex-shrink-0 p-7 max-[480px]:p-5 ">
                        <div class="form-head mb-5">
                            <h2 class="form-title text-2xl font-extrabold tracking-tighter leading-tight text-gray-900">Welcome back</h2>
                            <p class="form-subtitle mt-1.5 text-sm text-gray-500">Sign in to continue planning your adventures.</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="auth-form flex flex-col gap-4">
                            @csrf

                            <div class="field-group flex flex-col gap-1.5">
                                <label class="field-label text-xs font-semibold text-gray-700" for="login-email">Email address</label>
                                <div class="field-wrap relative flex items-center">
                                    <span class="field-icon absolute left-3.5 flex items-center text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                            <polyline points="22,6 12,13 2,6"/>
                                        </svg>
                                    </span>
                                    <input id="login-email" name="email" type="email" placeholder="you@example.com"
                                           class="field-input w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm outline-none caret-orange-500 placeholder:text-gray-400 focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all"
                                           value="{{ old('email') }}" autocomplete="email" required>
                                </div>
                                @error('email', 'login')<p class="field-error text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="field-group flex flex-col gap-1.5">
                                <div class="field-label-row flex justify-between items-center">
                                    <label class="field-label text-xs font-semibold text-gray-700" for="login-password">Password</label>
                                    <a href="{{ route('password.request') }}" class="forgot-link text-xs text-orange-500 hover:text-orange-600 no-underline transition-colors">Forgot password?</a>
                                </div>
                                <div class="field-wrap relative flex items-center">
                                    <span class="field-icon absolute left-3.5 flex items-center text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                            <path d="M7 11V7a5 5 0 0110 0v4"/>
                                        </svg>
                                    </span>
                                    <input id="login-password" name="password" type="password" placeholder="••••••••"
                                           class="field-input w-full pl-10 pr-11 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm outline-none caret-orange-500 placeholder:text-gray-400 focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all"
                                           autocomplete="current-password" required>
                                    <button type="button" class="field-toggle absolute right-3.5 bg-transparent border-none text-gray-400 hover:text-gray-700 cursor-pointer p-0 flex items-center transition-colors" onclick="togglePwd('login-password',this)">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('password', 'login')<p class="field-error text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="remember-row mt-[-0.2rem]">
                                <label class="checkbox-label flex items-center gap-2.5 text-sm text-gray-600 cursor-pointer select-none">
                                    <div class="relative flex items-center justify-center">
                                        <input type="checkbox" name="remember" class="checkbox-input sr-only peer" {{ old('remember') ? 'checked' : '' }}>
                                        <div class="checkbox-box w-[1.1rem] h-[1.1rem] flex-shrink-0 rounded border-2 border-gray-300 bg-white transition-all peer-checked:bg-orange-500 peer-checked:border-orange-500 peer-focus-visible:ring-2 peer-focus-visible:ring-orange-500/20"></div>
                                        <svg class="absolute w-2.5 h-2.5 text-white scale-0 peer-checked:scale-100 transition-transform pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </div>
                                    Remember me for 30 days
                                </label>
                            </div>

                            <button type="submit" class="submit-btn w-full flex items-center justify-center gap-2 py-3.5 bg-orange-500 text-white font-bold rounded-xl shadow-lg shadow-orange-500/30 hover:bg-orange-600 hover:shadow-xl hover:shadow-orange-500/40 active:scale-98 transition-all mt-2">
                                <span>Sign In</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </form>

                        <p class="switch-prompt text-center mt-4 text-xs text-gray-500">
                            Don't have an account?
                            <button onclick="switchTab('signup')" class="switch-link bg-transparent border-none text-orange-500 font-bold cursor-pointer underline underline-offset-2 hover:text-orange-600">Create one free</button>
                        </p>
                    </div>

                    <!-- Signup Panel -->
                    <div class="form-panel w-1/2 flex-shrink-0 p-7 max-[480px]:p-5">
                        <div class="form-head mb-5">
                            <h2 class="form-title text-2xl font-extrabold tracking-tighter leading-tight text-gray-900">Start your journey</h2>
                            <p class="form-subtitle mt-1.5 text-sm text-gray-500">Create an account and plan your first adventure.</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="auth-form flex flex-col gap-4">
                            @csrf

                            <div class="name-row grid grid-cols-2 gap-3 max-[480px]:grid-cols-1">
                                <div class="field-group flex flex-col gap-1.5">
                                    <label class="field-label text-xs font-semibold text-gray-700" for="reg-first">First name</label>
                                    <div class="field-wrap relative flex items-center">
                                        <span class="field-icon absolute left-3.5 flex items-center text-gray-400 pointer-events-none">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                                                <circle cx="12" cy="7" r="4"/>
                                            </svg>
                                        </span>
                                        <input id="reg-first" name="first_name" type="text" placeholder="Your first name"
                                               class="field-input w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm outline-none caret-orange-500 placeholder:text-gray-400 focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all"
                                               value="{{ old('first_name') }}" required>
                                    </div>
                                    @error('first_name', 'register')<p class="field-error text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-group flex flex-col gap-1.5">
                                    <label class="field-label text-xs font-semibold text-gray-700" for="reg-last">Last name</label>
                                    <div class="field-wrap relative flex items-center">
                                        <input id="reg-last" name="last_name" type="text" placeholder="Your last name"
                                               class="field-input field-input--no-icon w-full pl-4 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm outline-none caret-orange-500 placeholder:text-gray-400 focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all"
                                               value="{{ old('last_name') }}" required>
                                    </div>
                                    @error('last_name', 'register')<p class="field-error text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="field-group flex flex-col gap-1.5">
                                <label class="field-label text-xs font-semibold text-gray-700" for="reg-email">Email address</label>
                                <div class="field-wrap relative flex items-center">
                                    <span class="field-icon absolute left-3.5 flex items-center text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                            <polyline points="22,6 12,13 2,6"/>
                                        </svg>
                                    </span>
                                    <input id="reg-email" name="email" type="email" placeholder="you@example.com"
                                           class="field-input w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm outline-none caret-orange-500 placeholder:text-gray-400 focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all"
                                           value="{{ old('email') }}" required>
                                </div>
                                @error('email', 'register')<p class="field-error text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="field-group flex flex-col gap-1.5">
                                <label class="field-label text-xs font-semibold text-gray-700" for="reg-password">Password</label>
                                <div class="field-wrap relative flex items-center">
                                    <span class="field-icon absolute left-3.5 flex items-center text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                            <path d="M7 11V7a5 5 0 0110 0v4"/>
                                        </svg>
                                    </span>
                                    <input id="reg-password" name="password" type="password" placeholder="Min. 8 characters"
                                           class="field-input w-full pl-10 pr-11 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm outline-none caret-orange-500 placeholder:text-gray-400 focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all"
                                           autocomplete="new-password" required oninput="updateStrength(this.value)">
                                    <button type="button" class="field-toggle absolute right-3.5 bg-transparent border-none text-gray-400 hover:text-gray-700 cursor-pointer p-0 flex items-center transition-colors" onclick="togglePwd('reg-password',this)">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="strength-bar flex gap-1 mt-2">
                                    <div class="strength-seg h-1 flex-1 rounded-full bg-gray-200 transition-colors" id="s1"></div>
                                    <div class="strength-seg h-1 flex-1 rounded-full bg-gray-200 transition-colors" id="s2"></div>
                                    <div class="strength-seg h-1 flex-1 rounded-full bg-gray-200 transition-colors" id="s3"></div>
                                    <div class="strength-seg h-1 flex-1 rounded-full bg-gray-200 transition-colors" id="s4"></div>
                                </div>
                                <p class="strength-label text-xs mt-1 text-gray-400 transition-colors" id="strength-label">Enter a password</p>
                                @error('password', 'register')<p class="field-error text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="field-group flex flex-col gap-1.5">
                                <label class="field-label text-xs font-semibold text-gray-700" for="reg-confirm">Confirm password</label>
                                <div class="field-wrap relative flex items-center">
                                    <span class="field-icon absolute left-3.5 flex items-center text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M9 12l2 2 4-4"/>
                                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                                            <path d="M7 11V7a5 5 0 0110 0v4"/>
                                        </svg>
                                    </span>
                                    <input id="reg-confirm" name="password_confirmation" type="password"
                                           placeholder="Repeat password"
                                           class="field-input w-full pl-10 pr-11 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm outline-none caret-orange-500 placeholder:text-gray-400 focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all"
                                           autocomplete="new-password" required>
                                    <button type="button" class="field-toggle absolute right-3.5 bg-transparent border-none text-gray-400 hover:text-gray-700 cursor-pointer p-0 flex items-center transition-colors" onclick="togglePwd('reg-confirm',this)">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <label class="checkbox-label terms-row flex items-center gap-2.5 text-sm text-gray-600 cursor-pointer select-none mt-1 leading-relaxed">
                                <div class="relative flex items-center justify-center">
                                    <input type="checkbox" name="terms" class="checkbox-input sr-only peer" required>
                                    <div class="checkbox-box w-[1.1rem] h-[1.1rem] flex-shrink-0 rounded border-2 border-gray-300 bg-white transition-all peer-checked:bg-orange-500 peer-checked:border-orange-500 peer-focus-visible:ring-2 peer-focus-visible:ring-orange-500/20"></div>
                                    <svg class="absolute w-2.5 h-2.5 text-white scale-0 peer-checked:scale-100 transition-transform pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span>I agree to the <a href="#" class="text-orange-500 hover:text-orange-600">Terms of Service</a> and <a href="#" class="text-orange-500 hover:text-orange-600">Privacy Policy</a></span>
                            </label>
                            @error('terms', 'register')<p class="field-error text-xs text-red-500 mt-[-0.5rem]">{{ $message }}</p>@enderror

                            <button type="submit" class="submit-btn w-full flex items-center justify-center gap-2 py-3.5 bg-orange-500 text-white font-bold rounded-xl shadow-lg shadow-orange-500/30 hover:bg-orange-600 hover:shadow-xl hover:shadow-orange-500/40 active:scale-98 transition-all mt-2">
                                <span>Create Account</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </form>

                        <p class="switch-prompt text-center mt-4 text-xs text-gray-500">
                            Already have an account?
                            <button onclick="switchTab('login')" class="switch-link bg-transparent border-none text-orange-500 font-bold cursor-pointer underline underline-offset-2 hover:text-orange-600">Sign in</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function togglePwd(id, btn) {
            const input = document.getElementById(id);
            if (!input) return;
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function switchTab(tab) {
            const slider = document.getElementById('auth-slider');
            if (!slider) return;

            slider.style.transform = tab === 'signup'
                ? 'translateX(-50%)'
                : 'translateX(0%)';
        }

        function updateStrength(value) {
            const bars = [
                document.getElementById('s1'),
                document.getElementById('s2'),
                document.getElementById('s3'),
                document.getElementById('s4')
            ];
            const label = document.getElementById('strength-label');
            if (!bars.length || !label) return;

            let score = 0;
            if (value.length >= 1) score = 1;
            if (value.length >= 6) score = 2;
            if (value.length >= 8) score = 3;
            if (value.length >= 12) score = 4;

            bars.forEach((bar, index) => {
                if (!bar) return;
                bar.classList.remove('bg-red-500', 'bg-orange-500', 'bg-yellow-400', 'bg-emerald-500', 'bg-gray-200');
                if (index < score) {
                    if (score <= 1) bar.classList.add('bg-red-500');
                    else if (score === 2) bar.classList.add('bg-orange-500');
                    else if (score === 3) bar.classList.add('bg-yellow-400');
                    else bar.classList.add('bg-emerald-500');
                } else {
                    bar.classList.add('bg-gray-200');
                }
            });

            if (value.length === 0) {
                label.textContent = 'Enter a password';
                label.className = 'strength-label text-xs mt-1 text-gray-400 transition-colors';
            } else if (score <= 1) {
                label.textContent = 'Weak password';
                label.className = 'strength-label text-xs mt-1 text-red-500 transition-colors';
            } else if (score === 2) {
                label.textContent = 'Could be stronger';
                label.className = 'strength-label text-xs mt-1 text-orange-500 transition-colors';
            } else if (score === 3) {
                label.textContent = 'Good password';
                label.className = 'strength-label text-xs mt-1 text-yellow-500 transition-colors';
            } else {
                label.textContent = 'Strong password';
                label.className = 'strength-label text-xs mt-1 text-emerald-500 transition-colors';
            }
        }
    </script>

</body>
</html>