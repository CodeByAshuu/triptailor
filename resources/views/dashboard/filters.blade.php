@extends('layouts.dashboard')

@section('workspace')
<div class="p-8 min-h-full bg-[#111111] text-zinc-100">
    <div class="mx-auto space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-zinc-800/80 pb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Filters & Labels</h1>
                <p class="text-xs text-zinc-400 mt-1.5">Organize your trips with custom labels and smart workspace filters.</p>
            </div>
            
            @if($selectedTag)
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('filters') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-zinc-800 hover:bg-zinc-700 text-xs font-semibold text-zinc-200 hover:text-white rounded-lg transition border border-zinc-700/50">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Clear Filter
                    </a>
                </div>
            @endif
        </div>

        <!-- Labels Accordion/Selection Card -->
        <div class="bg-[#1A1A1A]/80 border border-zinc-800 rounded-2xl p-6 shadow-xl relative overflow-hidden group">
            <!-- Glassmorphic lighting glow -->
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-all duration-500 pointer-events-none"></div>

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-400">Filter by Label</h3>
                <span class="text-[10px] text-zinc-500">{{ count($tags) }} dynamic labels found</span>
            </div>

            <div class="flex flex-wrap gap-2">
                <!-- Preset Labels that actually exist in the database -->
                @forelse($tags as $tag)
                    @php
                        $isSelected = ($selectedTag === $tag);
                    @endphp
                    <a 
                        href="{{ $isSelected ? route('filters') : route('filters', ['tag' => $tag]) }}" 
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg border transition duration-200 {{ $isSelected 
                            ? 'bg-indigo-500/10 text-indigo-400 border-indigo-500/40 shadow-[0_0_15px_rgba(99,102,241,0.1)]' 
                            : 'bg-zinc-900 border-zinc-800 text-zinc-400 hover:text-zinc-200 hover:border-zinc-700 hover:bg-zinc-800' }}"
                    >
                        <span class="w-1.5 h-1.5 rounded-full {{ $isSelected ? 'bg-indigo-400' : 'bg-zinc-500' }}"></span>
                        {{ $tag }}
                        @if($isSelected)
                            <svg class="w-3 h-3 text-indigo-400/80 hover:text-indigo-400 ml-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        @endif
                    </a>
                @empty
                    <div class="w-full text-center py-6 border border-dashed border-zinc-800 rounded-xl bg-zinc-900/30">
                        <p class="text-xs text-zinc-500">No active labels found on any of your trips.</p>
                        <a href="{{ route('trips.create') }}" class="mt-2 inline-flex items-center gap-1 text-[11px] font-medium text-orange-400 hover:text-orange-300 transition">
                            Create a Trip to add labels
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Trips Display Grid -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    @if($selectedTag)
                        Matching Trips
                        <span class="px-2 py-0.5 bg-indigo-500/10 text-indigo-400 text-[11px] font-bold rounded-full border border-indigo-500/20">
                            {{ $selectedTag }}
                        </span>
                    @else
                        All Trips
                    @endif
                </h2>
                <span class="text-xs text-zinc-500">{{ $trips->count() }} trips matching</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($trips as $trip)
                    <div class="bg-[#1A1A1A] border border-zinc-800 hover:border-zinc-700/80 rounded-xl p-5 shadow-lg hover:shadow-2xl transition duration-300 relative group flex flex-col justify-between min-h-44">
                        
                        <!-- Top details -->
                        <div>
                            <div class="flex items-start justify-between">
                                <a href="{{ route('trips.show', $trip->id) }}" class="text-base font-semibold text-white hover:text-indigo-400 transition truncate max-w-[80%]">
                                    {{ $trip->title }}
                                </a>
                                @if($trip->is_favorite)
                                    <span class="p-1 bg-orange-500/10 text-orange-400 rounded-md border border-orange-500/20">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                    </span>
                                @endif
                            </div>

                            <!-- Destination city with pin -->
                            <div class="flex items-center gap-1.5 text-zinc-400 mt-2 text-xs">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 text-zinc-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                {{ $trip->destination }}
                            </div>

                            <!-- Dates and Budget -->
                            <div class="flex items-center gap-4 mt-3.5 text-[11px] text-zinc-500 border-t border-zinc-900 pt-3">
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>{{ $trip->start_date->format('M d') }} - {{ $trip->end_date->format('M d, Y') }}</span>
                                </div>
                                @if($trip->budget)
                                    <div class="flex items-center gap-1">
                                        <span class="text-zinc-600 font-bold">₹</span>
                                        <span>{{ number_format($trip->budget, 2) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Labels Chips list on trip card -->
                        @if(is_array($trip->tags) && count($trip->tags) > 0)
                            <div class="flex flex-wrap gap-1 mt-4">
                                @foreach($trip->tags as $t)
                                    <a 
                                        href="{{ route('filters', ['tag' => $t]) }}" 
                                        class="px-2 py-0.5 rounded bg-zinc-900 border border-zinc-800 text-[10px] text-zinc-400 hover:text-indigo-400 hover:border-indigo-500/20 hover:bg-indigo-500/5 transition"
                                    >
                                        {{ $t }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 border border-dashed border-zinc-800 rounded-2xl bg-zinc-950/20">
                        <svg class="mx-auto h-8 w-8 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <p class="text-sm font-semibold text-zinc-400 mt-3">No matching trips found</p>
                        @if($selectedTag)
                            <p class="text-xs text-zinc-600 mt-1">There are no trips matching the label "{{ $selectedTag }}".</p>
                            <div class="mt-4 flex items-center justify-center gap-3">
                                <a href="{{ route('filters') }}" class="text-xs text-zinc-400 hover:text-white transition">Clear filter</a>
                            </div>
                        @else
                            <p class="text-xs text-zinc-600 mt-1">Get started by creating your very first trip plan.</p>
                            <a href="{{ route('trips.create') }}" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-500 hover:bg-indigo-400 text-xs font-semibold text-white rounded-lg transition shadow-md shadow-indigo-500/10">
                                Create a Trip
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
