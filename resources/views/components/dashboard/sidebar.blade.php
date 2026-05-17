@props(['trips' => []])

<aside 
    x-show="sidebarOpen" 
    x-transition:enter="transition-transform ease-in-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition-transform ease-in-out duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="w-64 shrink-0 flex flex-col sticky top-0 h-screen bg-[#111111] border-r border-white/5 z-20 overflow-visible"
>
    <!-- App Header -->
    <div class="px-4 py-4 flex items-center justify-between group">
        <div class="flex items-center gap-2.5 cursor-pointer">
            <div class="w-6 h-6 rounded-md bg-orange-500/20 text-orange-400 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </div>
            <span class="text-sm font-semibold tracking-tight text-white/90">TripTailor</span>
        </div>
        <button @click="sidebarOpen = false" class="opacity-0 group-hover:opacity-100 text-white/40 hover:text-white transition p-1 rounded-md hover:bg-white/10" title="Close Sidebar">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" /></svg>
        </button>
    </div>

    <!-- Main Navigation -->
    <nav class="px-3 py-2 flex flex-col gap-0.5">
        <a href="/trips/create" class="group flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-sm font-medium text-orange-400 hover:text-white hover:bg-white/5 transition-all duration-200">
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            <span>New Trip</span>
        </a>
        <a href="/dashboard" class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-sm font-medium text-white hover:bg-white/10 transition" :class="window.location.pathname === '/dashboard' ? 'bg-white/10 text-white' : 'text-white/60 hover:text-white'">
            <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>
        <a href="/explore" class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-sm font-medium transition" :class="window.location.pathname === '/explore' ? 'bg-white/10 text-white' : 'text-white/60 hover:text-white hover:bg-white/5'">
            <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8M8 12h8"/></svg>
            Explore
        </a>
        <a href="/search" class="w-full flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 transition text-left">
            <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Search
        </a>
        <a href="/filters" class="w-full flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 transition text-left">
            <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            Filters & Labels
        </a>
    </nav>

    <!-- Scrollable Lists -->
    <div class="px-3 mt-4 flex-1 overflow-y-auto overflow-x-visible space-y-5 pb-4 sidebar-scroll">
        
        <!-- FAVORITES ACCORDION -->
        <div x-data="{ open: true }" class="group/section">
            <div class="flex items-center justify-between px-2 py-1 mb-0.5">
                <div class="flex items-center gap-1 cursor-pointer w-full text-white/40 hover:text-white/80 transition" @click="open = !open">
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    <span class="text-[11px] font-bold uppercase tracking-wider">Favorites</span>
                </div>
            </div>
            <div x-show="open" x-transition class="space-y-0.5">
                @forelse($trips->where('is_favorite', true) as $trip)
                <a href="/trips/{{ $trip->id }}" class="group flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 transition truncate">
                    <span class="w-2 h-2 rounded-full bg-orange-500/80"></span>
                    <span class="truncate">{{ $trip->title }}</span>
                </a>
                @empty
                <div class="px-2 py-1.5 text-xs text-white/20 italic">No favorites yet</div>
                @endforelse
            </div>
        </div>

        <!-- MY TRIPS ACCORDION -->
        <div x-data="{ open: true }" class="group/section">
            <div class="flex items-center justify-between px-2 py-1 mb-0.5">
                <div class="flex items-center gap-1 cursor-pointer w-full text-white/40 hover:text-white/80 transition" @click="open = !open">
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    <span class="text-[11px] font-bold uppercase tracking-wider">My Trips</span>
                </div>
                
                <!-- Plus Dropdown -->
                <div x-data="{ plusOpen: false }" class="relative" @click.away="plusOpen = false">
                    <button @click="plusOpen = !plusOpen" class="opacity-0 group-hover/section:opacity-100 text-white/40 hover:text-white p-0.5 rounded-md transition hover:bg-white/10">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </button>
                    <div x-show="plusOpen" x-transition x-anchor.right-start="$el.parentElement" class="fixed w-44 bg-[#222222] border border-white/10 rounded-lg shadow-2xl overflow-hidden z-9999 py-1">
                        <a href="/trips/create" class="block w-full text-left px-3 py-1.5 text-sm text-white/70 hover:text-white hover:bg-white/5 transition">Add Trip</a>
                        <a href="/explore" class="block w-full text-left px-3 py-1.5 text-sm text-white/70 hover:text-white hover:bg-white/5 transition">Browse Templates</a>
                    </div>
                </div>
            </div>

            <div x-show="open" x-transition class="space-y-0.5">
                <!-- Get Started -->
                <div class="pt-2">
                    <a href="/get-started" class="w-full flex flex-col items-start gap-0.5 p-3 rounded-lg bg-white/2 border border-dashed border-white/10 hover:border-white/20 hover:bg-white/5 transition text-left group">
                        <span class="text-sm font-medium text-white/80 group-hover:text-white flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-white/40 group-hover:text-white/80 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Get Started
                        </span>
                        <span class="text-xs text-white/40 leading-relaxed">How to create a trip</span>
                    </a>
                </div>
                
                <!-- Iterating trips -->
                @forelse($trips as $trip)
                <div class="group/item flex items-center justify-between px-2 py-1.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 transition relative cursor-pointer" @click.away="activeTripMenu = null">
                    <a href="/trips/{{ $trip->id }}" class="flex items-center gap-2.5 truncate flex-1">
                        <span class="w-2 h-2 rounded-full border border-white/30 group-hover/item:border-white/50"></span>
                        <span class="truncate">{{ $trip->title }}</span>
                    </a>
                    
                    <button @click.stop="activeTripMenu = activeTripMenu === {{ $trip->id }} ? null : {{ $trip->id }}" class="opacity-0 group-hover/item:opacity-100 text-white/40 hover:text-white p-1 rounded-md transition hover:bg-white/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                    </button>

                    <div x-show="activeTripMenu === {{ $trip->id }}" x-transition x-anchor.right-start="$el.parentElement" class="fixed w-44 bg-[#222222] border border-white/10 rounded-lg shadow-2xl overflow-hidden z-9999 py-1">
                        <a href="/trips/{{ $trip->id }}/edit" class="w-full text-left px-3 py-1.5 text-sm text-white/70 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
                            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg> Edit Trip
                        </a>
                        <a href="/trips/{{ $trip->id }}/export-pdf" target="_blank" class="w-full text-left px-3 py-1.5 text-sm text-white/70 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
                            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> Export PDF
                        </a>
                        <form action="/trips/{{ $trip->id }}/toggle-favorite" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-1.5 text-sm text-white/70 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
                                <svg class="w-4 h-4 opacity-70 {{ $trip->is_favorite ? 'text-orange-400 fill-orange-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                {{ $trip->is_favorite ? 'Remove Favorite' : 'Add to Favorites' }}
                            </button>
                        </form>
                        <div class="h-px bg-white/10 my-1"></div>
                        <button 
                            type="button" 
                            @click="$dispatch('open-delete-modal', { id: {{ $trip->id }}, title: {{ json_encode($trip->title) }} })"
                            class="w-full text-left px-3 py-1.5 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition flex items-center gap-2"
                        >
                            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg> Delete Trip
                        </button>
                    </div>
                </div>
                @empty
                <div class="px-2 py-3 text-center rounded-lg border border-dashed border-white/5 bg-white/2">
                    <p class="text-xs text-white/40">No trips yet</p>
                    <a href="/trips/create" class="mt-2 inline-flex items-center gap-1 text-[11px] font-medium text-orange-400 hover:text-orange-300 transition">
                        Create Trip
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- BOTTOM USER SECTION -->
    <div class="p-3 border-t border-white/5">
        <div x-data="{ userMenuOpen: false }" class="relative" @click.away="userMenuOpen = false">
            <button @click="userMenuOpen = !userMenuOpen" class="w-full flex items-center gap-3 px-2 py-2 rounded-lg hover:bg-white/5 transition">
                <div class="w-8 h-8 rounded-lg bg-linear-to-tr from-orange-600 to-orange-400 flex items-center justify-center text-xs font-bold text-white shadow-inner shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1 text-left">
                    <p class="text-sm text-white/90 font-medium truncate">{{ auth()->user()->name ?? 'Alex Traveler' }}</p>
                    <p class="text-xs text-white/40 truncate">{{ auth()->user()->email ?? 'alex@example.com' }}</p>
                </div>
                <svg class="w-4 h-4 text-white/30 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/></svg>
            </button>

            <div x-show="userMenuOpen" x-transition class="absolute bottom-full left-0 mb-2 w-full bg-[#222222] border border-white/10 rounded-lg shadow-xl overflow-hidden z-50 py-1">
                <button class="w-full text-left px-3 py-2 text-sm text-white/70 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
                    <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Settings
                </button>
                <div class="h-px bg-white/10 my-1"></div>
                <form method="POST" action="/logout" class="w-full m-0">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-white/70 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg> Log out
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
