@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0f0f10] text-white overflow-x-hidden">
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">

        {{-- ═══════════════════════════════════════
             NAVIGATION BAR
        ═══════════════════════════════════════ --}}
        <nav class="flex items-center justify-between border-b border-white/8 pb-4">

            {{-- Nav Links --}}
            <div class="flex items-center gap-1 sm:gap-6">
                @foreach ([
                    ['label' => 'Home',     'active' => true],
                    ['label' => 'Book',     'active' => false],
                    ['label' => 'My Trips', 'active' => false],
                    ['label' => 'Profile',  'active' => false],
                ] as $nav)
                    <a href="#"
                       class="px-3 py-1 text-sm font-medium transition sm:px-0
                           {{ $nav['active']
                               ? 'border-b-2 border-orange-500 pb-1 text-white'
                               : 'text-white/45 hover:text-white' }}">
                        {{ $nav['label'] }}
                    </a>
                @endforeach
            </div>

            {{-- Right: Notification Bell + Profile --}}
            <div class="flex items-center gap-3">
                <button class="relative rounded-full border border-white/10 bg-white/5 p-2.5 transition hover:bg-white/10">
                    <svg class="h-4 w-4 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0m6 0H9"/>
                    </svg>
                    <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-orange-500 ring-2 ring-[#0f0f10]"></span>
                </button>

                <div class="flex items-center gap-2.5">
                    <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full border-2 border-orange-500/60">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=80"
                             alt="Cynthia Wolf" class="h-full w-full object-cover">
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-sm font-semibold leading-tight">Cynthia Wolf</p>
                        <p class="text-xs text-white/40">@c_wolf89</p>
                    </div>
                </div>
            </div>
        </nav>

        {{-- ═══════════════════════════════════════
             HERO  — Title + Search
        ═══════════════════════════════════════ --}}
        <div class="mt-6 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            {{-- Big Bold Title --}}
            <div class="flex items-start gap-4">
                <div class="mt-1 h-[4.5rem] w-1.5 shrink-0 rounded-full bg-orange-500"></div>
                <h1 class="text-5xl font-black uppercase leading-none tracking-tight sm:text-6xl lg:text-7xl">
                    Plan Your<br>Next Trip
                </h1>
            </div>

            {{-- Search Bar --}}
            <div class="w-full lg:max-w-lg">
                <label class="flex cursor-text items-center gap-3 rounded-2xl border border-white/10 bg-white/5
                              px-5 py-3.5 ring-1 ring-transparent transition
                              focus-within:border-orange-500/40 focus-within:ring-orange-500/15">
                    <svg class="h-5 w-5 shrink-0 text-white/35" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/>
                    </svg>
                    <input type="text" placeholder="Where we go?"
                           class="min-w-0 flex-1 bg-transparent text-sm text-white placeholder:text-white/35 focus:outline-none">
                    <button class="shrink-0 rounded-xl border border-white/10 bg-white/8 p-2 transition hover:bg-white/15">
                        <svg class="h-4 w-4 text-white/55" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </button>
                </label>
            </div>
        </div>

        {{-- ═══════════════════════════════════════
             MAIN 3-COLUMN GRID
        ═══════════════════════════════════════ --}}
        <div class="mt-6 grid gap-5 md:grid-cols-2 lg:grid-cols-12">

            {{-- ─────────────────────────────────────
                 COL 1 — Recommended Destinations (4/12)
            ───────────────────────────────────── --}}
            <div class="md:col-span-1 lg:col-span-4">
                <div class="h-full rounded-3xl border border-white/10 bg-white/5 p-5">

                    <h3 class="text-2xl font-bold">Recommended</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-white/50">
                        Discover our handpicked selection of tours, carefully chosen for your perfect getaway.
                    </p>

                    {{-- Filter Tabs --}}
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ([
                            ['label' => 'All tours', 'active' => true],
                            ['label' => 'Asia',      'active' => false],
                            ['label' => 'Europe',    'active' => false],
                            ['label' => 'USA',       'active' => false],
                        ] as $tab)
                            <button class="rounded-full px-4 py-2 text-sm font-medium transition
                                {{ $tab['active']
                                    ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20'
                                    : 'border border-white/10 bg-white/5 text-white/55 hover:bg-white/10 hover:text-white' }}">
                                {{ $tab['label'] }}
                            </button>
                        @endforeach
                    </div>

                    {{-- 2×2 Destination Image Cards --}}
                    <div class="mt-5 grid grid-cols-2 gap-3">
                        @foreach ([
                            [
                                'name'   => 'Spain',
                                'price'  => 'From $1399 / 4 days',
                                'hotels' => '14 recommended hotels',
                                'img'    => 'https://images.unsplash.com/photo-1525874684015-58379d421a52?auto=format&fit=crop&w=600&q=80',
                            ],
                            [
                                'name'   => 'Japan',
                                'price'  => 'From $1650 / 7 days',
                                'hotels' => '27 recommended hotels',
                                'img'    => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=600&q=80',
                            ],
                            [
                                'name'   => 'Italy',
                                'price'  => 'From $1969 / 6 days',
                                'hotels' => '12 recommended hotels',
                                'img'    => 'https://images.unsplash.com/photo-1533104816931-20fa691ff6ca?auto=format&fit=crop&w=600&q=80',
                            ],
                            [
                                'name'   => 'Switzerland',
                                'price'  => 'From $2000 / 10 days',
                                'hotels' => '22 recommended hotels',
                                'img'    => 'https://images.unsplash.com/photo-1531973576160-7125cd663d86?auto=format&fit=crop&w=600&q=80',
                            ],
                        ] as $dest)
                            <a href="#" class="group relative overflow-hidden rounded-2xl">
                                <img src="{{ $dest['img'] }}" alt="{{ $dest['name'] }}"
                                     class="h-44 w-full object-cover transition duration-300 group-hover:scale-105">

                                {{-- Gradient overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>

                                {{-- Partner discount badge --}}
                                <div class="absolute right-2 top-2 flex items-center gap-1 rounded-full
                                            bg-black/50 px-2 py-0.5 backdrop-blur-sm">
                                    <svg class="h-2.5 w-2.5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-[9px] font-semibold text-white/90">Partner discount</span>
                                </div>

                                {{-- Destination info --}}
                                <div class="absolute bottom-0 left-0 p-3">
                                    <p class="text-base font-bold leading-tight">{{ $dest['name'] }}</p>
                                    <p class="mt-0.5 text-xs text-white/65">{{ $dest['price'] }}</p>
                                    <p class="text-[10px] text-white/45">{{ $dest['hotels'] }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ─────────────────────────────────────
                 COL 2 — Stacked Tour Cards (4/12)
            ───────────────────────────────────── --}}
            <div class="md:col-span-1 lg:col-span-4">
                <div class="flex h-full flex-col gap-5">

                    @foreach ([
                        [
                            'title'  => 'Paradise in Bali',
                            'price'  => '$1,250',
                            'per'    => '/6 days',
                            'rating' => '4.9',
                            'season' => 'All year-round',
                            'desc'   => 'Boutique villa accommodation, airport transfers, daily yoga classes, traditional cooking classes and guided temple tours included.',
                            'imgs'   => [
                                'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=400&q=80',
                                'https://images.unsplash.com/photo-1555400038-63f5ba517a47?auto=format&fit=crop&w=400&q=80',
                                'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=400&q=80',
                            ],
                        ],
                        [
                            'title'  => 'Journey to Japan',
                            'price'  => '$1,659',
                            'per'    => '/8 days',
                            'rating' => '4.8',
                            'season' => 'All year-round',
                            'desc'   => 'Culture lovers and foodies eager to explore Japan\'s rich heritage and diverse cuisine through immersive local experiences and hidden gems.',
                            'imgs'   => [
                                'https://images.unsplash.com/photo-1490806843957-31f4c9a91c65?auto=format&fit=crop&w=400&q=80',
                                'https://images.unsplash.com/photo-1528360983277-13d401cdc186?auto=format&fit=crop&w=400&q=80',
                                'https://images.unsplash.com/photo-1480796927426-f609979314bd?auto=format&fit=crop&w=400&q=80',
                            ],
                        ],
                    ] as $tour)
                        <div class="flex-1 rounded-3xl border border-white/10 bg-white/5 p-5">

                            {{-- Title + Price --}}
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="text-xl font-bold leading-tight">{{ $tour['title'] }}</h3>
                                <div class="shrink-0 text-right">
                                    <p class="text-2xl font-black">{{ $tour['price'] }}</p>
                                    <p class="text-xs text-white/40">{{ $tour['per'] }}</p>
                                </div>
                            </div>

                            {{-- Rating + Season badges --}}
                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <span class="flex items-center gap-1 rounded-full bg-orange-500/20 px-3 py-1
                                             text-xs font-semibold text-orange-300">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    {{ $tour['rating'] }}
                                </span>
                                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-white/55">
                                    {{ $tour['season'] }}
                                </span>
                            </div>

                            {{-- Description --}}
                            <p class="mt-3 text-sm leading-relaxed text-white/55">
                                {{ Str::limit($tour['desc'], 115) }}
                                <a href="#" class="text-orange-400 hover:text-orange-300"> Read more</a>
                            </p>

                            {{-- 3-Photo Strip --}}
                            <div class="mt-4 grid grid-cols-3 gap-2">
                                @foreach ($tour['imgs'] as $img)
                                    <div class="overflow-hidden rounded-xl">
                                        <img src="{{ $img }}" alt=""
                                             class="h-24 w-full object-cover transition duration-300 hover:scale-105">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            {{-- ─────────────────────────────────────
                 COL 3 — Featured Safari Card (4/12)
            ───────────────────────────────────── --}}
            <div class="md:col-span-2 lg:col-span-4">
                <div class="flex h-full flex-col overflow-hidden rounded-3xl border border-white/10 bg-white/5">

                    {{-- Hero Photo --}}
                    <div class="relative shrink-0">
                        <img src="https://images.unsplash.com/photo-1549366021-9f761d450615?auto=format&fit=crop&w=900&q=80"
                             alt="Safari in Kenya"
                             class="h-60 w-full object-cover">

                        {{-- Wishlist heart --}}
                        <button class="absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-full
                                       bg-black/40 backdrop-blur-sm transition hover:bg-black/60 hover:text-orange-400">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>

                        {{-- Fade into card --}}
                        <div class="absolute inset-x-0 bottom-0 h-10 bg-gradient-to-t from-[#181819] to-transparent"></div>
                    </div>

                    {{-- Card Content --}}
                    <div class="flex flex-1 flex-col p-5">

                        {{-- Title --}}
                        <h3 class="text-2xl font-bold leading-snug">
                            Safari & Wildlife<br>Adventure in Kenya
                        </h3>

                        {{-- Location --}}
                        <div class="mt-2 flex items-center gap-2">
                            <svg class="h-4 w-4 shrink-0 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-white/50">Maasai Mara National Reserve, Kenya</p>
                        </div>

                        {{-- Friends avatars --}}
                        <div class="mt-4 flex items-center gap-3">
                            <div class="flex -space-x-2">
                                @foreach ([
                                    'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=60&q=80',
                                    'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=60&q=80',
                                    'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=60&q=80',
                                ] as $avatar)
                                    <img src="{{ $avatar }}" alt="Friend"
                                         class="h-8 w-8 rounded-full border-2 border-[#181819] object-cover">
                                @endforeach
                                <div class="flex h-8 w-8 items-center justify-center rounded-full
                                            border-2 border-[#181819] bg-orange-500 text-[10px] font-bold">
                                    +2
                                </div>
                            </div>
                            <p class="text-sm text-white/50">6 friends been there</p>
                        </div>

                        {{-- Description --}}
                        <p class="mt-4 text-sm leading-relaxed text-white/55">
                            Embark on a once-in-a-lifetime safari adventure in the heart of Kenya's iconic Maasai Mara.
                            Witness breathtaking wildlife in their natural habitat.
                            <a href="#" class="text-orange-400 hover:text-orange-300"> Read more</a>
                        </p>

                        {{-- Info chips --}}
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <div class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                <svg class="h-4 w-4 shrink-0 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-[10px] text-white/35">Duration</p>
                                    <p class="text-xs font-semibold">7 days, 6 nights</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                <svg class="h-4 w-4 shrink-0 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div>
                                    <p class="text-[10px] text-white/35">Persons</p>
                                    <p class="text-xs font-semibold">2 persons</p>
                                </div>
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="mt-4 flex items-baseline gap-2">
                            <span class="text-sm text-white/30 line-through">$1,959</span>
                            <span class="text-3xl font-black">$1,659</span>
                            <span class="text-sm text-white/40">/person</span>
                        </div>

                        {{-- CTA Buttons --}}
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <button class="rounded-2xl border border-white/15 bg-white/5 py-3 text-sm font-semibold
                                           text-white/80 transition hover:bg-white/10 active:scale-[0.98]">
                                Learn more
                            </button>
                            <button class="rounded-2xl bg-orange-500 py-3 text-sm font-semibold text-white
                                           shadow-lg shadow-orange-500/20 transition hover:bg-orange-600 active:scale-[0.98]">
                                Check dates
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /main grid --}}
    </div>
</div>
@endsection