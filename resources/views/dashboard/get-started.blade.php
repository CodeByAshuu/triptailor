@extends('layouts.dashboard')

@section('workspace')
<div class="p-8 side">
    <div class="max-w-5xl mx-auto space-y-16 pb-12">
        
        <!-- Hero Section -->
        <section class="text-center md:text-left flex flex-col md:flex-row items-center gap-10">
            <div class="flex-1 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-orange-500/10 border border-orange-500/20 rounded-full text-[10px] font-bold uppercase tracking-widest text-orange-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse shadow-[0_0_8px_rgba(251,146,60,0.8)]"></span>
                    Welcome to TripTailor
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl text-white tracking-tight leading-[1.1]">
                    Design your perfect journey.
                </h1>
                <p class="text-lg text-white/50 leading-relaxed max-w-xl">
                    TripTailor is your calm, structured workspace for planning travels. Organize destinations, map out daily activities, and bring your itinerary to life.
                </p>
                <div class="pt-4 flex flex-wrap gap-4">
                    <a href="/trips/create" class="inline-flex items-center justify-center gap-2 bg-white text-black px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition shadow-[0_0_20px_rgba(255,255,255,0.1)] active:scale-95">
                        Create Your First Trip
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="/explore" class="inline-flex items-center justify-center gap-2 bg-white/5 text-white border border-white/10 px-6 py-3 rounded-xl font-medium hover:bg-white/10 transition active:scale-95">
                        Explore Templates
                    </a>
                </div>
            </div>
            
            <div class="w-full md:w-[40%] relative hidden md:block">
               <div class="absolute inset-0 bg-orange-500/20 blur-[100px] rounded-full pointer-events-none"></div>
               <!-- Workflow Visual -->
               <div class="relative bg-[#1A1A1A] border border-white/10 rounded-2xl p-6 shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-500">
                   <div class="flex items-center justify-between mb-6">
                       <div class="h-5 w-1/3 bg-white/20 rounded-md"></div>
                       <div class="w-6 h-6 rounded-full bg-white/10"></div>
                   </div>
                   <div class="space-y-3">
                       <div class="h-12 w-full bg-white/5 border border-white/5 rounded-lg flex items-center px-3 gap-3">
                           <div class="w-4 h-4 rounded-sm bg-orange-500/50"></div>
                           <div class="h-3 w-1/2 bg-white/20 rounded"></div>
                       </div>
                       <div class="h-12 w-full bg-white/5 border border-white/5 rounded-lg flex items-center px-3 gap-3">
                           <div class="w-4 h-4 rounded-sm bg-blue-500/50"></div>
                           <div class="h-3 w-2/3 bg-white/20 rounded"></div>
                       </div>
                       <div class="h-12 w-3/4 bg-white/5 border border-white/5 rounded-lg flex items-center px-3 gap-3">
                           <div class="w-4 h-4 rounded-sm bg-green-500/50"></div>
                           <div class="h-3 w-1/3 bg-white/20 rounded"></div>
                       </div>
                   </div>
               </div>
            </div>
        </section>

        <!-- Step-by-Step Section -->
        <section>
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white tracking-tight">How it works</h2>
                <p class="text-white/40 mt-1">A simple framework for complex itineraries.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5" x-data="{ activeStep: 1 }">
                <!-- Step 1 -->
                <div class="group relative bg-[#1E1E1E] border rounded-2xl p-6 transition-all cursor-pointer overflow-hidden"
                     :class="activeStep === 1 ? 'border-orange-500/30 bg-orange-500/5 shadow-lg shadow-orange-500/5' : 'border-white/5 hover:border-white/10'"
                     @mouseenter="activeStep = 1">
                    <div class="absolute top-0 right-0 p-6 opacity-[0.03] group-hover:opacity-[0.06] transition text-8xl font-black text-white pointer-events-none -mt-4 -mr-2">1</div>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center border mb-5 relative z-10 transition-transform duration-300 group-hover:scale-110"
                         :class="activeStep === 1 ? 'bg-orange-500/20 text-orange-400 border-orange-500/30' : 'bg-white/5 text-white/40 border-white/10 group-hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white/90 relative z-10 mb-2">Create a trip workspace</h3>
                    <p class="text-sm text-white/40 leading-relaxed relative z-10">Set a title, choose your destination, and define your travel dates to generate a dedicated workspace for your journey.</p>
                </div>
                
                <!-- Step 2 -->
                <div class="group relative bg-[#1E1E1E] border rounded-2xl p-6 transition-all cursor-pointer overflow-hidden"
                     :class="activeStep === 2 ? 'border-blue-500/30 bg-blue-500/5 shadow-lg shadow-blue-500/5' : 'border-white/5 hover:border-white/10'"
                     @mouseenter="activeStep = 2">
                    <div class="absolute top-0 right-0 p-6 opacity-[0.03] group-hover:opacity-[0.06] transition text-8xl font-black text-white pointer-events-none -mt-4 -mr-2">2</div>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center border mb-5 relative z-10 transition-transform duration-300 group-hover:scale-110"
                         :class="activeStep === 2 ? 'bg-blue-500/20 text-blue-400 border-blue-500/30' : 'bg-white/5 text-white/40 border-white/10 group-hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white/90 relative z-10 mb-2">Add itinerary days</h3>
                    <p class="text-sm text-white/40 leading-relaxed relative z-10">Organize your plans day-wise. Create a structured travel schedule that maps out exactly what you'll do and when.</p>
                </div>

                <!-- Step 3 -->
                <div class="group relative bg-[#1E1E1E] border rounded-2xl p-6 transition-all cursor-pointer overflow-hidden"
                     :class="activeStep === 3 ? 'border-green-500/30 bg-green-500/5 shadow-lg shadow-green-500/5' : 'border-white/5 hover:border-white/10'"
                     @mouseenter="activeStep = 3">
                    <div class="absolute top-0 right-0 p-6 opacity-[0.03] group-hover:opacity-[0.06] transition text-8xl font-black text-white pointer-events-none -mt-4 -mr-2">3</div>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center border mb-5 relative z-10 transition-transform duration-300 group-hover:scale-110"
                         :class="activeStep === 3 ? 'bg-green-500/20 text-green-400 border-green-500/30' : 'bg-white/5 text-white/40 border-white/10 group-hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white/90 relative z-10 mb-2">Populate activities</h3>
                    <p class="text-sm text-white/40 leading-relaxed relative z-10">Add sightseeing spots, hotels, restaurants, and transport details. Attach notes and links to keep everything in one place.</p>
                </div>

                <!-- Step 4 -->
                <div class="group relative bg-[#1E1E1E] border rounded-2xl p-6 transition-all cursor-pointer overflow-hidden"
                     :class="activeStep === 4 ? 'border-purple-500/30 bg-purple-500/5 shadow-lg shadow-purple-500/5' : 'border-white/5 hover:border-white/10'"
                     @mouseenter="activeStep = 4">
                    <div class="absolute top-0 right-0 p-6 opacity-[0.03] group-hover:opacity-[0.06] transition text-8xl font-black text-white pointer-events-none -mt-4 -mr-2">4</div>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center border mb-5 relative z-10 transition-transform duration-300 group-hover:scale-110"
                         :class="activeStep === 4 ? 'bg-purple-500/20 text-purple-400 border-purple-500/30' : 'bg-white/5 text-white/40 border-white/10 group-hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white/90 relative z-10 mb-2">Manage and refine</h3>
                    <p class="text-sm text-white/40 leading-relaxed relative z-10">Update plans on the fly. Move activities around with ease, sync with friends, and save your perfect itinerary.</p>
                </div>
            </div>
        </section>

        <!-- Helpful Tips Section -->
        <section class="bg-linear-to-br from-[#1A1A1A] to-[#222222] border border-white/5 rounded-3xl p-8 md:p-10 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500/10 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/4 pointer-events-none group-hover:bg-orange-500/20 transition-colors duration-700"></div>
            <div class="relative z-10 flex flex-col md:flex-row gap-10">
                <div class="md:w-1/3">
                    <div class="w-12 h-12 rounded-xl bg-yellow-500/10 text-yellow-500 flex items-center justify-center border border-yellow-500/20 mb-5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white tracking-tight mb-2">Pro Tips</h3>
                    <p class="text-sm text-white/50 leading-relaxed">Maximize your productivity and travel seamlessly with these curated workflow strategies.</p>
                </div>
                <div class="md:w-2/3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white/5 border border-white/5 rounded-2xl p-5 hover:bg-white/10 transition">
                        <h4 class="text-sm font-semibold text-white/90 mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-400"></span> Buffer Time
                        </h4>
                        <p class="text-xs text-white/40 leading-relaxed">Always add 30-45 minutes between major activities for transit and unexpected delays.</p>
                    </div>
                    <div class="bg-white/5 border border-white/5 rounded-2xl p-5 hover:bg-white/10 transition">
                        <h4 class="text-sm font-semibold text-white/90 mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-400"></span> Group by Area
                        </h4>
                        <p class="text-xs text-white/40 leading-relaxed">Organize your daily activities geographically to minimize travel time across the city.</p>
                    </div>
                    <div class="bg-white/5 border border-white/5 rounded-2xl p-5 hover:bg-white/10 transition">
                        <h4 class="text-sm font-semibold text-white/90 mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-purple-400"></span> Use Labels
                        </h4>
                        <p class="text-xs text-white/40 leading-relaxed">Tag activities with labels (e.g., "Food", "Sightseeing") for quick filtering later.</p>
                    </div>
                    <div class="bg-white/5 border border-white/5 rounded-2xl p-5 hover:bg-white/10 transition">
                        <h4 class="text-sm font-semibold text-white/90 mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-orange-400"></span> Save Links
                        </h4>
                        <p class="text-xs text-white/40 leading-relaxed">Drop booking references and map links directly into activity notes for quick access.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="border-t border-white/5 pt-10">
            <h2 class="text-xs font-bold text-white/30 uppercase tracking-widest mb-6">Quick Navigation</h2>
            <div class="flex flex-wrap gap-4">
                <a href="/trips/create" class="flex items-center gap-3 px-5 py-3.5 bg-[#1E1E1E] border border-white/5 rounded-xl hover:border-white/20 hover:bg-white/5 transition group">
                    <svg class="w-5 h-5 text-white/40 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span class="text-sm font-medium text-white/70 group-hover:text-white transition">Create New Trip</span>
                </a>
                <a href="/explore" class="flex items-center gap-3 px-5 py-3.5 bg-[#1E1E1E] border border-white/5 rounded-xl hover:border-white/20 hover:bg-white/5 transition group">
                    <svg class="w-5 h-5 text-white/40 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span class="text-sm font-medium text-white/70 group-hover:text-white transition">Explore Templates</span>
                </a>
                <a href="/dashboard" class="flex items-center gap-3 px-5 py-3.5 bg-[#1E1E1E] border border-white/5 rounded-xl hover:border-white/20 hover:bg-white/5 transition group">
                    <svg class="w-5 h-5 text-white/40 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    <span class="text-sm font-medium text-white/70 group-hover:text-white transition">Back to Dashboard</span>
                </a>
            </div>
        </section>

    </div>
</div>
@endsection
