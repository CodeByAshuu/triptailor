@extends('layouts.app')

@section('content')

<div class="flex h-screen overflow-hidden bg-bg text-white">

    <!-- leftr side bar -->
    <aside class="w-64 shrink-0 border-r border-white/8 flex flex-col overflow-hidden bg-[#0b1114]">

        <!-- brand logo -->
        <div class="px-5 py-5 border-b border-white/8">
            <span class="text-lg font-bold tracking-tight text-white">TripTailor</span>
        </div>

        <!-- side panel nav -->
        <nav class="px-3 py-4 flex flex-col gap-0.5">
            <a href="/dashboard"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white bg-white/8">
                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="/trips/create"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/50 hover:text-white hover:bg-white/5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                New Trip
            </a>
            <a href="/explore"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/50 hover:text-white hover:bg-white/5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><path d="M2 12h20"/></svg>
                Explore
            </a>
        </nav>

        <!-- saved trips, kuch aur ayega yahan -->
        <div class="px-3 mt-2 flex-1 overflow-y-auto">
            <p class="px-3 mb-2 text-xs uppercase tracking-widest text-white/25 font-semibold">Saved Trips</p>

            <div class="flex flex-col gap-1">
                @forelse($trips ?? [] as $trip)
                <a href="/trips/{{ $trip->id }}"
                   class="group flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 transition cursor-pointer">
                    <div class="w-8 h-8 rounded-md overflow-hidden shrink-0 bg-white/10">
                        <div class="w-full h-full bg-linear-to-br from-orange-500/40 to-orange-900/40"></div>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm text-white/80 group-hover:text-white truncate transition">{{ $trip->title }}</p>
                        <p class="text-xs text-white/30 truncate">{{ $trip->location }}</p>
                    </div>
                </a>
                @empty
                <!-- Placeholder skeletons when no trips  -->
                @foreach (['Goa Weekend', 'Manali Trip', 'Kerala Escape'] as $placeholder)
                <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg opacity-30">
                    <div class="w-8 h-8 rounded-md bg-white/10 shrink-0"></div>
                    <div>
                        <p class="text-sm text-white/60">{{ $placeholder }}</p>
                        <p class="text-xs text-white/30">No date set</p>
                    </div>
                </div>
                @endforeach
                @endforelse
            </div>
        </div>

        <!-- user profile  -->
        <div class="px-4 py-4 border-t border-white/8 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center text-xs font-bold text-white shrink-0">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm text-white/80 truncate">{{ auth()->user()->name ?? 'Traveler' }}</p>
                <p class="text-xs text-white/30 truncate">{{ auth()->user()->email ?? '' }}</p>
            </div>
        </div>
    </aside>

    <!-- MAIN AREA -->
    <main class="flex-1 overflow-y-auto">

        <!-- Top bar (search add krna hai after db) -->
        <div class="sticky top-0 z-20 flex items-center justify-between px-8 py-4 border-b border-white/8 backdrop-blur-sm" style="background: rgba(8,13,16,0.85);">
            <div>
                <h1 class="text-lg font-semibold text-white">My Trips</h1>
                <p class="text-sm text-white/35">{{ now()->format('l, d M Y') }}</p>
            </div>
            <a href="/trips/create"
               class="flex items-center gap-2 bg-orange-500 hover:bg-orange-400 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                Create Trip
            </a>
        </div>

        <div class="p-8">

            @if(isset($trips) && $trips->count() > 0)

            <!-- active/upcoming trips grid (complete wale nhi show honge yh toh end pe honge) -->
            <div class="mb-10">
                <p class="text-xs uppercase tracking-widest text-white/30 font-semibold mb-4">Active & Upcoming</p>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($trips->take(3) as $trip)
                    <a href="/trips/{{ $trip->id }}"
                       class="bg-[#0f1a1f] group relative rounded-2xl overflow-hidden border border-white/8 hover:border-white/20 transition-all duration-300 cursor-pointer">

                        <!-- cover page placeholder for trip -->
                        <div class="h-36 w-full relative overflow-hidden"
                             style="background: linear-gradient(135deg, #1a2a30 0%, #0f1a1f 100%);">
                            <div class="absolute inset-0 opacity-20"
                                 style="background: radial-gradient(ellipse at 30% 50%, #FF7A00 0%, transparent 60%);">
                            </div>
                            <div class="absolute bottom-3 left-4">
                                <span class="text-xs bg-white/10 backdrop-blur-sm border border-white/10 text-white/70 px-2.5 py-1 rounded-full">
                                    {{ $trip->activities_count ?? 0 }} activities
                                </span>
                            </div>
                        </div>

                        <div class="p-4">
                            <h3 class="text-white font-semibold text-base mb-0.5 group-hover:text-orange-400 transition">
                                {{ $trip->title }}
                            </h3>
                            <p class="text-sm text-white/40 mb-3">{{ $trip->location }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-white/30">
                                    {{ \Carbon\Carbon::parse($trip->start_date)->format('d M') }}
                                    –
                                    {{ \Carbon\Carbon::parse($trip->end_date)->format('d M Y') }}
                                </span>
                                <span class="text-xs text-white/20 group-hover:text-white/50 transition">View →</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- ALL TRIPS TABLE -->
            @if($trips->count() > 3)
            <div class="border border-white/8 rounded-2xl overflow-hidden bg-[#0f1a1f]">
                <div class="px-6 py-4 border-b border-white/8 flex items-center justify-between">
                    <p class="text-sm font-medium text-white/60">All Trips</p>
                    <span class="text-xs text-white/25">{{ $trips->count() }} total</span>
                </div>
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/5">
                            <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-white/25 font-medium">Trip</th>
                            <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-white/25 font-medium">Destination</th>
                            <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-white/25 font-medium">Dates</th>
                            <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-white/25 font-medium">Activities</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($trips->skip(3) as $trip)
                        <tr class="hover:bg-white/3 transition group">
                            <td class="px-6 py-4 text-sm text-white/80 font-medium">{{ $trip->title }}</td>
                            <td class="px-6 py-4 text-sm text-white/40">{{ $trip->location }}</td>
                            <td class="px-6 py-4 text-sm text-white/40">
                                {{ \Carbon\Carbon::parse($trip->start_date)->format('d M') }}
                                –
                                {{ \Carbon\Carbon::parse($trip->end_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-white/40">{{ $trip->activities_count ?? 0 }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                                    <a href="/trips/{{ $trip->id }}/edit"
                                       class="text-xs text-white/50 hover:text-white px-3 py-1.5 rounded-md border border-white/10 hover:border-white/30 transition">
                                        Edit
                                    </a>
                                    <a href="/trips/{{ $trip->id }}"
                                       class="text-xs text-orange-400 hover:text-orange-300 px-3 py-1.5 rounded-md border border-orange-500/30 hover:border-orange-400 transition">
                                        View →
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            @else

            <!-- EPMTY STATE -->
            <div class="flex flex-col items-center justify-center py-32 text-center">
                <div class="w-16 h-16 rounded-2xl bg-[#0f1a1f] border border-white/10 flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-white/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-white/60 mb-2">No trips yet</h2>
                <p class="text-sm text-white/30 mb-8 max-w-xs">Create your first trip and start building your itinerary.</p>
                <a href="/trips/create"
                   class="bg-orange-500 hover:bg-orange-400 text-white text-sm font-semibold px-6 py-3 rounded-lg transition">
                    Create your first trip
                </a>
            </div>

            @endif

        </div>
    </main>

    <!-- RIGHT PANEL (quick stats) may change ui -->
    <aside class="w-72 shrink-0 border-l border-white/8 overflow-y-auto flex flex-col gap-0 bg-[#0b1114]">

        <div class="p-5 border-b border-white/8">
            <p class="text-xs uppercase tracking-widest text-white/25 font-semibold mb-4">Overview</p>

            {{-- Stats --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-xl p-4 border border-white/8 bg-[#0f1a1f]">
                    <p class="text-2xl font-bold text-white">{{ isset($trips) ? $trips->count() : 0 }}</p>
                    <p class="text-xs text-white/35 mt-0.5">Total Trips</p>
                </div>
                <div class="rounded-xl p-4 border border-white/8 bg-[#0f1a1f]">
                    <p class="text-2xl font-bold text-orange-400">{{ $totalActivities ?? 0 }}</p>
                    <p class="text-xs text-white/35 mt-0.5">Activities</p>
                </div>
                <div class="rounded-xl p-4 border border-white/8 col-span-2 bg-[#0f1a1f]">
                    <p class="text-2xl font-bold text-white">₹{{ number_format($totalBudget ?? 0) }}</p>
                    <p class="text-xs text-white/35 mt-0.5">Estimated Budget</p>
                </div>
            </div>
        </div>

        {{-- Upcoming trip highlight --}}
        @if(isset($nextTrip) && $nextTrip)
        <div class="p-5 border-b border-white/8">
            <p class="text-xs uppercase tracking-widest text-white/25 font-semibold mb-4">Next Trip</p>
            <div class="rounded-xl overflow-hidden border border-white/8 bg-[#0f1a1f]">
                <div class="h-24 relative" style="background: linear-gradient(135deg, #1a2a30 0%, #0f1a1f 100%);">
                    <div class="absolute inset-0 opacity-30" style="background: radial-gradient(ellipse at 30% 50%, #FF7A00 0%, transparent 70%);"></div>
                    <div class="absolute bottom-3 left-4">
                        <span class="text-xs text-white/50 bg-black/30 px-2 py-0.5 rounded-full backdrop-blur-sm">
                            In {{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($nextTrip->start_date)) }} days
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-sm font-semibold text-white mb-0.5">{{ $nextTrip->title }}</p>
                    <p class="text-xs text-white/40 mb-3">{{ $nextTrip->location }}</p>
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-white/30" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        <span class="text-xs text-white/35">
                            {{ \Carbon\Carbon::parse($nextTrip->start_date)->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Quick explore --}}
        <div class="p-5">
            <p class="text-xs uppercase tracking-widest text-white/25 font-semibold mb-4">Popular Templates</p>
            <div class="flex flex-col gap-2">
                @foreach ([
                    ['name' => 'Goa Weekend', 'days' => '3D · 2N', 'tag' => 'Beach'],
                    ['name' => 'Manali Adventure', 'days' => '5D · 4N', 'tag' => 'Mountains'],
                    ['name' => 'Kerala Escape', 'days' => '4D · 3N', 'tag' => 'Nature'],
                ] as $template)
                <a href="/explore"
                   class="flex items-center justify-between px-4 py-3 rounded-xl border border-white/8 hover:border-white/20 hover:bg-white/3 transition group bg-[#0f1a1f]">
                    <div>
                        <p class="text-sm text-white/70 group-hover:text-white transition">{{ $template['name'] }}</p>
                        <p class="text-xs text-white/30">{{ $template['days'] }}</p>
                    </div>
                    <span class="text-xs text-white/25 group-hover:text-orange-400 transition">{{ $template['tag'] }}</span>
                </a>
                @endforeach
            </div>
            <a href="/explore"
               class="mt-4 w-full block text-center text-xs text-white/30 hover:text-white/60 py-3 border border-white/8 rounded-xl hover:border-white/20 transition">
                Browse all templates →
            </a>
        </div>

    </aside>
</div>
@endsection