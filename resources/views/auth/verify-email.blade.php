@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0f0f10] text-white flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md rounded-3xl border border-white/10 bg-white/5 p-7 shadow-[0_32px_80px_rgba(0,0,0,0.45)] backdrop-blur-2xl">
        <div class="mb-6">
            <h1 class="text-3xl font-extrabold tracking-tight">Verify your email</h1>
            <p class="mt-2 text-sm leading-relaxed text-white/45">
                We sent a verification link to {{ auth()->user()->email }}. Verify your email before opening your dashboard.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-xl border border-green-400/20 bg-green-500/10 px-4 py-3 text-sm text-green-200">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex flex-col gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full rounded-xl bg-orange-500 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-orange-500/25 transition hover:bg-orange-600">
                    Resend verification email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-xl border border-white/10 bg-white/5 px-5 py-3.5 text-sm font-bold text-white/75 transition hover:bg-white/10 hover:text-white">
                    Log out
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
