@extends('layouts.dashboard')

@section('workspace')
<div x-data="tripForm()" class="min-h-full h-full flex flex-col md:flex-row bg-[#111111] text-zinc-100 font-sans">
    
    

    <!-- RIGHT SIDE: Form & Weather -->
    <div class="flex-1 p-8 md:p-12 overflow-y-auto bg-[#111111] custom-scrollbar">
        <div class="max-w-2xl mx-auto">
            
            <form action="{{ isset($trip) ? route('trips.update', $trip->id) : route('trips.store') }}" method="POST" class="space-y-8 relative" @submit="onSubmit">
                @csrf
                @if(isset($trip))
                    @method('PUT')
                @endif

                <!-- Trip Title -->
                <div class="group relative">
                    <label for="title" class="block text-xs font-medium text-zinc-400 mb-1.5 transition-colors group-focus-within:text-indigo-400">Trip Name</label>
                    <input type="text" name="title" id="title" required placeholder="e.g. Summer in Tokyo"
                        class="w-full bg-[#1A1A1A] border border-zinc-800 rounded-lg px-4 py-3 text-white placeholder-zinc-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner text-lg font-medium"
                        value="{{ old('title', $trip->title ?? '') }}">
                    @error('title')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Destination & Weather Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 relative z-10">
                    <div class="group relative">
                        <label for="destination" class="block text-xs font-medium text-zinc-400 mb-1.5 transition-colors group-focus-within:text-indigo-400">Destination City</label>
                        <div class="relative">
                            <input type="text" name="destination" id="destination" required placeholder="e.g. Tokyo, Japan"
                                x-model="destination"
                                @input="fetchWeather"
                                class="w-full bg-[#1A1A1A] border border-zinc-800 rounded-lg pl-10 pr-4 py-2.5 text-white placeholder-zinc-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner"
                                value="{{ old('destination', $trip->destination ?? '') }}">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-zinc-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                            </div>
                        </div>
                        @error('destination')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dynamic Weather Card -->
                    <div class="h-full">
                        <!-- Placeholder state -->
                        <div x-show="!destination && !loadingWeather && !weather" class="h-full min-h-18 rounded-lg border border-dashed border-zinc-800 bg-[#1A1A1A]/50 flex items-center justify-center p-4">
                            <span class="text-xs text-zinc-500">Weather preview will appear here</span>
                        </div>

                        <!-- Loading state -->
                        <div x-show="loadingWeather" class="h-full min-h-18 rounded-lg border border-zinc-800 bg-[#1A1A1A] flex items-center justify-center p-4" style="display: none;">
                            <svg class="animate-spin h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        <!-- Error state -->
                        <div x-show="errorWeather && !loadingWeather" class="h-full min-h-18 rounded-lg border border-red-900/30 bg-red-900/10 flex items-center justify-center p-4" style="display: none;">
                            <span class="text-xs text-red-400">Could not load weather for this location</span>
                        </div>

                        <!-- Weather Info -->
                        <div x-show="weather && !loadingWeather" x-transition.opacity class="h-full relative rounded-xl overflow-hidden shadow-[0_8px_30px_rgba(0,0,0,0.5)] group border border-white/10" style="display: none;">
                            
                            <!-- Dynamic animated gradient background based on weather -->
                            <div class="absolute inset-0 opacity-40 transition-opacity duration-700 group-hover:opacity-70" 
                                 :class="{
                                     'bg-gradient-to-br from-amber-400 via-orange-500 to-red-500': weather?.condition.toLowerCase().includes('clear') || weather?.condition.toLowerCase().includes('sun'),
                                     'bg-gradient-to-br from-sky-400 via-indigo-500 to-purple-600': weather?.condition.toLowerCase().includes('rain') || weather?.condition.toLowerCase().includes('drizzle') || weather?.condition.toLowerCase().includes('storm'),
                                     'bg-gradient-to-br from-slate-400 via-gray-500 to-zinc-700': weather?.condition.toLowerCase().includes('cloud') || weather?.condition.toLowerCase().includes('overcast') || weather?.condition.toLowerCase().includes('mist'),
                                     'bg-gradient-to-br from-cyan-300 via-blue-400 to-indigo-400': weather?.condition.toLowerCase().includes('snow') || weather?.condition.toLowerCase().includes('ice'),
                                     'bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500': !weather?.condition.toLowerCase().match(/clear|sun|rain|drizzle|storm|cloud|overcast|mist|snow|ice/)
                                 }">
                            </div>

                            <!-- Glass overlay -->
                            <div class="absolute inset-0 bg-[#1A1A1A]/70 backdrop-blur-[8px]"></div>
                            
                            <!-- Content -->
                            <div class="relative h-full p-4 flex items-center justify-between z-10">
                                <div class="flex items-center gap-4">
                                    <!-- Icon with glow -->
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-white/20 blur-xl rounded-full"></div>
                                        <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-3xl shadow-inner backdrop-blur-xl transform transition-transform group-hover:scale-110 group-hover:rotate-6 duration-500">
                                            <span x-text="weather?.icon" class="drop-shadow-lg" style="line-height: 1;"></span>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-b from-white to-white/70 tracking-tighter drop-shadow-md" x-text="weather?.temperature.split('°')[0]"></span>
                                            <span class="text-lg font-bold text-white/50">°C</span>
                                        </div>
                                        <div class="text-xs font-bold text-white/80 tracking-widest uppercase mt-0.5 drop-shadow-sm" x-text="weather?.condition"></div>
                                    </div>
                                </div>
                                
                                <!-- Right side metrics -->
                                <div class="flex flex-col gap-2 items-end">
                                    <div class="bg-black/40 border border-white/5 rounded-lg px-2.5 py-1.5 flex items-center gap-1.5 backdrop-blur-md transition-all group-hover:bg-black/60 group-hover:border-white/10">
                                        <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" /></svg>
                                        <span class="text-[10px] font-bold text-white/90" x-text="weather?.humidity.replace('Humidity ', '')"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dates Grid -->
                <div class="grid grid-cols-2 gap-6 relative z-0">
                    <div class="group relative">
                        <label for="start_date" class="block text-xs font-medium text-zinc-400 mb-1.5 transition-colors group-focus-within:text-indigo-400">Start Date</label>
                        <input type="date" name="start_date" id="start_date" required
                            class="w-full bg-[#1A1A1A] border border-zinc-800 rounded-lg px-4 py-2.5 text-zinc-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner scheme-dark"
                            value="{{ old('start_date', isset($trip) ? \Carbon\Carbon::parse($trip->start_date)->format('Y-m-d') : '') }}">
                        @error('start_date')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="group relative">
                        <label for="end_date" class="block text-xs font-medium text-zinc-400 mb-1.5 transition-colors group-focus-within:text-indigo-400">End Date</label>
                        <input type="date" name="end_date" id="end_date" required
                            class="w-full bg-[#1A1A1A] border border-zinc-800 rounded-lg px-4 py-2.5 text-zinc-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner scheme-dark"
                            value="{{ old('end_date', isset($trip) ? \Carbon\Carbon::parse($trip->end_date)->format('Y-m-d') : '') }}">
                        @error('end_date')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Labels Section -->
                <div class="group border-t border-zinc-800/50 pt-6">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-medium text-zinc-400 transition-colors group-focus-within:text-indigo-400">Labels</label>
                        <span class="text-[10px] text-zinc-500" x-text="selectedLabels.length + '/5 selected'"></span>
                    </div>
                    
                    <!-- Pre-made Preset Labels -->
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        <template x-for="preset in presets" :key="preset">
                            <button 
                                type="button" 
                                @click="toggleLabel(preset)"
                                :class="selectedLabels.includes(preset) 
                                    ? 'bg-indigo-500/10 text-indigo-400 border-indigo-500/40 shadow-[0_0_10px_rgba(99,102,241,0.05)]' 
                                    : 'bg-[#1A1A1A] text-zinc-400 border-zinc-800/80 hover:text-zinc-300 hover:border-zinc-700'"
                                class="px-2.5 py-1 text-xs rounded-full border font-medium transition cursor-pointer flex items-center gap-1"
                            >
                                <span x-text="preset"></span>
                                <span x-show="selectedLabels.includes(preset)" class="text-[10px] opacity-60">✓</span>
                            </button>
                        </template>
                    </div>

                    <!-- Custom Tag Input -->
                    <div class="flex items-center gap-2">
                        <div class="relative flex-1">
                            <input 
                                type="text" 
                                x-model="customLabelInput" 
                                @keydown.enter.prevent="addCustomLabel"
                                placeholder="Create custom label... (press Enter)"
                                class="w-full bg-[#1A1A1A] border border-zinc-800 rounded-lg px-4 py-2 text-sm text-white placeholder-zinc-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner"
                            >
                        </div>
                        <button 
                            type="button" 
                            @click="addCustomLabel"
                            class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-zinc-200 hover:text-white rounded-lg text-xs font-semibold transition border border-zinc-700/50"
                        >
                            Add
                        </button>
                    </div>

                    <!-- Selected Labels Chips List -->
                    <div x-show="selectedLabels.length > 0" class="flex flex-wrap gap-1.5 mt-3.5" x-cloak>
                        <template x-for="(label, index) in selectedLabels" :key="label">
                            <div class="inline-flex items-center gap-1 px-2.5 py-1 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-lg text-xs font-semibold">
                                <span x-text="label"></span>
                                <button type="button" @click="removeLabel(label)" class="text-indigo-400/60 hover:text-indigo-400 p-0.5 rounded transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <!-- Hidden form inputs for submission as tags[] -->
                                <input type="hidden" name="tags[]" :value="label">
                            </div>
                        </template>
                    </div>

                    <!-- Error Indicators -->
                    <div x-show="selectedLabels.length >= 5" class="mt-2 text-[10px] text-amber-500 font-medium animate-pulse" x-cloak>
                        Maximum of 5 labels reached.
                    </div>
                    @error('tags')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Optional Details Toggle -->
                <div x-data="{ open: false }" class="border-t border-zinc-800/50 pt-6 mt-2">
                    <button type="button" @click="open = !open" class="flex items-center text-sm font-medium text-zinc-400 hover:text-white transition-colors focus:outline-none">
                        <svg class="w-4 h-4 mr-2 transition-transform duration-200" :class="{ 'rotate-90': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        Add optional details
                    </button>

                    <div x-show="open" x-collapse x-cloak style="display: none;" class="pt-6 space-y-6">
                        
                        <!-- Budget -->
                        <div class="group relative">
                            <label for="budget" class="block text-xs font-medium text-zinc-400 mb-1.5 transition-colors group-focus-within:text-indigo-400">Estimated Budget</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-zinc-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="budget" id="budget" placeholder="0.00" step="0.01" min="0"
                                    class="w-full bg-[#1A1A1A] border border-zinc-800 rounded-lg pl-8 pr-4 py-2.5 text-white placeholder-zinc-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner"
                                    value="{{ old('budget', $trip->budget ?? '') }}">
                            </div>
                        </div>

                        <!-- Notes/Description -->
                        <div class="group relative">
                            <label for="notes" class="block text-xs font-medium text-zinc-400 mb-1.5 transition-colors group-focus-within:text-indigo-400">Trip Notes</label>
                            <textarea name="notes" id="notes" rows="4" placeholder="Any initial thoughts or goals for this trip..."
                                class="w-full bg-[#1A1A1A] border border-zinc-800 rounded-lg px-4 py-3 text-white placeholder-zinc-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner custom-scrollbar resize-y">{{ old('notes', $trip->notes ?? '') }}</textarea>
                        </div>
                        
                        <!-- Cover Image Upload -->
                        <div>
                            <label class="block text-xs font-medium text-zinc-400 mb-1.5">Cover Image</label>
                            <label class="mt-1 flex justify-center rounded-lg border border-dashed border-zinc-700/50 px-6 py-8 bg-[#1A1A1A]/30 hover:bg-[#1A1A1A]/50 hover:border-zinc-500/50 transition cursor-pointer relative overflow-hidden group">
                                <input type="file" accept="image/*" class="hidden" @change="handleCoverUpload">
                                
                                <div x-show="!draftCoverImage" class="text-center transition-transform group-hover:scale-105 duration-300">
                                    <svg class="mx-auto h-8 w-8 text-zinc-500 group-hover:text-indigo-400 transition-colors" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="mt-4 flex text-sm leading-6 text-zinc-400">
                                        <span>Upload a file or drag and drop</span>
                                    </div>
                                    <p class="text-xs leading-5 text-zinc-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                                
                                <div x-show="draftCoverImage" class="absolute inset-0" style="display: none;">
                                    <img :src="draftCoverImage" class="w-full h-full object-cover opacity-60">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="text-sm font-semibold text-white bg-black/50 px-3 py-1.5 rounded-lg backdrop-blur-sm">Change Image</span>
                                    </div>
                                </div>
                            </label>
                        </div>

                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-8 flex items-center justify-end border-t border-zinc-800/50">
                    <button type="button" @click="generatePDF()" class="inline-flex items-center justify-center rounded-lg bg-[#2A2A2A] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#333333] border border-white/10 focus-visible:outline-2 focus-visible:outline-offset-2 transition-all mr-3">
                        <svg class="w-4 h-4 mr-2 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Export PDF
                    </button>
                    <button type="button" class="text-sm font-medium text-zinc-400 hover:text-white px-4 py-2 mr-2 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="inline-flex items-center justify-center rounded-lg bg-indigo-500 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 transition-all hover:shadow-[0_0_20px_rgba(99,102,241,0.3)]">
                        {{ isset($trip) ? 'Save Changes' : 'Create Trip' }}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 ml-2 -mr-1">
                            <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>
            
        </div>
    </div>

    <!-- LEFT SIDE: Intro & Motivation -->
    <div class="w-full md:w-1/3 lg:w-1/4 p-8 md:p-12 border-b md:border-b-0 md:border-r border-zinc-800/50 flex flex-col bg-[#141414]">
        <div class="mb-12">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-500/10 text-indigo-400 mb-6 border border-indigo-500/20 shadow-[0_0_15px_rgba(99,102,241,0.1)]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                </svg>
            </div>
            <h1 class="text-3xl font-semibold tracking-tight text-white mb-3">{{ isset($trip) ? 'Edit your journey' : 'Plan a new journey' }}</h1>
            <p class="text-sm text-zinc-400 leading-relaxed">
                {{ isset($trip) ? 'Update the details of your trip.' : 'Define the parameters of your next adventure. Your workspace will automatically adapt to help you organize the itinerary, budget, and activities.' }}
            </p>
        </div>

        <div class="mt-auto hidden md:block">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-500 mb-4">Workflow Steps</h3>
            <ul class="space-y-4">
                <li class="flex items-center text-sm text-zinc-300">
                    <div class="w-6 h-6 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center mr-3 border border-indigo-500/30 text-xs">1</div>
                    Basic Details
                </li>
                <li class="flex items-center text-sm text-zinc-600">
                    <div class="w-6 h-6 rounded-full bg-zinc-800/50 flex items-center justify-center mr-3 border border-zinc-700/50 text-xs">2</div>
                    Itinerary Planning
                </li>
                <li class="flex items-center text-sm text-zinc-600">
                    <div class="w-6 h-6 rounded-full bg-zinc-800/50 flex items-center justify-center mr-3 border border-zinc-700/50 text-xs">3</div>
                    Budgeting & Invites
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #27272a;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #3f3f46;
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('tripForm', () => ({
            destination: {!! json_encode(old('destination', $trip->destination ?? '')) !!},
            weather: null,
            loadingWeather: false,
            errorWeather: false,
            weatherTimeout: null,
            draftCoverImage: localStorage.getItem('trip_' + '{{ $trip->id ?? '' }}' + '_cover') || null,
            
            // Labels properties
            presets: ['Family', 'Work', 'Solo Travel', 'Friends', 'Adventure', 'Relaxation', 'Archive'],
            selectedLabels: {!! old('tags') ? json_encode(old('tags')) : (isset($trip) && $trip->tags ? json_encode($trip->tags) : '[]') !!} || [],
            customLabelInput: '',
            
            init() {
                if (this.destination) {
                    this.fetchWeather();
                }
            },
            
            onSubmit(e) {
                // Keep the draft image in localStorage so it's ready when the trip is viewed
                if (this.draftCoverImage) {
                    const tempId = 'temp_draft';
                    localStorage.setItem('trip_' + tempId + '_cover', this.draftCoverImage);
                }
            },
            
            generatePDF() {
                const title = document.getElementById('title').value || 'My Trip';
                const destination = document.getElementById('destination').value || 'Unknown Destination';
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const budget = document.getElementById('budget').value;
                const notes = document.getElementById('notes').value;
                
                const printWin = window.open('', '_blank');
                if(!printWin) {
                    alert("Please allow popups to export the PDF.");
                    return;
                }
                
                const html = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Export PDF - ${title}</title>
                    <style>
                        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #111; line-height: 1.6; margin: 0; padding: 40px; }
                        h1 { font-size: 32px; margin-bottom: 5px; }
                        .destination { color: #666; font-size: 18px; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #111; padding-bottom: 20px; margin-bottom: 30px; }
                        .section { margin-bottom: 30px; background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #eaeaea; }
                        .section h3 { margin-top: 0; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; color: #666; border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 15px; }
                        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
                        .detail-item { margin-bottom: 10px; }
                        .detail-label { font-size: 12px; color: #666; text-transform: uppercase; display: block; margin-bottom: 4px; }
                        .detail-value { font-size: 16px; font-weight: 600; }
                        .tags { display: flex; flex-wrap: wrap; gap: 8px; }
                        .tag { background: #e0e7ff; color: #3730a3; padding: 4px 10px; border-radius: 100px; font-size: 12px; font-weight: 600; }
                        .no-print { text-align: right; margin-bottom: 20px; }
                        .no-print button { background: #4f46e5; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; }
                        @media print { .no-print { display: none !important; } }
                    </style>
                </head>
                <body onload="window.print()">
                    <div class="no-print">
                        <button onclick="window.print()">Print / Save as PDF</button>
                    </div>
                    <h1>${title}</h1>
                    <div class="destination">${destination}</div>
                    
                    <div class="section">
                        <h3>Trip Details</h3>
                        <div class="grid">
                            <div class="detail-item">
                                <span class="detail-label">Start Date</span>
                                <span class="detail-value">${startDate ? new Date(startDate).toLocaleDateString() : 'Not Set'}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">End Date</span>
                                <span class="detail-value">${endDate ? new Date(endDate).toLocaleDateString() : 'Not Set'}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Estimated Budget</span>
                                <span class="detail-value">${budget ? '$' + parseFloat(budget).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) : 'Not Set'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section">
                        <h3>Notes & Plans</h3>
                        <div style="white-space: pre-wrap;">${notes || 'No notes provided yet.'}</div>
                    </div>
                    
                    <div class="section">
                        <h3>Labels & Tags</h3>
                        <div class="tags">
                            ${this.selectedLabels.length > 0 
                                ? this.selectedLabels.map(tag => `<span class="tag">${tag}</span>`).join('') 
                                : '<span class="detail-value" style="font-weight:normal; font-size:14px;">No labels</span>'}
                        </div>
                    </div>
                </body>
                </html>
                `;
                printWin.document.write(html);
                printWin.document.close();
            },
            
            handleCoverUpload(e) {
                const file = e.target.files[0];
                if(file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.draftCoverImage = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },
            
            toggleLabel(label) {
                if (this.selectedLabels.includes(label)) {
                    this.removeLabel(label);
                } else {
                    this.addLabel(label);
                }
            },
            
            addLabel(label) {
                const trimmed = label.trim();
                if (!trimmed) return;
                if (this.selectedLabels.length >= 5) return;
                if (this.selectedLabels.includes(trimmed)) return;
                this.selectedLabels.push(trimmed);
            },
            
            removeLabel(label) {
                this.selectedLabels = this.selectedLabels.filter(l => l !== label);
            },
            
            addCustomLabel() {
                const label = this.customLabelInput.trim();
                if (!label) return;
                this.addLabel(label);
                this.customLabelInput = '';
            },
            
            fetchWeather() {
                clearTimeout(this.weatherTimeout);
                
                if (!this.destination || this.destination.length < 3) {
                    this.weather = null;
                    this.errorWeather = false;
                    return;
                }
                
                this.loadingWeather = true;
                this.errorWeather = false;
                
                this.weatherTimeout = setTimeout(async () => {
                    try {
                        const response = await fetch(`{{ route('trips.weather') }}?city=${encodeURIComponent(this.destination)}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (!response.ok) throw new Error(data.error || 'Weather fetch failed');
                        
                        this.weather = data;
                    } catch (e) {
                        this.errorWeather = true;
                        this.weather = null;
                        console.error("Weather API Error:", e.message);
                    } finally {
                        this.loadingWeather = false;
                    }
                }, 800); // 800ms debounce
            }
        }));
    });
</script>
@endsection
