@extends('layouts.dashboard')

@section('workspace')
<div class="p-8 min-h-full bg-[#111111] text-zinc-100 font-sans selection:bg-indigo-500/30">
    <div class="max-w-5xl mx-auto space-y-10">
        
        <!-- Welcome Hero Section -->
        <div class="flex items-center justify-between border-b border-zinc-800/60 pb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Workspace</h1>
                <p class="text-xs text-zinc-400 mt-1">Unified command center for all your upcoming and active travel plans.</p>
            </div>
            
            <div class="flex items-center gap-3 text-xs text-zinc-500 bg-zinc-900 border border-zinc-850 rounded-xl px-4 py-2">
                <span>{{ $totalTrips }} total plans</span>
                <span class="w-1 h-1 rounded-full bg-zinc-700"></span>
                <span>{{ $favoritesCount }} favorites</span>
            </div>
        </div>

        <!-- 1. UP NEXT / HIGHLIGHT SECTION -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xs font-bold uppercase tracking-wider text-zinc-400">Up Next</h2>
                @if($upcomingTrip)
                    <a href="{{ route('filters') }}" class="text-[11px] font-semibold text-zinc-500 hover:text-white transition flex items-center gap-1">
                        View Calendar
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif
            </div>

            @if($upcomingTrip)
                @php
                    $duration = $upcomingTrip->start_date->diffInDays($upcomingTrip->end_date) + 1;
                @endphp
                <div class="group relative bg-[#1A1A1A] border border-zinc-800/80 rounded-2xl p-6 shadow-2xl transition duration-300 hover:border-zinc-700 hover:shadow-[0_0_30px_rgba(249,115,22,0.02)] overflow-hidden">
                    <!-- High-end decorative accent glow -->
                    <div class="absolute right-0 top-0 bottom-0 w-1/3 bg-linear-to-l from-orange-500/5 to-transparent pointer-events-none group-hover:from-orange-500/10 transition duration-500"></div>

                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-3.5">
                            @php
                                $isActive = now()->between($upcomingTrip->start_date, $upcomingTrip->end_date);
                                $isCompleted = now()->greaterThan($upcomingTrip->end_date);
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-lg border shadow-inner {{ $isCompleted ? 'bg-zinc-800/10 text-zinc-500 border-zinc-800/30' : ($isActive ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-orange-500/10 text-orange-400 border-orange-500/20') }}">
                                @if(!$isCompleted)
                                    <span class="w-1.5 h-1.5 rounded-full {{ $isActive ? 'bg-emerald-450' : 'bg-orange-450' }} animate-pulse"></span>
                                @endif
                                
                                @if($daysRemaining === 0)
                                    Starts Today
                                @elseif($daysRemaining === 1)
                                    Starts Tomorrow
                                @elseif($daysRemaining > 1)
                                    In {{ $daysRemaining }} days
                                @elseif($isActive)
                                    Active Now
                                @else
                                    Completed
                                @endif
                            </span>

                            <div class="space-y-1">
                                <h3 class="text-2xl font-bold text-white tracking-tight group-hover:text-indigo-400 transition">{{ $upcomingTrip->title }}</h3>
                                <p class="text-sm text-zinc-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $upcomingTrip->destination }}
                                </p>
                            </div>

                            @if(is_array($upcomingTrip->tags) && count($upcomingTrip->tags) > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach($upcomingTrip->tags as $t)
                                        <span class="px-2 py-0.5 rounded bg-zinc-900 border border-zinc-800 text-[10px] text-zinc-500">
                                            {{ $t }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col items-start md:items-end gap-3.5">
                            <div class="md:text-right space-y-0.5">
                                <p class="text-sm font-semibold text-white">{{ $upcomingTrip->start_date->format('M d') }} - {{ $upcomingTrip->end_date->format('M d, Y') }}</p>
                                <p class="text-xs text-zinc-500">{{ $duration }} day{{ $duration > 1 ? 's' : '' }} planned</p>
                            </div>
                            <a href="{{ route('trips.show', $upcomingTrip->id) }}" class="inline-flex items-center justify-center bg-white text-black hover:bg-zinc-200 px-5 py-2 rounded-lg text-xs font-bold transition active:scale-95 shadow">
                                Open Itinerary
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Pinned Empty State -->
                <div class="border border-dashed border-zinc-850 rounded-2xl p-8 bg-[#1A1A1A]/30 text-center space-y-4">
                    <div class="w-10 h-10 rounded-full bg-zinc-900 border border-zinc-800 flex items-center justify-center mx-auto text-zinc-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-sm font-bold text-zinc-300">No Upcoming Trips</h3>
                        <p class="text-xs text-zinc-500 max-w-sm mx-auto">There are no upcoming travel plans scheduled. Start mapping out your next destination today.</p>
                    </div>
                    <a href="{{ route('trips.create') }}" class="inline-flex items-center gap-1 px-4 py-2 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-lg text-xs font-semibold hover:bg-indigo-500/20 transition">
                        + New Itinerary
                    </a>
                </div>
            @endif
        </section>

        <!-- 2. CONTINUE PLANNING SECTION -->
        <section class="space-y-4">
            <h2 class="text-xs font-bold uppercase tracking-wider text-zinc-400">Continue Planning</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                
                <!-- CTA Create Trip Card -->
                <a href="{{ route('trips.create') }}" class="group bg-transparent border border-dashed border-zinc-800 hover:border-zinc-700/80 hover:bg-[#1A1A1A]/40 rounded-xl transition duration-300 flex flex-col items-center justify-center min-h-58 p-5 gap-3.5 cursor-pointer">
                    <div class="w-10 h-10 rounded-full bg-zinc-900 border border-zinc-850 flex items-center justify-center text-zinc-500 group-hover:text-white group-hover:bg-indigo-500 transition-all duration-300 group-hover:scale-105 shadow">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <div class="text-center space-y-0.5">
                        <span class="block text-sm font-semibold text-zinc-400 group-hover:text-white transition">Create New Trip</span>
                        <span class="block text-[11px] text-zinc-550">Draft an custom itinerary from scratch</span>
                    </div>
                </a>

                <!-- Loop other trips -->
                @forelse($planningTrips as $trip)
                    @php
                        $now = now()->startOfDay();
                        if ($trip->end_date->isPast()) {
                            $status = 'Completed';
                            $statusClass = 'bg-zinc-900/50 text-zinc-500 border-zinc-800/80';
                        } elseif ($trip->start_date->isFuture()) {
                            $status = 'Upcoming';
                            $statusClass = 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20';
                        } else {
                            $status = 'Active';
                            $statusClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                        }
                    @endphp
                    <div class="group bg-[#1A1A1A] border border-zinc-850 rounded-xl hover:border-zinc-700/80 transition-all duration-300 shadow-lg flex flex-col justify-between min-h-58 relative overflow-hidden">
                        
                        <div class="p-5 space-y-4">
                            <!-- Card Header (Dynamic status and Favorite Heart) -->
                            <div class="flex justify-between items-center">
                                <span class="px-2 py-0.5 border text-[10px] font-bold uppercase tracking-wider rounded-md {{ $statusClass }}">
                                    {{ $status }}
                                </span>
                                
                                @if($trip->is_favorite)
                                    <span class="text-orange-400 shadow-[0_0_15px_rgba(249,115,22,0.1)]">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-1">
                                <a href="{{ route('trips.show', $trip->id) }}" class="block text-base font-semibold text-white hover:text-indigo-400 transition truncate max-w-full">
                                    {{ $trip->title }}
                                </a>
                                <p class="text-xs text-zinc-400 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $trip->destination }}
                                </p>
                            </div>

                            <!-- Horizontal tag display -->
                            @if(is_array($trip->tags) && count($trip->tags) > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach(array_slice($trip->tags, 0, 3) as $t)
                                        <span class="px-1.5 py-0.5 rounded bg-zinc-900 border border-zinc-850 text-[9px] font-semibold text-zinc-500">
                                            {{ $t }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Card Footer -->
                        <div class="px-5 py-3.5 border-t border-zinc-900 bg-zinc-900/10 flex items-center justify-between text-[11px] text-zinc-500">
                            <span>Updated {{ $trip->updated_at->diffForHumans() }}</span>
                            <span class="font-medium text-zinc-400">{{ $trip->start_date->format('M d') }} - {{ $trip->end_date->format('M d, Y') }}</span>
                        </div>
                    </div>
                @empty
                    @if(!$upcomingTrip)
                        <div class="col-span-full text-center py-8 border border-dashed border-zinc-850 rounded-xl bg-zinc-900/10 text-xs text-zinc-550">
                            Create your very first itinerary plan to see it indexed here.
                        </div>
                    @endif
                @endforelse

            </div>
        </section>

        <!-- 3. ACTIONS & WORKFLOW SECTIONS -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-12">
            
            <!-- Quick Actions -->
            <div class="bg-[#1A1A1A] border border-zinc-800 rounded-2xl p-6 flex flex-col justify-between">
                <div>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-zinc-450 mb-4">Quick Workspace Actions</h2>
                    <div class="space-y-2">
                        <!-- Action 1: Create -->
                        <a href="{{ route('trips.create') }}" class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-zinc-900 border border-transparent hover:border-zinc-850 transition group">
                            <div class="flex items-center gap-3.5">
                                <div class="w-9 h-9 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-400 group-hover:text-white group-hover:bg-indigo-500/10 group-hover:border-indigo-500/20 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <div class="text-left space-y-0.5">
                                    <p class="text-xs font-bold text-white">Plan Next Journey</p>
                                    <p class="text-[10px] text-zinc-500">Launch the creation module</p>
                                </div>
                            </div>
                            <svg class="w-3.5 h-3.5 text-zinc-600 group-hover:text-zinc-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>

                        <!-- Action 2: Open Search -->
                        <a href="{{ route('search') }}" class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-zinc-900 border border-transparent hover:border-zinc-850 transition group">
                            <div class="flex items-center gap-3.5">
                                <div class="w-9 h-9 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-400 group-hover:text-white group-hover:bg-indigo-500/10 group-hover:border-indigo-500/20 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <div class="text-left space-y-0.5">
                                    <p class="text-xs font-bold text-white">Global Command Search</p>
                                    <p class="text-[10px] text-zinc-500">Search tags, descriptions, destinations</p>
                                </div>
                            </div>
                            <svg class="w-3.5 h-3.5 text-zinc-600 group-hover:text-zinc-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>

                        <!-- Action 3: Labels and Filters -->
                        <a href="{{ route('filters') }}" class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-zinc-900 border border-transparent hover:border-zinc-850 transition group">
                            <div class="flex items-center gap-3.5">
                                <div class="w-9 h-9 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-400 group-hover:text-white group-hover:bg-indigo-500/10 group-hover:border-indigo-500/20 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                </div>
                                <div class="text-left space-y-0.5">
                                    <p class="text-xs font-bold text-white">Manage Tags & Labels</p>
                                    <p class="text-[10px] text-zinc-500">Review dynamic category filters</p>
                                </div>
                            </div>
                            <svg class="w-3.5 h-3.5 text-zinc-600 group-hover:text-zinc-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Get Started Guide Onboarding Card -->
            <div class="bg-[#1A1A1A] border border-zinc-800 rounded-2xl p-6 relative overflow-hidden group flex flex-col justify-between">
                <!-- Soft background accent -->
                <div class="absolute -right-12 -top-12 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition duration-500 pointer-events-none"></div>

                <div class="space-y-4">
                    <div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-zinc-450 mb-1 relative z-10">How to plan a trip</h2>
                        <p class="text-[11px] text-zinc-500 relative z-10">Key milestones for crafting travel itineraries.</p>
                    </div>
                    
                    <div class="space-y-4 relative z-10">
                        <div class="flex gap-3">
                            <div class="w-6 h-6 rounded-full bg-zinc-900 border border-zinc-800 flex items-center justify-center text-[10px] font-bold text-zinc-400 shrink-0">1</div>
                            <div class="space-y-0.5">
                                <p class="text-xs font-semibold text-zinc-200">Create a destination</p>
                                <p class="text-[10px] text-zinc-500 leading-relaxed">Name your journey, add dates, and geocode dynamic current weather.</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-6 h-6 rounded-full bg-zinc-900 border border-zinc-800 flex items-center justify-center text-[10px] font-bold text-zinc-400 shrink-0">2</div>
                            <div class="space-y-0.5">
                                <p class="text-xs font-semibold text-zinc-200">Categorize with tags</p>
                                <p class="text-[10px] text-zinc-500 leading-relaxed">Tag with preset labels like Solo Travel or Relaxation for instant filtering.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-zinc-900 mt-6 flex justify-end relative z-10">
                    <a href="{{ route('get-started') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-xs font-semibold text-zinc-200 hover:text-white rounded-lg transition border border-zinc-700/50">
                        Open Setup Guide
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection
