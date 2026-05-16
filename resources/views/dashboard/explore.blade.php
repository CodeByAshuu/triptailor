@extends('layouts.dashboard')

@section('workspace')
<div class="p-8 side">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 border-b border-white/5 pb-5">
            <h1 class="text-3xl font-bold text-white tracking-tight">Explore Templates</h1>
            <p class="text-white/40 mt-2">Discover curated itineraries from expert travelers.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Dummy Template Card -->
            <div class="bg-[#1E1E1E] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition">
                <div class="w-12 h-12 rounded-xl bg-orange-500/10 text-orange-400 flex items-center justify-center mb-4 border border-orange-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-white/90">Europe Backpacking</h3>
                <p class="text-sm text-white/40 mt-1 mb-4">14 days across 4 countries</p>
                <button class="text-sm font-medium bg-white text-black px-4 py-2 rounded-lg hover:bg-white/90 transition w-full">Use Template</button>
            </div>
            <div class="bg-[#1E1E1E] border border-white/5 rounded-2xl p-6 hover:border-white/10 transition">
                <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center mb-4 border border-blue-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3L22 4"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-white/90">Japan Cherry Blossom</h3>
                <p class="text-sm text-white/40 mt-1 mb-4">10 days in Tokyo & Kyoto</p>
                <button class="text-sm font-medium bg-white text-black px-4 py-2 rounded-lg hover:bg-white/90 transition w-full">Use Template</button>
            </div>
        </div>
    </div>
</div>
@endsection
