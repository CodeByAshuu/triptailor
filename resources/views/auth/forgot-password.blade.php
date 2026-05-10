@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0f0f10] text-white flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md rounded-3xl border border-white/10 bg-white/5 p-7 shadow-[0_32px_80px_rgba(0,0,0,0.45)] backdrop-blur-2xl">
        <div class="mb-6">
            <h1 class="text-3xl font-extrabold tracking-tight">Reset password</h1>
            <p class="mt-2 text-sm leading-relaxed text-white/45">
                Enter your email and we will send you a secure link to choose a new password.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-xl border border-green-400/20 bg-green-500/10 px-4 py-3 text-sm text-green-200">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-4">
            @csrf

            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-xs font-semibold text-white/65">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                       class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-white/25 transition focus:border-orange-500/50 focus:bg-white/10 focus:ring-[3px] focus:ring-orange-500/10"
                       placeholder="you@example.com">
                @error('email')<p class="text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="mt-2 rounded-xl bg-orange-500 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-orange-500/25 transition hover:bg-orange-600">
                Send reset link
            </button>
        </form>

        <p class="mt-5 text-center text-xs text-white/40">
            Remembered it?
            <a href="{{ route('login') }}" class="font-bold text-orange-400 hover:text-orange-300">Sign in</a>
        </p>
    </div>
</div>
@endsection
