@extends('layouts.app')

@section('content')
<div class="relative min-h-screen bg-[#0f0f10] text-white overflow-hidden">

    <!-- decor bg glows -->
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <!-- top left orange glow -->
        <div class="absolute -left-40 -top-40 h-[520px] w-[520px] rounded-full opacity-[0.07]"
             style="background: radial-gradient(circle, #FF7A00 0%, transparent 70%);"></div>
        <!-- bottom right subtle gllow -->
        <div class="absolute -bottom-32 -right-32 h-[420px] w-[420px] rounded-full opacity-[0.05]"
             style="background: radial-gradient(circle, #FF7A00 0%, transparent 70%);"></div>
    </div>

    {{-- ══════════════════════════════════════════════
         TOP NAV BAR
    ══════════════════════════════════════════════ --}}
    <header class="relative z-10 flex items-center justify-between px-6 py-5 sm:px-10 lg:px-16">
        <a href="/dashboard" class="flex items-center gap-2.5 group">
            <svg class="h-5 w-5 text-white/40 group-hover:text-white/70 transition" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="text-sm text-white/40 group-hover:text-white/70 transition">Back to Dashboard</span>
        </a>
        <span class="text-sm font-semibold tracking-tight text-white/60">TripTailor</span>
    </header>

    {{-- ══════════════════════════════════════════════
         MAIN TWO-COLUMN LAYOUT
    ══════════════════════════════════════════════ --}}
    <main class="relative z-10 mx-auto max-w-6xl px-6 pb-20 pt-4 sm:px-10 lg:px-16">
        <div class="grid gap-12 lg:grid-cols-5 lg:gap-16 xl:gap-20 items-start">

            {{-- ─────────────────────────────────────
                 LEFT — Informational Panel  (2/5)
            ───────────────────────────────────── --}}
            <div class="lg:col-span-2 lg:sticky lg:top-24">

                {{-- Label --}}
                <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-orange-400">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-orange-500"></span>
                    New Journey
                </p>

                {{-- Heading --}}
                <h1 class="mt-4 text-4xl font-extrabold leading-[1.1] tracking-tight sm:text-5xl">
                    Craft your<br>
                    <span class="bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">perfect trip</span>
                </h1>

                {{-- Description --}}
                <p class="mt-5 text-base leading-relaxed text-white/45 max-w-sm">
                    Set your destination, dates, and budget — we'll help you build a day-by-day itinerary that fits your style.
                </p>

                {{-- Feature list --}}
                <ul class="mt-8 flex flex-col gap-4">
                    @foreach ([
                        ['icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7',
                         'title' => 'Smart Itineraries',
                         'desc'  => 'Auto-organized day-by-day plans'],
                        ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                         'title' => 'Any Destination',
                         'desc'  => 'Domestic & international coverage'],
                        ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                         'title' => 'Budget Tracking',
                         'desc'  => 'Stay on top of your spend'],
                    ] as $feature)
                        <li class="flex items-start gap-3.5">
                            <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-white/10 bg-white/5">
                                <svg class="h-4 w-4 text-orange-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white/80">{{ $feature['title'] }}</p>
                                <p class="text-xs text-white/35">{{ $feature['desc'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- ─────────────────────────────────────
                 RIGHT — Form Card  (3/5)
            ───────────────────────────────────── --}}
            <div class="lg:col-span-3">
                <form action="/trips" method="POST"
                      class="rounded-3xl border border-white/10 bg-white/[0.03] p-6 shadow-2xl shadow-black/20 backdrop-blur-sm sm:p-8">
                    @csrf

                    {{-- Card header --}}
                    <div class="mb-8">
                        <h2 class="text-xl font-bold tracking-tight">Trip Details</h2>
                        <p class="mt-1 text-sm text-white/35">Fill in the essentials to get started.</p>
                    </div>

                    {{-- Validation errors --}}
                    @if ($errors->any())
                        <div class="mb-6 rounded-2xl border border-red-500/20 bg-red-500/5 px-5 py-4">
                            <p class="mb-2 text-sm font-semibold text-red-400">Please fix the following:</p>
                            <ul class="list-inside list-disc space-y-1 text-sm text-red-300/80">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex flex-col gap-6">

                        {{-- Trip Title --}}
                        <div>
                            <label for="title" class="mb-2 block text-xs font-semibold uppercase tracking-widest text-white/40">
                                Trip Title <span class="text-orange-400">*</span>
                            </label>
                            <input type="text" id="title" name="title" required
                                   value="{{ old('title') }}"
                                   placeholder="e.g. Goa Weekend Getaway"
                                   class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white
                                          placeholder:text-white/25
                                          transition duration-200
                                          focus:border-orange-500/40 focus:outline-none focus:ring-2 focus:ring-orange-500/15">
                        </div>

                        {{-- Destination --}}
                        <div>
                            <label for="location" class="mb-2 block text-xs font-semibold uppercase tracking-widest text-white/40">
                                Destination <span class="text-orange-400">*</span>
                            </label>
                            <div class="relative">
                                <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-white/30"
                                     fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <input type="text" id="location" name="location" required
                                       value="{{ old('location') }}"
                                       placeholder="e.g. Goa, India"
                                       class="w-full rounded-xl border border-white/10 bg-white/5 py-3 pl-11 pr-4 text-sm text-white
                                              placeholder:text-white/25
                                              transition duration-200
                                              focus:border-orange-500/40 focus:outline-none focus:ring-2 focus:ring-orange-500/15">
                            </div>
                        </div>

                        {{-- Date Row --}}
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            {{-- Start Date --}}
                            <div>
                                <label for="start_date" class="mb-2 block text-xs font-semibold uppercase tracking-widest text-white/40">
                                    Start Date <span class="text-orange-400">*</span>
                                </label>
                                <input type="date" id="start_date" name="start_date" required
                                       value="{{ old('start_date') }}"
                                       class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white
                                              transition duration-200
                                              focus:border-orange-500/40 focus:outline-none focus:ring-2 focus:ring-orange-500/15
                                              [color-scheme:dark]">
                            </div>

                            {{-- End Date --}}
                            <div>
                                <label for="end_date" class="mb-2 block text-xs font-semibold uppercase tracking-widest text-white/40">
                                    End Date <span class="text-orange-400">*</span>
                                </label>
                                <input type="date" id="end_date" name="end_date" required
                                       value="{{ old('end_date') }}"
                                       class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white
                                              transition duration-200
                                              focus:border-orange-500/40 focus:outline-none focus:ring-2 focus:ring-orange-500/15
                                              [color-scheme:dark]">
                            </div>
                        </div>

                        {{-- Budget --}}
                        <div>
                            <label for="budget" class="mb-2 block text-xs font-semibold uppercase tracking-widest text-white/40">
                                Estimated Budget
                                <span class="ml-1 text-white/20 normal-case tracking-normal">(optional)</span>
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-white/30">₹</span>
                                <input type="number" id="budget" name="budget" min="0" step="100"
                                       value="{{ old('budget') }}"
                                       placeholder="25000"
                                       class="w-full rounded-xl border border-white/10 bg-white/5 py-3 pl-9 pr-4 text-sm text-white
                                              placeholder:text-white/25
                                              transition duration-200
                                              focus:border-orange-500/40 focus:outline-none focus:ring-2 focus:ring-orange-500/15
                                              [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none">
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label for="notes" class="mb-2 block text-xs font-semibold uppercase tracking-widest text-white/40">
                                Notes
                                <span class="ml-1 text-white/20 normal-case tracking-normal">(optional)</span>
                            </label>
                            <textarea id="notes" name="notes" rows="4"
                                      placeholder="Anything you'd like to remember — hotel preferences, must-see spots, packing notes…"
                                      class="w-full resize-none rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white
                                             placeholder:text-white/25
                                             transition duration-200
                                             focus:border-orange-500/40 focus:outline-none focus:ring-2 focus:ring-orange-500/15">{{ old('notes') }}</textarea>
                        </div>

                    </div>

                    {{-- Divider --}}
                    <div class="my-8 h-px bg-white/8"></div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                        <a href="/dashboard"
                           class="flex items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/5 px-6 py-3
                                  text-sm font-medium text-white/60 transition duration-200
                                  hover:border-white/20 hover:bg-white/10 hover:text-white/80 active:scale-[0.98]">
                            Cancel
                        </a>
                        <button type="submit"
                                class="flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-8 py-3
                                       text-sm font-bold text-white shadow-lg shadow-orange-500/20
                                       transition duration-200
                                       hover:bg-orange-400 hover:shadow-orange-500/30 active:scale-[0.98]">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                            </svg>
                            Create Trip
                        </button>
                    </div>
                </form>

                {{-- Subtle helper text below form --}}
                <p class="mt-5 text-center text-xs text-white/20">
                    You can edit every detail after creating. No commitment yet.
                </p>
            </div>

        </div>
    </main>
</div>
@endsection
