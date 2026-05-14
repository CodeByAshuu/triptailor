@extends('layouts.app')

@section('content')
<!-- multiple menu eksath open ho rhe the (fixed now: x-data="{ sidebarOpen: true, activeTripMenu: null}") -->
<div x-data="{ sidebarOpen: true, activeTripMenu: null}" class="flex min-h-screen bg-[#1A1A1A] text-white font-sans antialiased selection:bg-orange-500/30">

    <!-- LEFT SIDEBAR PANEL (action menu fix krna hai) -->
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
            <a href="/trips/create"
            class="group flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-sm font-medium text-orange-400 hover:text-white hover:bg-white/5 transition-all duration-200">

                <!-- Plus Icon -->
                <svg 
                    class="w-4 h-4 transition-transform duration-200 group-hover:rotate-90"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <path d="M12 5v14M5 12h14"/>
                </svg>
                <span>New Trip</span>
            </a>
            <a href="/dashboard" class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-sm font-medium text-white bg-white/10">
                <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="/explore" class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 transition">
                <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8M8 12h8"/></svg>
                Explore
            </a>
            <button class="w-full flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 transition text-left">
                <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Search
            </button>
            <button class="w-full flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 transition text-left">
                <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                Filters & Labels
            </button>
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
                    <a href="#" class="group flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 transition">
                        <span class="w-2 h-2 rounded-full bg-orange-500/80"></span>
                        Bali Honeymoon
                    </a>
                    <a href="#" class="group flex items-center gap-2.5 px-2 py-1.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 transition">
                        <span class="w-2 h-2 rounded-full bg-blue-500/80"></span>
                        Swiss Alps
                    </a>
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
                    <!-- Iterating trips -->
                    @forelse($trips ?? [1,2,3] as $trip)
                    <div class="group/item flex items-center justify-between px-2 py-1.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 transition relative cursor-pointer" @click.away="activeTripMenu = null">
                        <a href="/trips/{{ is_object($trip) ? $trip->id : $trip }}" class="flex items-center gap-2.5 truncate flex-1">
                            <span class="w-2 h-2 rounded-full border border-white/30 group-hover/item:border-white/50"></span>
                            <span class="truncate">{{ is_object($trip) ? $trip->title : 'My Awesome Trip ' . $trip }}</span>
                        </a>
                        
                        <button @click.stop="activeTripMenu = activeTripMenu === {{ is_object($trip) ? $trip->id : $trip }} ? null : {{ is_object($trip) ? $trip->id : $trip }}"
                        class="opacity-0 group-hover/item:opacity-100 text-white/40 hover:text-white p-1 rounded-md transition hover:bg-white/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                        </button>

                        <div
                            x-show="activeTripMenu === {{ is_object($trip) ? $trip->id : $trip }}"
                            x-transition
                            x-anchor.right-start="$el.parentElement"
                            class="fixed w-44 bg-[#222222] border border-white/10 rounded-lg shadow-2xl overflow-hidden z-9999 py-1"
                        >
                            <a href="/trips/{{ is_object($trip) ? $trip->id : $trip }}/edit" class="w-full text-left px-3 py-1.5 text-sm text-white/70 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
                                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg> Edit Trip
                            </a>
                            <button class="w-full text-left px-3 py-1.5 text-sm text-white/70 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
                                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> Export PDF
                            </button>
                            <button class="w-full text-left px-3 py-1.5 text-sm text-white/70 hover:text-white hover:bg-white/5 transition flex items-center gap-2">
                                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg> Add to Favorites
                            </button>
                            <div class="h-px bg-white/10 my-1"></div>
                            <button class="w-full text-left px-3 py-1.5 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition flex items-center gap-2">
                                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg> Delete Trip
                            </button>
                        </div>
                    </div>
                    @empty
                    @endforelse
                    
                    <!-- Get Started -->
                    <div class="pt-2">
                        <button class="w-full flex flex-col items-start gap-0.5 p-3 rounded-lg bg-white/2 border border-dashed border-white/10 hover:border-white/20 hover:bg-white/5 transition text-left group">
                            <span class="text-sm font-medium text-white/80 group-hover:text-white flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-white/40 group-hover:text-white/80 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                Get Started
                            </span>
                            <span class="text-xs text-white/40 leading-relaxed">How to create a trip</span>
                        </button>
                    </div>
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

    <!-- RIGHT MAIN WORKSPACE -->
    <main class="flex-1 min-h-screen flex flex-col relative min-w-0 bg-[#1A1A1A]">
        
        <!-- Header -->
        <header class="flex items-center justify-between px-8 py-4 border-b border-white/5 shrink-0 bg-[#1A1A1A]/80 backdrop-blur-md sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" x-show="!sidebarOpen" class="text-white/40 hover:text-white transition p-1.5 rounded-lg hover:bg-white/10 -ml-2" title="Open Sidebar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                <div>
                    <h1 class="text-xl font-semibold text-white/90 tracking-tight">Welcome back, {{ explode(' ', auth()->user()->name ?? 'Alex')[0] }}</h1>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative group hidden sm:block">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-white/30 group-focus-within:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Search anything..." class="bg-white/5 border border-white/10 rounded-lg py-1.5 pl-9 pr-4 text-sm text-white focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 w-64 transition placeholder:text-white/30 hover:bg-white/10">
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 p-8 side">
            <div class="max-w-5xl mx-auto space-y-12">
                
                <!-- Upcoming Trip Highlight (Like a pinned task/project) -->
                <section>
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-lg font-semibold text-white/90 tracking-tight">Up Next</h2>
                        <button class="text-sm font-medium text-white/40 hover:text-white transition flex items-center gap-1.5 bg-white/5 hover:bg-white/10 px-3 py-1.5 rounded-lg">
                            Calendar <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </button>
                    </div>

                    <div class="group relative bg-[#222222] border border-white/5 rounded-2xl p-1 overflow-hidden transition-all hover:border-white/10 hover:shadow-2xl hover:shadow-orange-500/5">
                        <div class="relative bg-[#1E1E1E] border border-white/5 rounded-xl p-8 flex flex-col md:flex-row items-start md:items-center justify-between overflow-hidden gap-6">
                            <!-- Background accent -->
                            <div class="absolute right-0 top-0 bottom-0 w-1/2 bg-linear-to-l from-orange-500/10 to-transparent opacity-50 pointer-events-none"></div>

                            <div class="relative z-10 flex flex-col gap-3">
                                <span class="inline-flex w-fit items-center gap-1.5 px-3 py-1 bg-orange-500/10 text-orange-400 text-xs font-bold uppercase tracking-wider rounded-lg border border-orange-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span>
                                    In 12 days
                                </span>
                                <div>
                                    <h3 class="text-3xl font-bold text-white tracking-tight">Kyoto Autumn Leaves</h3>
                                    <p class="text-white/50 text-base mt-1 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        Kyoto, Japan
                                    </p>
                                </div>
                            </div>
                            
                            <div class="relative z-10 flex flex-col items-start md:items-end gap-4 w-full md:w-auto">
                                <div class="text-left md:text-right">
                                    <p class="text-lg font-semibold text-white/90">Nov 15 - Nov 24</p>
                                    <p class="text-sm text-white/40 mt-0.5">9 days • 4 companions</p>
                                </div>
                                <button class="bg-white text-black hover:bg-gray-200 px-6 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm active:scale-95 w-full md:w-auto">
                                    Open Itinerary
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Activity Cards / Continue Planning -->
                <section>
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-lg font-semibold text-white/90 tracking-tight">Continue Planning</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <!-- Create New Card -->
                        <a href="/trips/create" class="group bg-transparent border-2 border-dashed border-white/10 hover:border-white/20 hover:bg-white/5 rounded-2xl transition-all duration-300 flex flex-col items-center justify-center h-56 gap-4">
                            <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center text-white/40 group-hover:text-white group-hover:bg-orange-500 transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-orange-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <div class="text-center">
                                <span class="block text-base font-medium text-white/60 group-hover:text-white transition">Create New Trip</span>
                                <span class="block text-xs text-white/30 mt-1">Start from scratch or a template</span>
                            </div>
                        </a>
                        <!-- Card 1 -->
                        <div class="group bg-[#1E1E1E] border border-white/5 rounded-2xl hover:border-white/10 transition-all duration-300 cursor-pointer overflow-hidden flex flex-col h-56 hover:-translate-y-1 hover:shadow-xl hover:shadow-black/50">
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center border border-blue-500/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                                    </div>
                                    <button class="text-white/20 hover:text-white transition opacity-0 group-hover:opacity-100 p-1 hover:bg-white/10 rounded-md">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                                    </button>
                                </div>
                                <h3 class="text-base font-semibold text-white/90 mb-1">Swiss Alps Ski Trip</h3>
                                <p class="text-sm text-white/40 flex-1">Zermatt, Switzerland</p>
                                
                                <div class="mt-4 flex items-center gap-2">
                                    <div class="flex -space-x-2">
                                        <div class="w-6 h-6 rounded-full bg-white/20 border-2 border-[#1E1E1E]"></div>
                                        <div class="w-6 h-6 rounded-full bg-white/30 border-2 border-[#1E1E1E]"></div>
                                    </div>
                                    <span class="text-xs font-medium text-white/30">+2</span>
                                </div>
                            </div>
                            <div class="px-5 py-3 border-t border-white/5 bg-white/2 flex items-center justify-between">
                                <span class="text-xs text-white/40">Edited 2 hrs ago</span>
                                <span class="text-[11px] font-bold uppercase tracking-wider text-white/60 bg-white/5 px-2 py-1 rounded-md border border-white/10">Draft</span>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="group bg-[#1E1E1E] border border-white/5 rounded-2xl hover:border-white/10 transition-all duration-300 cursor-pointer overflow-hidden flex flex-col h-56 hover:-translate-y-1 hover:shadow-xl hover:shadow-black/50">
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-green-500/10 text-green-400 flex items-center justify-center border border-green-500/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    </div>
                                    <button class="text-white/20 hover:text-white transition opacity-0 group-hover:opacity-100 p-1 hover:bg-white/10 rounded-md">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                                    </button>
                                </div>
                                <h3 class="text-base font-semibold text-white/90 mb-1">Bali Honeymoon</h3>
                                <p class="text-sm text-white/40 flex-1">Ubud, Indonesia</p>

                                <div class="mt-4 w-full bg-white/5 rounded-full h-1.5">
                                    <div class="bg-green-400 h-1.5 rounded-full w-3/4"></div>
                                </div>
                            </div>
                            <div class="px-5 py-3 border-t border-white/5 bg-white/2 flex items-center justify-between">
                                <span class="text-xs text-white/40">Dec 1 - Dec 10</span>
                                <span class="text-[11px] font-bold uppercase tracking-wider text-green-400 bg-green-400/10 px-2 py-1 rounded-md border border-green-400/20">Planned</span>
                            </div>
                        </div>

                        
                    </div>
                </section>

                <!-- Helper Section / Bottom Area -->
                <section class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-10">
                    <!-- Quick Actions -->
                    <div class="bg-[#1E1E1E] border border-white/5 rounded-2xl p-6">
                        <h2 class="text-sm font-semibold text-white/60 uppercase tracking-wider mb-4">Quick Actions</h2>
                        <div class="space-y-2">
                            <button class="w-full flex items-center justify-between p-3.5 rounded-xl hover:bg-white/5 border border-transparent hover:border-white/5 transition group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-white/50 group-hover:text-white group-hover:bg-white/10 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-sm font-medium text-white/90">Import Booking</p>
                                        <p class="text-xs text-white/40 mt-0.5">Upload PDF or forward email</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-white/20 group-hover:text-white/50 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                            <button class="w-full flex items-center justify-between p-3.5 rounded-xl hover:bg-white/5 border border-transparent hover:border-white/5 transition group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-white/50 group-hover:text-white group-hover:bg-white/10 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-sm font-medium text-white/90">Invite Friends</p>
                                        <p class="text-xs text-white/40 mt-0.5">Collaborate on your itineraries</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-white/20 group-hover:text-white/50 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Get Started Guide -->
                    <div class="bg-[#1E1E1E] border border-white/5 rounded-2xl p-6 relative overflow-hidden group">
                        <div class="absolute -right-10 -top-10 w-48 h-48 bg-orange-500/10 rounded-full blur-3xl group-hover:bg-orange-500/20 transition duration-500 pointer-events-none"></div>
                        <h2 class="text-sm font-semibold text-white/60 uppercase tracking-wider mb-2 relative z-10">How to plan a trip</h2>
                        <p class="text-sm text-white/40 mb-6 relative z-10">Follow these steps to craft the perfect journey.</p>
                        
                        <div class="space-y-5 relative z-10">
                            <div class="flex gap-4">
                                <div class="w-7 h-7 rounded-full bg-white/10 border border-white/5 flex items-center justify-center text-xs font-bold text-white shrink-0">1</div>
                                <div>
                                    <p class="text-sm font-semibold text-white/90">Create a destination</p>
                                    <p class="text-xs text-white/40 mt-1 leading-relaxed">Start by picking where you want to go and exploring templates.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-7 h-7 rounded-full bg-white/5 border border-white/5 flex items-center justify-center text-xs font-bold text-white/50 shrink-0">2</div>
                                <div>
                                    <p class="text-sm font-semibold text-white/50">Add dates & companions</p>
                                    <p class="text-xs text-white/30 mt-1 leading-relaxed">Set the timeframe and invite friends to collaborate.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-7 h-7 rounded-full bg-white/5 border border-white/5 flex items-center justify-center text-xs font-bold text-white/50 shrink-0">3</div>
                                <div>
                                    <p class="text-sm font-semibold text-white/50">Build itinerary</p>
                                    <p class="text-xs text-white/30 mt-1 leading-relaxed">Add flights, hotels, and activities to your daily schedule.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>

    </main>

</div>
@endsection