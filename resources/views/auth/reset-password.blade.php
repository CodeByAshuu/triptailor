@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0f0f10] text-white flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md rounded-3xl border border-white/10 bg-white/5 p-7 shadow-[0_32px_80px_rgba(0,0,0,0.45)] backdrop-blur-2xl">
        <div class="mb-6">
            <h1 class="text-3xl font-extrabold tracking-tight">Create new password</h1>
            <p class="mt-2 text-sm leading-relaxed text-white/45">
                Use at least 8 characters with letters and numbers.
            </p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-xs font-semibold text-white/65">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email', $email) }}" required autofocus
                       class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-white/25 transition focus:border-orange-500/50 focus:bg-white/10 focus:ring-[3px] focus:ring-orange-500/10"
                       placeholder="you@example.com">
                @error('email')<p class="text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="password" class="text-xs font-semibold text-white/65">Password</label>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                       class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-white/25 transition focus:border-orange-500/50 focus:bg-white/10 focus:ring-[3px] focus:ring-orange-500/10"
                       placeholder="Min. 8 characters">
                @error('password')<p class="text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="password_confirmation" class="text-xs font-semibold text-white/65">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                       class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-white/25 transition focus:border-orange-500/50 focus:bg-white/10 focus:ring-[3px] focus:ring-orange-500/10"
                       placeholder="Repeat password">
            </div>

            <button type="submit" class="mt-2 rounded-xl bg-orange-500 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-orange-500/25 transition hover:bg-orange-600">
                Reset password
            </button>
        </form>
    </div>
</div>
@endsection
