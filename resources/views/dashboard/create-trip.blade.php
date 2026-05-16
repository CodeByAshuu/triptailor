@extends('layouts.dashboard')

@section('workspace')
<div class="p-8 side">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8 border-b border-white/5 pb-5 flex items-center gap-4">
            <a href="/dashboard" class="text-white/40 hover:text-white transition p-2 rounded-lg hover:bg-white/5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Create New Trip</h1>
                <p class="text-white/40 mt-2">Set up your next great adventure.</p>
            </div>
        </div>
        
        <form class="space-y-6 bg-[#1E1E1E] border border-white/5 rounded-2xl p-8">
            <div class="space-y-2">
                <label class="text-sm font-medium text-white/70">Destination</label>
                <input type="text" placeholder="Where to?" class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition placeholder:text-white/30">
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-white/70">Start Date</label>
                    <input type="date" class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-white/60 focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition scheme:dark">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-white/70">End Date</label>
                    <input type="date" class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-white/60 focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition scheme:dark">
                </div>
            </div>

            <div class="pt-4 border-t border-white/5 flex justify-end gap-3">
                <a href="/dashboard" class="px-5 py-2.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 transition">Cancel</a>
                <button type="button" class="px-6 py-2.5 rounded-lg text-sm font-medium bg-orange-500 text-white hover:bg-orange-600 transition shadow-lg shadow-orange-500/20 active:scale-95">Create Trip</button>
            </div>
        </form>
    </div>
</div>
@endsection
