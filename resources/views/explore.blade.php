@extends('layouts.dashboard')

@section('workspace')
<div
    x-data="explorePage(@js($exploreItems), @js($fallbackImage))"
    class="min-h-screen overflow-x-hidden bg-[#0f0f10] text-white"
>
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">

        {{-- Hero Title + Search --}}
        <div class="mt-6 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-start gap-4">
                <div class="mt-1 h-18 w-1.5 shrink-0 rounded-full bg-orange-500"></div>
                <h1 class="text-5xl font-black uppercase leading-none tracking-tight sm:text-6xl lg:text-7xl">
                    Plan Your<br>Next Trip
                </h1>
            </div>

            <div class="w-full lg:max-w-lg">
                <label class="flex cursor-text items-center gap-3 rounded-2xl border border-white/10 bg-white/5
                              px-5 py-3.5 ring-1 ring-transparent transition
                              focus-within:border-orange-500/40 focus-within:ring-orange-500/15">
                    <svg class="h-5 w-5 shrink-0 text-white/35" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/>
                    </svg>
                    <input
                        type="text"
                        placeholder="Where we go?"
                        x-model.debounce.200ms="query"
                        class="min-w-0 flex-1 bg-transparent text-sm text-white placeholder:text-white/35 focus:outline-none"
                    >
                    <button type="button" class="shrink-0 rounded-xl border border-white/10 bg-white/8 p-2 transition hover:bg-white/15">
                        <svg class="h-4 w-4 text-white/55" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </button>
                </label>
            </div>
        </div>

        {{-- Main 3-column Grid --}}
        <div class="mt-6 grid gap-5 md:grid-cols-2 lg:grid-cols-12">

            {{-- COL 1 – Recommended Destinations (sticky, 4 cards + see more) --}}
            <div class="md:col-span-1 lg:col-span-4 lg:sticky lg:top-6 lg:self-start">
                <div class="h-full rounded-3xl border border-white/10 bg-white/5 p-5">
                    <h3 class="text-2xl font-bold">Recommended</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-white/50" x-text="resultSummary"></p>

                    {{-- Filter Tabs --}}
                    <div class="mt-4 flex flex-wrap gap-2">
                        <template x-for="filter in filters" :key="filter.value">
                            <button
                                type="button"
                                x-on:click="setFilter(filter.value)"
                                :class="activeFilter === filter.value
                                    ? 'rounded-full px-4 py-2 text-sm font-medium transition bg-orange-500 text-white shadow-lg shadow-orange-500/20'
                                    : 'rounded-full px-4 py-2 text-sm font-medium transition border border-white/10 bg-white/5 text-white/55 hover:bg-white/10 hover:text-white'"
                            >
                                <span x-text="filter.label"></span>
                            </button>
                        </template>
                    </div>

                    {{-- 2×2 Image Cards (4 at a time) --}}
                    <div class="mt-5 grid grid-cols-2 gap-3" id="recommended-grid">
                        <template x-for="dest in visibleItems" :key="dest.id ?? `${dest.title}-${dest.location}`">
                            <a href="#" x-on:click.prevent class="group relative overflow-hidden rounded-2xl">
                                <img
                                    :src="imageFor(dest)"
                                    :data-fallback="fallbackImage"
                                    x-on:error="handleImageError($event)"
                                    :alt="dest.location || dest.title || 'Destination'"
                                    loading="lazy"
                                    decoding="async"
                                    class="h-44 w-full object-cover transition duration-300 group-hover:scale-105"
                                >
                                <div class="absolute inset-0 bg-linear-to-t from-black/85 via-black/20 to-transparent"></div>
                                {{-- Partner discount badge --}}
                                <div class="absolute right-2 top-2 flex items-center gap-1 rounded-full bg-black/50 px-2 py-0.5 backdrop-blur-sm">
                                    <svg class="h-2.5 w-2.5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-[9px] font-semibold text-white/90">Partner discount</span>
                                </div>
                                <div class="absolute bottom-0 left-0 p-3">
                                    <p class="text-base font-bold leading-tight" x-text="dest.location || dest.title || 'Destination'"></p>
                                    <p class="mt-0.5 text-xs text-white/65">
                                        <span x-text="`From ${formatPrice(dest.price_from || 'Contact us')} / ${dest.duration || 'Flexible'}`"></span>
                                    </p>
                                    <p class="text-[10px] text-white/45" x-text="`${dest.hotels || 0} recommended hotels`"></p>
                                </div>
                            </a>
                        </template>

                        <template x-if="!visibleItems.length">
                            <div class="col-span-2 rounded-2xl border border-white/10 bg-white/5 p-4 text-sm text-white/50">
                                No destinations match your search.
                            </div>
                        </template>
                    </div>

                    {{-- “See More” button – shows next 4 items --}}
                    <div class="mt-4 text-center" x-show="visibleCount < totalFiltered">
                        <button
                            type="button"
                            x-on:click="loadMore"
                            class="rounded-full bg-white/10 px-6 py-2 text-sm font-semibold text-white/80 transition hover:bg-white/20"
                        >
                            See More
                        </button>
                    </div>
                </div>
            </div>

            {{-- COL 2 – Stacked Tour Cards (full list, natural flow) --}}
            <div class="md:col-span-1 lg:col-span-4">
                <div class="flex h-full flex-col gap-5">
                    <template x-for="tour in stackedItems" :key="tour.id ?? `${tour.title}-${tour.location}`">
                        <div class="flex-1 rounded-3xl border border-white/10 bg-white/5 p-5">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="text-xl font-bold leading-tight" x-text="tour.title || 'Curated tour'"></h3>
                                <div class="shrink-0 text-right">
                                    <p class="text-2xl font-black" x-text="formatPrice(tour.price_from || 'Contact us')"></p>
                                    <p class="text-xs text-white/40" x-text="`/${tour.duration || 'Flexible'}`"></p>
                                </div>
                            </div>
                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <span class="flex items-center gap-1 rounded-full bg-orange-500/20 px-3 py-1 text-xs font-semibold text-orange-300">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span x-text="Number(tour.rating || 0).toFixed(1)"></span>
                                </span>
                                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-white/55" x-text="tour.season || 'Year-round'"></span>
                            </div>
                            <p class="mt-3 text-sm leading-relaxed text-white/55">
                                <span x-show="!isExpanded(tour.id ?? `${tour.title}-${tour.location}`)" x-text="truncate(tour.description, 115)"></span>
                                <span x-show="isExpanded(tour.id ?? `${tour.title}-${tour.location}`)" x-text="tour.description || ''"></span>
                                <button
                                    type="button"
                                    x-on:click="toggleReadMore(tour.id ?? `${tour.title}-${tour.location}`)"
                                    class="text-orange-400 hover:text-orange-300"
                                    x-text="isExpanded(tour.id ?? `${tour.title}-${tour.location}`) ? ' Read less' : ' Read more'"
                                ></button>
                            </p>
                            <div class="mt-4 grid grid-cols-3 gap-2">
                                <template x-for="(galleryImage, index) in (tour.gallery_images || [])" :key="`${tour.id || tour.title}-${index}`">
                                    <div class="overflow-hidden rounded-xl" x-show="index < 3">
                                        <img
                                            :src="galleryImage"
                                            :data-fallback="fallbackImage"
                                            x-on:error="handleImageError($event)"
                                            alt=""
                                            loading="lazy"
                                            decoding="async"
                                            class="h-24 w-full object-cover transition duration-300 hover:scale-105"
                                        >
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <template x-if="!stackedItems.length">
                        <div class="flex-1 rounded-3xl border border-white/10 bg-white/5 p-5 text-sm text-white/50">
                            No matching tours available.
                        </div>
                    </template>
                </div>
            </div>

            {{-- COL 3 – Featured Safari Card --}}
            <div class="md:col-span-2 lg:col-span-4">
                <template x-if="featuredItem">
                    <div class="flex h-full flex-col overflow-hidden rounded-3xl border border-white/10 bg-white/5">
                        <div class="relative shrink-0">
                            <img
                                :src="imageFor(featuredItem)"
                                :data-fallback="fallbackImage"
                                x-on:error="handleImageError($event)"
                                :alt="featuredItem.title || 'Featured escape'"
                                loading="lazy"
                                decoding="async"
                                class="h-60 w-full object-cover"
                            >
                            <button type="button" class="absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-full bg-black/40 backdrop-blur-sm transition hover:bg-black/60 hover:text-orange-400">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                            <div class="absolute inset-x-0 bottom-0 h-10 bg-linear-to-t from-[#181819] to-transparent"></div>
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <h3 class="text-2xl font-bold leading-snug">
                                <span x-text="truncate(featuredItem.title, 30)"></span><br>
                                <span x-text="`${featuredItem.category || 'Tour'} in ${featuredItem.country || 'Worldwide'}`"></span>
                            </h3>
                            <div class="mt-2 flex items-center gap-2">
                                <svg class="h-4 w-4 shrink-0 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm text-white/50" x-text="`${featuredItem.location || featuredItem.title || 'Featured escape'}, ${featuredItem.country || 'Worldwide'}`"></p>
                            </div>
                            <div class="mt-4 flex items-center gap-3">
                                <div class="flex -space-x-2">
                                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=60&q=80" alt="" class="h-8 w-8 rounded-full border-2 border-[#181819] object-cover">
                                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=60&q=80" alt="" class="h-8 w-8 rounded-full border-2 border-[#181819] object-cover">
                                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=60&q=80" alt="" class="h-8 w-8 rounded-full border-2 border-[#181819] object-cover">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full border-2 border-[#181819] bg-orange-500 text-[10px] font-bold">+2</div>
                                </div>
                                <p class="text-sm text-white/50">6 friends been there</p>
                            </div>
                            <p class="mt-4 text-sm leading-relaxed text-white/55">
                                <span x-show="!isExpanded(featuredItem.id ?? `${featuredItem.title}-${featuredItem.location}`)" x-text="truncate(featuredItem.description || 'Experience an unforgettable adventure...', 120)"></span>
                                <span x-show="isExpanded(featuredItem.id ?? `${featuredItem.title}-${featuredItem.location}`)" x-text="featuredItem.description || 'Experience an unforgettable adventure...'"></span>
                                <button
                                    type="button"
                                    x-on:click="toggleReadMore(featuredItem.id ?? `${featuredItem.title}-${featuredItem.location}`)"
                                    class="text-orange-400 hover:text-orange-300"
                                    x-text="isExpanded(featuredItem.id ?? `${featuredItem.title}-${featuredItem.location}`) ? ' Read less' : ' Read more'"
                                ></button>
                            </p>
                            <div class="mt-4 grid grid-cols-2 gap-3">
                                <div class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                    <svg class="h-4 w-4 shrink-0 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <div>
                                        <p class="text-[10px] text-white/35">Duration</p>
                                        <p class="text-xs font-semibold" x-text="featuredItem.duration || 'Flexible'"></p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                    <svg class="h-4 w-4 shrink-0 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <div>
                                        <p class="text-[10px] text-white/35">Persons</p>
                                        <p class="text-xs font-semibold">2 persons</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 flex items-baseline gap-2">
                                <span class="text-3xl font-black" x-text="formatPrice(featuredItem.price_from || 'Contact us')"></span>
                                <span class="text-sm text-white/40">/person</span>
                            </div>
                            <div class="mt-4 grid grid-cols-2 gap-3">
                                <button type="button" class="rounded-2xl border border-white/15 bg-white/5 py-3 text-sm font-semibold text-white/80 transition hover:bg-white/10 active:scale-[0.98]">Learn more</button>
                                <button type="button" class="rounded-2xl bg-orange-500 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-500/20 transition hover:bg-orange-600 active:scale-[0.98]">Check dates</button>
                            </div>
                        </div>
                    </div>
                </template>
                <template x-if="!featuredItem">
                    <div class="flex h-full flex-col overflow-hidden rounded-3xl border border-white/10 bg-white/5 p-5 text-sm text-white/50">
                        No featured destination matches your current filters.
                    </div>
                </template>
            </div>

        </div>{{-- /main grid --}}
    <script>
    if (typeof explorePage !== 'function') {
        window.explorePage = function(initialItems, fallbackImage) {
            return {
                allItems: initialItems,
                fallbackImage: fallbackImage,
                query: '',
                activeFilter: 'all',
                visibleCount: 4,           // start with 4 cards shown
                expandedIds: [],

                // ---- filters definition ----
                filters: [
                    { label: 'All', value: 'all' },
                    { label: 'Beach', value: 'Beach' },
                    { label: 'Mountain', value: 'Mountain' },
                    { label: 'City', value: 'City' },
                    { label: 'Safari', value: 'Safari' },
                    { label: 'Cruise', value: 'Cruise' },
                ],

                // ---- computed properties ----
                get filteredItems() {
                    let items = this.allItems;

                    // filter by search query
                    if (this.query.trim() !== '') {
                        const q = this.query.toLowerCase();
                        items = items.filter(item => {
                            return (item.title && item.title.toLowerCase().includes(q)) ||
                                   (item.location && item.location.toLowerCase().includes(q)) ||
                                   (item.country && item.country.toLowerCase().includes(q)) ||
                                   (item.category && item.category.toLowerCase().includes(q));
                        });
                    }

                    // filter by category
                    if (this.activeFilter !== 'all') {
                        items = items.filter(item => item.category === this.activeFilter);
                    }

                    return items;
                },

                get totalFiltered() {
                    return this.filteredItems.length;
                },

                // recommended section: only 4 cards at a time
                get visibleItems() {
                    return this.filteredItems.slice(0, this.visibleCount);
                },

                // stacked tours: all filtered items (full list)
                get stackedItems() {
                    return this.filteredItems;
                },

                // featured item: first featured in filtered list
                get featuredItem() {
                    return this.filteredItems.find(item => item.featured) || null;
                },

                // summary text
                get resultSummary() {
                    const total = this.totalFiltered;
                    const shown = Math.min(this.visibleCount, total);
                    if (total === 0) return 'No destinations found.';
                    return `Showing ${shown} of ${total} recommended places`;
                },

                // ---- methods ----
                setFilter(value) {
                    this.activeFilter = value;
                    this.visibleCount = 4; // reset pagination when filter changes
                },

                loadMore() {
                    if (this.visibleCount < this.totalFiltered) {
                        this.visibleCount += 4;
                    }
                },

                imageFor(item) {
                    return item.image || this.fallbackImage;
                },

                handleImageError(event) {
                    const fallback = event.target.dataset.fallback || this.fallbackImage;
                    if (event.target.src !== fallback) {
                        event.target.src = fallback;
                    }
                },

                formatPrice(price) {
                    if (!price || price === 'Contact us') return 'Contact us';
                    const num = parseFloat(price.toString().replace(/[^0-9.]/g, ''));
                    if (isNaN(num)) return 'Contact us';
                    return '₹' + num.toLocaleString();
                },

                truncate(text, length) {
                    if (!text) return '';
                    return text.length > length ? text.substring(0, length) + '...' : text;
                },

                isExpanded(id) {
                    return this.expandedIds.includes(id);
                },

                toggleReadMore(id) {
                    const idx = this.expandedIds.indexOf(id);
                    if (idx > -1) {
                        this.expandedIds.splice(idx, 1);
                    } else {
                        this.expandedIds.push(id);
                    }
                },
            };
        };
    }
    </script>
</div>
@endsection