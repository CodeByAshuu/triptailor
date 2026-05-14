@extends('layouts.dashboard')

@section('workspace')
<div class="p-8 side">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 border-b border-white/5 pb-5">
            <h1 class="text-3xl font-bold text-white tracking-tight">Search</h1>
            <p class="text-white/40 mt-2">Find anything across your trips and activities.</p>
        </div>
        
        <div class="bg-[#1E1E1E] border border-white/5 rounded-2xl p-2 flex items-center">
            <svg class="w-6 h-6 ml-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Search trips, destinations, or friends..." class="w-full bg-transparent border-none focus:ring-0 text-lg px-4 py-3 text-white placeholder:text-white/30" autofocus>
        </div>
        
        <div class="mt-8 text-center text-white/40 py-20">
            <p>Start typing to see results...</p>
        </div>
    </div>
</div>
@endsection
