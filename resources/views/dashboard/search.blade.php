@extends('layouts.dashboard')

@section('workspace')
<div x-data="searchWorkspace()" class="p-8 min-h-full bg-[#111111] text-zinc-100 font-sans selection:bg-indigo-500/30">
    <div class="mx-auto space-y-8">
        
        <!-- Header / Hero -->
        <div class="border-b border-zinc-800/80 pb-6">
            <h1 class="text-3xl font-bold tracking-tight text-white flex items-center gap-2">
                Global Search
            </h1>
            <p class="text-xs text-zinc-400 mt-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-zinc-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Type keywords, destinations, tags, or notes to instantly retrieve any workspace trip.
            </p>
        </div>

        <!-- Search Bar Card -->
        <div class="bg-[#1A1A1A] border border-zinc-800 focus-within:border-indigo-500/40 rounded-2xl p-2.5 flex items-center shadow-2xl transition duration-300 focus-within:shadow-[0_0_30px_rgba(99,102,241,0.06)] relative z-20 group">
            <svg class="w-5 h-5 ml-3.5 text-zinc-500 group-focus-within:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input 
                type="text" 
                x-model="searchQuery" 
                @input="onSearchInput"
                placeholder="Search trip title, destination, tags, notes..." 
                class="w-full bg-transparent border-none focus:outline-none focus:ring-0 text-base px-3 py-2.5 text-white placeholder:text-zinc-600 font-medium" 
                autofocus
            >
            <!-- Clear button -->
            <button 
                x-show="searchQuery || selectedTag" 
                @click="clearSearch" 
                class="mr-2.5 text-zinc-500 hover:text-white p-1.5 rounded-lg hover:bg-zinc-800 transition"
                x-cloak
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <!-- Main Workspace Area -->
        <div class="relative z-10">

            <!-- 1. LOADING STATE (SKELETONS) -->
            <div x-show="loading" class="space-y-3" x-cloak>
                <template x-for="i in 3" :key="i">
                    <div class="bg-[#1A1A1A]/40 border border-zinc-800/60 rounded-xl p-5 space-y-3 animate-pulse">
                        <div class="flex items-center justify-between">
                            <div class="h-4 bg-zinc-800 rounded w-1/3"></div>
                            <div class="h-4 bg-zinc-800 rounded w-1/12"></div>
                        </div>
                        <div class="h-3 bg-zinc-800 rounded w-1/4"></div>
                        <div class="h-3 bg-zinc-800 rounded w-2/3"></div>
                    </div>
                </template>
            </div>

            <!-- 2. EMPTY STATE (BEFORE TYPING / NO ACTIVE FILTERS) -->
            <div x-show="!searchQuery && !selectedTag && !loading" class="space-y-8">
                
                <!-- Quick Labels / Filter Chips -->
                @if(count($tags) > 0)
                    <div class="space-y-2.5">
                        <h3 class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">Quick Filters</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <button 
                                    type="button" 
                                    @click="selectTag('{{ $tag }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-zinc-200 hover:border-zinc-700 hover:bg-zinc-800 transition cursor-pointer"
                                >
                                    <span class="w-1.5 h-1.5 rounded-full bg-zinc-500"></span>
                                    {{ $tag }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Recent Searches -->
                <div x-show="recentSearches.length > 0" class="space-y-2.5" x-cloak>
                    <div class="flex items-center justify-between">
                        <h3 class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">Recent Searches</h3>
                        <button @click="clearRecentSearches" class="text-[10px] font-semibold text-zinc-600 hover:text-zinc-400 transition cursor-pointer">Clear All</button>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="item in recentSearches" :key="item">
                            <button 
                                type="button" 
                                @click="fillSearch(item)"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-[#1A1A1A] border border-zinc-800/80 text-zinc-400 hover:text-white hover:border-zinc-700 transition cursor-pointer"
                            >
                                <svg class="w-3 h-3 text-zinc-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span x-text="item"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                    <!-- Favorite Trips list -->
                    @if(count($favorites) > 0)
                        <div class="space-y-3">
                            <h3 class="text-[11px] font-bold uppercase tracking-wider text-zinc-500 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-orange-500 fill-orange-500/20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                Favorites
                            </h3>
                            <div class="space-y-2">
                                @foreach($favorites as $fav)
                                    <a href="{{ route('trips.show', $fav->id) }}" class="flex items-center justify-between p-3.5 rounded-xl bg-[#1A1A1A]/50 border border-zinc-800/60 hover:border-zinc-700 hover:bg-[#1A1A1A] transition group">
                                        <div class="truncate pr-4">
                                            <span class="text-sm font-semibold text-white group-hover:text-indigo-400 transition truncate block">{{ $fav->title }}</span>
                                            <span class="text-[11px] text-zinc-500 block mt-0.5">{{ $fav->destination }}</span>
                                        </div>
                                        <span class="text-zinc-600 group-hover:text-white transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Recent Trips list -->
                    @if(count($recent) > 0)
                        <div class="space-y-3">
                            <h3 class="text-[11px] font-bold uppercase tracking-wider text-zinc-500 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-zinc-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Recently Created
                            </h3>
                            <div class="space-y-2">
                                @foreach($recent as $rec)
                                    <a href="{{ route('trips.show', $rec->id) }}" class="flex items-center justify-between p-3.5 rounded-xl bg-[#1A1A1A]/50 border border-zinc-800/60 hover:border-zinc-700 hover:bg-[#1A1A1A] transition group">
                                        <div class="truncate pr-4">
                                            <span class="text-sm font-semibold text-white group-hover:text-indigo-400 transition truncate block">{{ $rec->title }}</span>
                                            <span class="text-[11px] text-zinc-500 block mt-0.5">{{ $rec->destination }}</span>
                                        </div>
                                        <span class="text-zinc-600 group-hover:text-white transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            <!-- 3. SEARCH RESULTS LIST -->
            <div x-show="!loading && (searchQuery || selectedTag)" class="space-y-4" x-cloak>
                
                <!-- Tag Indicator Header -->
                <div x-show="selectedTag" class="flex items-center gap-2 mb-2" x-cloak>
                    <span class="text-xs text-zinc-400">Filtering by label:</span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-indigo-500/10 text-indigo-400 text-[11px] font-bold rounded-full border border-indigo-500/20">
                        <span x-text="selectedTag"></span>
                        <button type="button" @click="selectTag(null)" class="hover:text-white p-0.5 rounded transition cursor-pointer">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </span>
                </div>

                <div class="grid grid-cols-1 gap-3">
                    <template x-for="trip in results" :key="trip.id">
                        <div class="bg-[#1A1A1A] border border-zinc-800 hover:border-zinc-700/80 rounded-xl p-5 shadow-lg hover:shadow-2xl transition duration-300 relative group flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            
                            <div class="space-y-1.5 flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <a :href="trip.url" class="text-base font-semibold text-white hover:text-indigo-400 transition truncate block">
                                        <span x-text="trip.title"></span>
                                    </a>
                                    <template x-if="trip.is_favorite">
                                        <span class="p-0.5 bg-orange-500/10 text-orange-400 rounded border border-orange-500/20">
                                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                        </span>
                                    </template>
                                </div>

                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-zinc-500">
                                    <!-- City -->
                                    <span class="flex items-center gap-1 font-medium text-zinc-400">
                                        <svg class="w-3.5 h-3.5 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span x-text="trip.destination"></span>
                                    </span>
                                    
                                    <!-- Dates -->
                                    <span class="flex items-center gap-1 text-[11px] text-zinc-500">
                                        <svg class="w-3.5 h-3.5 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span x-text="trip.start_date + ' - ' + trip.end_date"></span>
                                    </span>
                                </div>

                                <!-- Note snippet -->
                                <template x-if="trip.notes_snippet">
                                    <p class="text-xs text-zinc-500 italic mt-1 leading-relaxed truncate max-w-xl" x-text="'“' + trip.notes_snippet + '”'"></p>
                                </template>

                                <!-- Tag badges list on search card -->
                                <template x-if="trip.tags.length > 0">
                                    <div class="flex flex-wrap gap-1 mt-2.5">
                                        <template x-for="t in trip.tags" :key="t">
                                            <span 
                                                @click.prevent.stop="selectTag(t)"
                                                class="px-2 py-0.5 rounded bg-zinc-900 border border-zinc-800 text-[10px] text-zinc-400 hover:text-indigo-400 hover:border-indigo-500/20 hover:bg-indigo-500/5 transition cursor-pointer"
                                                x-text="t"
                                            ></span>
                                        </template>
                                    </div>
                                </template>
                            </div>

                            <a :href="trip.url" class="shrink-0 flex items-center justify-center w-9 h-9 rounded-lg bg-zinc-900 border border-zinc-800 text-zinc-500 hover:text-white hover:border-zinc-700 transition shadow">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </div>
                    </template>
                </div>

                <!-- 4. NO RESULTS FOUND STATE -->
                <div x-show="results.length === 0" class="text-center py-16 border border-dashed border-zinc-800 rounded-2xl bg-zinc-950/20" x-cloak>
                    <svg class="mx-auto h-8 w-8 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-semibold text-zinc-400 mt-3">No results found</p>
                    <p class="text-xs text-zinc-600 mt-1">We couldn't find anything matching "<span class="text-zinc-500 font-medium" x-text="searchQuery"></span>" in your trips database.</p>
                </div>

            </div>

        </div>

    </div>
</div>

<script>
if (typeof searchWorkspace !== 'function') {
    window.searchWorkspace = function() {
        return {
            searchQuery: '',
            results: [],
            loading: false,
            selectedTag: null,
            searchTimeout: null,
            recentSearches: [],

            init() {
                // Load recent searches from localstorage
                const saved = localStorage.getItem('triptailor_recent_searches');
                if (saved) {
                    try {
                        this.recentSearches = JSON.parse(saved);
                    } catch (e) {
                        this.recentSearches = [];
                    }
                }
            },

            onSearchInput() {
                clearTimeout(this.searchTimeout);
                
                if (!this.searchQuery && !this.selectedTag) {
                    this.results = [];
                    this.loading = false;
                    return;
                }
                
                this.loading = true;
                
                this.searchTimeout = setTimeout(() => {
                    this.executeSearch();
                }, 300); // 300ms debounce
            },

            async executeSearch() {
                try {
                    const tagParam = this.selectedTag ? `&tag=${encodeURIComponent(this.selectedTag)}` : '';
                    const response = await fetch(`/search/query?q=${encodeURIComponent(this.searchQuery)}${tagParam}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (!response.ok) throw new Error('Search failed');
                    
                    this.results = await response.json();
                    
                    // Save query in recent searches on successful search with results
                    if (this.searchQuery.trim().length > 2 && this.results.length > 0) {
                        this.addRecentSearch(this.searchQuery.trim());
                    }
                } catch (e) {
                    console.error("Search API Error:", e);
                    this.results = [];
                } finally {
                    this.loading = false;
                }
            },

            selectTag(tag) {
                this.selectedTag = tag;
                this.loading = true;
                this.executeSearch();
            },

            fillSearch(term) {
                this.searchQuery = term;
                this.loading = true;
                this.executeSearch();
            },

            addRecentSearch(term) {
                if (this.recentSearches.includes(term)) {
                    // Pull to front
                    this.recentSearches = this.recentSearches.filter(t => t !== term);
                }
                this.recentSearches.unshift(term);
                
                // Cap at 6 searches
                if (this.recentSearches.length > 6) {
                    this.recentSearches = this.recentSearches.slice(0, 6);
                }
                
                localStorage.setItem('triptailor_recent_searches', JSON.stringify(this.recentSearches));
            },

            clearRecentSearches() {
                this.recentSearches = [];
                localStorage.removeItem('triptailor_recent_searches');
            },

            clearSearch() {
                this.searchQuery = '';
                this.selectedTag = null;
                this.results = [];
                this.loading = false;
            }
        };
    };
}
</script>
@endsection
