@extends('layouts.dashboard')

@section('workspace')
<div class="p-8 side">
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
                        <a href="/trips/1" class="inline-block bg-white text-black hover:bg-gray-200 px-6 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm active:scale-95 w-full md:w-auto text-center">
                            Open Itinerary
                        </a>
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
@endsection
