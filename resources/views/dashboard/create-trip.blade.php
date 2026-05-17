@extends('layouts.dashboard')

@section('workspace')
<div x-data="tripForm()" class="min-h-full h-full flex flex-col md:flex-row bg-[#111111] text-zinc-100 font-sans">
    
    

    <!-- RIGHT SIDE: Form & Weather -->
    <div class="flex-1 p-8 md:p-12 overflow-y-auto bg-[#111111] custom-scrollbar">
        <div class="max-w-2xl mx-auto">
            
            <form action="{{ route('trips.store') }}" method="POST" class="space-y-8 relative">
                @csrf

                <!-- Trip Title -->
                <div class="group relative">
                    <label for="title" class="block text-xs font-medium text-zinc-400 mb-1.5 transition-colors group-focus-within:text-indigo-400">Trip Name</label>
                    <input type="text" name="title" id="title" required placeholder="e.g. Summer in Tokyo"
                        class="w-full bg-[#1A1A1A] border border-zinc-800 rounded-lg px-4 py-3 text-white placeholder-zinc-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner text-lg font-medium"
                        value="{{ old('title') }}">
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
                                value="{{ old('destination') }}">
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
                        <div x-show="weather && !loadingWeather" x-transition.opacity class="h-full rounded-lg border border-zinc-800 bg-linear-to-br from-[#1A1A1A] to-[#202020] p-3 flex items-center justify-between shadow-lg" style="display: none;">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-zinc-800 flex items-center justify-center text-xl shadow-inner border border-zinc-700/50">
                                    <span x-text="weather?.icon"></span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-white" x-text="weather?.temperature"></div>
                                    <div class="text-xs text-zinc-400" x-text="weather?.condition"></div>
                                </div>
                            </div>
                            <div class="text-right flex flex-col justify-center">
                                <div class="text-[10px] text-zinc-500 flex items-center justify-end space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" /></svg>
                                    <span x-text="weather?.humidity"></span>
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
                            value="{{ old('start_date') }}">
                        @error('start_date')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="group relative">
                        <label for="end_date" class="block text-xs font-medium text-zinc-400 mb-1.5 transition-colors group-focus-within:text-indigo-400">End Date</label>
                        <input type="date" name="end_date" id="end_date" required
                            class="w-full bg-[#1A1A1A] border border-zinc-800 rounded-lg px-4 py-2.5 text-zinc-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner scheme-dark"
                            value="{{ old('end_date') }}">
                        @error('end_date')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
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
                                    value="{{ old('budget') }}">
                            </div>
                        </div>

                        <!-- Notes/Description -->
                        <div class="group relative">
                            <label for="notes" class="block text-xs font-medium text-zinc-400 mb-1.5 transition-colors group-focus-within:text-indigo-400">Trip Notes</label>
                            <textarea name="notes" id="notes" rows="4" placeholder="Any initial thoughts or goals for this trip..."
                                class="w-full bg-[#1A1A1A] border border-zinc-800 rounded-lg px-4 py-3 text-white placeholder-zinc-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner custom-scrollbar resize-y">{{ old('notes') }}</textarea>
                        </div>
                        
                        <!-- Future: Cover Image Placeholder -->
                        <div>
                            <label class="block text-xs font-medium text-zinc-400 mb-1.5">Cover Image <span class="text-zinc-600 text-[10px] ml-1">(Coming Soon)</span></label>
                            <div class="mt-1 flex justify-center rounded-lg border border-dashed border-zinc-700/50 px-6 py-8 bg-[#1A1A1A]/30 opacity-50 cursor-not-allowed">
                                <div class="text-center">
                                    <svg class="mx-auto h-8 w-8 text-zinc-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="mt-4 flex text-sm leading-6 text-zinc-400">
                                        <span>Upload a file or drag and drop</span>
                                    </div>
                                    <p class="text-xs leading-5 text-zinc-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-8 flex items-center justify-end border-t border-zinc-800/50">
                    <button type="button" class="text-sm font-medium text-zinc-400 hover:text-white px-4 py-2 mr-2 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="inline-flex items-center justify-center rounded-lg bg-indigo-500 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 transition-all hover:shadow-[0_0_20px_rgba(99,102,241,0.3)]">
                        Create Trip
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
            <h1 class="text-3xl font-semibold tracking-tight text-white mb-3">Plan a new journey</h1>
            <p class="text-sm text-zinc-400 leading-relaxed">
                Define the parameters of your next adventure. Your workspace will automatically adapt to help you organize the itinerary, budget, and activities.
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
            destination: '{{ old('destination') }}',
            weather: null,
            loadingWeather: false,
            errorWeather: false,
            weatherTimeout: null,
            
            init() {
                if (this.destination) {
                    this.fetchWeather();
                }
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
                        const response = await fetch(`/trips/weather-preview?city=${encodeURIComponent(this.destination)}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        
                        if (!response.ok) throw new Error('Weather fetch failed');
                        
                        const data = await response.json();
                        
                        if (data.error) throw new Error(data.error);
                        
                        this.weather = data;
                    } catch (e) {
                        this.errorWeather = true;
                        this.weather = null;
                        console.error("Weather API Error:", e);
                    } finally {
                        this.loadingWeather = false;
                    }
                }, 800); // 800ms debounce
            }
        }));
    });
</script>
@endsection
