@extends('layouts.dashboard')

@section('workspace')
<div x-data="tripDetails({{ $trip->id }}, '{{ addslashes($trip->destination) }}')" class="min-h-full h-full bg-[#111111] text-white font-sans p-8 md:p-12 overflow-y-auto custom-scrollbar">
    <div class="max-w-5xl mx-auto space-y-8">
        
        <!-- NEXT DESTINATION (Hero) -->
        <section>
            <div class="mb-4">
                <span class="text-[10px] font-bold text-white/40 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-1 h-1 rounded-full bg-orange-500"></span> Next Destination
                </span>
            </div>
            
            <div class="relative w-full h-64 md:h-80 rounded-2xl overflow-hidden border border-white/10 group">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105" 
                     :style="coverImage ? `background-image: url(${coverImage})` : `background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&q=80&w=2000')`"></div>
                <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/30 to-transparent"></div>
                
                <!-- Image Upload Button -->
                <div class="absolute top-4 right-4 z-20">
                    <label class="cursor-pointer w-10 h-10 rounded-xl bg-black/50 backdrop-blur-md border border-white/10 flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 transition">
                        <input type="file" accept="image/*" class="hidden" @change="handleCoverUpload">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </label>
                </div>

                <div class="absolute inset-0 p-8 flex flex-col justify-end">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-orange-500/20 text-orange-400 text-[10px] font-bold uppercase tracking-wider rounded-full border border-orange-500/30 mb-3 backdrop-blur-md">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span>
                                In {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays(now()) }} Days
                            </span>
                            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight lowercase">{{ $trip->title }}</h1>
                            <div class="flex items-center gap-4 mt-3 text-white/70 text-sm font-medium lowercase">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                    {{ $trip->destination }}
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ \Carbon\Carbon::parse($trip->start_date)->format('M d') }}
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-black/40 backdrop-blur-md border border-white/10 rounded-xl px-4 py-2 text-center">
                                <span class="block text-[9px] text-white/50 uppercase font-bold tracking-wider mb-0.5">Duration</span>
                                <span class="text-sm font-semibold text-white">{{ \Carbon\Carbon::parse($trip->start_date)->diffInDays(\Carbon\Carbon::parse($trip->end_date)) }} Days</span>
                            </div>
                            <div class="bg-black/40 backdrop-blur-md border border-white/10 rounded-xl px-4 py-2 text-center">
                                <span class="block text-[9px] text-white/50 uppercase font-bold tracking-wider mb-0.5">Travelers</span>
                                <span class="text-sm font-semibold text-white">1 People</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Column 1 -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Row 1: Modified & Memories -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Recently Modified -->
                    <div>
                        <span class="text-[10px] font-bold text-white/40 uppercase tracking-widest flex items-center gap-2 mb-4">
                            <span class="w-1 h-1 rounded-full bg-orange-500"></span> Recently Modified
                        </span>
                        <div class="flex gap-4">
                            <!-- Start New Plan -->
                            <a href="/trips/create" class="flex-1 bg-[#1A1A1A] border border-dashed border-white/10 rounded-2xl flex flex-col items-center justify-center p-6 hover:border-white/30 hover:bg-white/5 transition group">
                                <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white/40 group-hover:text-white group-hover:bg-white/10 transition mb-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="text-sm font-semibold text-white/80 group-hover:text-white">Start New Plan</span>
                                <span class="text-[9px] text-white/40 uppercase tracking-wider mt-1">Ready for adventure?</span>
                            </a>
                            <!-- Active Trip Card -->
                            <div class="flex-1 bg-[#222] border border-white/5 rounded-2xl p-5 flex flex-col justify-between">
                                <div class="w-8 h-8 rounded-full bg-orange-500/20 text-orange-400 flex items-center justify-center mb-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-white lowercase">{{ $trip->title }}</h3>
                                    <p class="text-[10px] text-white/40 uppercase tracking-wider mt-1">{{ $trip->destination }}</p>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <span class="text-[10px] text-white/30">1 Hour Ago</span>
                                    <span class="text-[10px] font-bold text-white/60 flex items-center gap-1 hover:text-white cursor-pointer transition">Details <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Travel Memories -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[10px] font-bold text-white/40 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-1 h-1 rounded-full bg-blue-500"></span> Travel Memories
                                <span x-show="memoryImages.length > 0" class="text-[9px] text-white/30 ml-2" x-text="`${currentMemoryIndex + 1}/${memoryImages.length}`" x-cloak></span>
                            </span>
                            <label class="w-6 h-6 rounded-md bg-white/5 flex items-center justify-center hover:bg-white/10 transition cursor-pointer text-white/40 hover:text-white">
                                <input type="file" accept="image/*" class="hidden" @change="handleMemoryUpload">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </label>
                        </div>
                        <div class="w-full h-40 bg-[#222] border border-white/5 rounded-2xl overflow-hidden relative group">
                            <template x-if="memoryImages.length > 0">
                                <div class="w-full h-full relative">
                                    <img :src="memoryImages[currentMemoryIndex]" class="w-full h-full object-cover transition-opacity duration-300" />
                                    
                                    <!-- Arrows -->
                                    <div x-show="memoryImages.length > 1" class="absolute inset-0 flex items-center justify-between px-2 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                        <button @click="prevMemory" class="w-6 h-6 rounded-full bg-black/50 text-white flex items-center justify-center hover:bg-black/80 backdrop-blur-sm transition pointer-events-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                        </button>
                                        <button @click="nextMemory" class="w-6 h-6 rounded-full bg-black/50 text-white flex items-center justify-center hover:bg-black/80 backdrop-blur-sm transition pointer-events-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Delete Button -->
                                    <button @click="deleteMemory(currentMemoryIndex)" class="absolute top-2 right-2 w-6 h-6 rounded-full bg-red-500/80 text-white flex items-center justify-center hover:bg-red-600 opacity-0 group-hover:opacity-100 backdrop-blur-sm transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </template>
                            <template x-if="memoryImages.length === 0">
                                <div class="w-full h-full flex flex-col items-center justify-center text-white/20">
                                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-xs">No memories yet</span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Map & Weather -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Map -->
                    <div class="bg-[#222] border border-white/5 rounded-2xl overflow-hidden h-64 relative group">
                        <div class="absolute top-4 left-4 z-400 flex items-center gap-2 bg-black/80 backdrop-blur-md px-3 py-1.5 rounded-lg border border-white/10">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                            <span class="text-[10px] font-bold text-white uppercase tracking-wider">{{ $trip->destination }}</span>
                        </div>
                        <!-- Using iframe mapping instead of leaflet to avoid script re-evaluation issues in SPA -->
                        <iframe 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            style="border:0; filter: invert(90%) hue-rotate(180deg) brightness(80%) contrast(120%);"
                            :src="`https://maps.google.com/maps?q=${encodeURIComponent('{{ addslashes($trip->destination) }}')}&t=&z=13&ie=UTF8&iwloc=&output=embed`" 
                            allowfullscreen>
                        </iframe>
                    </div>

                    <!-- Weather -->
                    <div class="bg-[#222] border border-white/5 rounded-2xl p-5 flex flex-col">
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-[10px] font-bold text-white/40 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-1 h-1 rounded-full bg-blue-400"></span> Weather
                            </span>
                            <button @click="fetchForecast()" class="w-6 h-6 rounded-md bg-white/5 flex items-center justify-center hover:bg-white/10 transition text-white/40 hover:text-white">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </button>
                        </div>
                        
                        <div class="flex-1 flex justify-between items-center px-2">
                            <template x-for="day in forecast" :key="day.date">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="text-[10px] font-bold text-white/40 uppercase" x-text="new Date(day.date).toLocaleDateString('en-US', {weekday: 'short'})"></span>
                                    <span class="text-2xl" x-text="day.icon"></span>
                                    <span class="text-sm font-bold text-white" x-text="day.temperature + '°'"></span>
                                </div>
                            </template>
                            <template x-if="forecast.length === 0">
                                <div class="w-full text-center text-white/30 text-xs">Loading forecast...</div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Experience Center -->
                <div class="mt-6 bg-[#222] border border-white/5 rounded-2xl p-6 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-bold text-white/40 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-indigo-500"></span> Experience Center
                        </span>
                        <span class="text-[9px] font-bold bg-indigo-500/20 text-indigo-400 px-2.5 py-1 rounded-md uppercase tracking-wider" x-text="`climate: ${detectedLocationType}`"></span>
                    </div>
                    
                    <div class="mb-5">
                        <h3 class="text-lg font-bold text-white tracking-tight lowercase">recommended local activities</h3>
                        <p class="text-xs text-white/40 mt-1 leading-relaxed">custom adventures picked based on weather conditions and geography of {{ $trip->destination }}.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="act in recommendedActivities" :key="act.name">
                            <div class="bg-white/2 border border-white/5 rounded-xl hover:border-indigo-500/30 transition flex flex-col justify-between group relative overflow-hidden h-56">
                                <!-- Card Background Image -->
                                <img :src="act.image" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="">
                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-linear-to-t from-black/90 via-black/30 to-transparent z-0"></div>
                                
                                <!-- Top Metadata -->
                                <div class="relative z-10 p-4 flex justify-between items-start">
                                    <span class="px-2 py-0.5 rounded bg-black/60 border border-white/10 text-[9px] font-bold text-white/90 uppercase tracking-wider" x-text="act.category"></span>
                                    <span class="text-lg bg-black/60 backdrop-blur-xs w-7 h-7 rounded-lg flex items-center justify-center border border-white/10" x-text="act.icon"></span>
                                </div>
                                
                                <!-- Bottom Content -->
                                <div class="relative z-10 p-4 pt-0 space-y-2">
                                    <div>
                                        <h4 class="text-xs font-bold text-white tracking-tight lowercase" x-text="act.name"></h4>
                                        <p class="text-[10px] text-white/60 mt-1 leading-normal lowercase" x-text="act.description"></p>
                                    </div>
                                    
                                    <div class="flex items-center justify-between pt-2 border-t border-white/10 mt-1">
                                        <div class="flex items-center gap-0.5 text-xs font-bold text-white">
                                            <span class="text-orange-500">₹</span>
                                            <span x-text="act.cost.toLocaleString('en-IN')"></span>
                                        </div>
                                        <button @click.stop="addActivityToBudget(act.name, act.cost)" class="text-[9px] font-bold bg-white text-black hover:bg-indigo-500 hover:text-white px-2.5 py-1 rounded-md transition flex items-center gap-1 active:scale-95 shadow-lg">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg> add to budget
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

            <!-- Column 2 (Right Side) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Budget Center -->
                <div class="bg-[#222] border border-white/5 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] font-bold text-white/40 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-orange-500"></span> Budget Center
                        </span>
                        <span class="text-[9px] font-bold bg-green-500/20 text-green-400 px-2 py-1 rounded-md uppercase">Managing</span>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-center text-3xl font-bold text-white tracking-tight">
                            <span class="text-orange-500 mr-1">₹</span>
                            <input type="number" x-model="budgetTotal" @change="saveBudget" class="bg-transparent border-none p-0 focus:ring-0 w-32 font-bold text-3xl">
                        </div>
                    </div>

                    <div class="space-y-4 max-h-48 overflow-y-auto custom-scrollbar pr-2 mb-4">
                        <template x-for="item in budgetItems" :key="item.id">
                            <div class="group relative">
                                <div class="flex items-center justify-between mb-1.5">
                                    <div class="flex items-center gap-2 text-xs font-semibold text-white/80">
                                        <div class="w-2 h-2 rounded-full" :style="`background-color: ${item.color}`"></div>
                                        <span x-text="item.name"></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center gap-1 text-xs font-bold">
                                            <span class="text-white/80">₹</span>
                                            <input type="number" x-model="item.amount" @change="saveBudget" class="bg-transparent border-none p-0 focus:ring-0 w-16 text-right text-xs text-white">
                                        </div>
                                        <button @click="deleteBudgetItem(item.id)" class="opacity-0 group-hover:opacity-100 text-white/20 hover:text-red-400 transition w-4 h-4">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="w-full bg-white/5 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full" :style="`background-color: ${item.color}; width: ${Math.min((item.amount / budgetTotal) * 100, 100)}%`"></div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <form @submit.prevent="addBudgetItem" class="flex items-center gap-2 mt-4 pt-4 border-t border-white/5">
                        <input type="text" x-model="newBudgetName" placeholder="Expense name..." required class="w-1/2 bg-white/5 border border-white/10 rounded-lg px-3 py-1.5 text-xs text-white focus:outline-none focus:border-orange-500 transition placeholder:text-white/30">
                        <input type="number" x-model="newBudgetAmount" placeholder="Amount..." required class="w-1/3 bg-white/5 border border-white/10 rounded-lg px-3 py-1.5 text-xs text-white focus:outline-none focus:border-orange-500 transition placeholder:text-white/30">
                        <button type="submit" class="w-auto bg-white/10 hover:bg-white/20 text-white rounded-lg px-3 py-1.5 text-xs font-semibold transition">Add</button>
                    </form>
                </div>

                <!-- Mandatory List -->
                <div class="bg-[#222] border border-white/5 rounded-2xl p-6 flex flex-col h-72">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-bold text-white/40 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-purple-500"></span> Mandatory List
                        </span>
                        <span class="text-[9px] font-bold bg-white/5 text-white/60 px-2 py-1 rounded-md" x-text="essentials.filter(e => e.done).length + '/' + essentials.length"></span>
                    </div>
                    
                    <div class="flex-1 overflow-y-auto pr-2 space-y-2 sidebar-scroll">
                        <template x-for="item in essentials" :key="item.id">
                            <div class="flex items-center gap-3 p-3 rounded-xl border border-white/5 bg-white/2 hover:bg-white/5 transition group">
                                <button @click="toggleEssential(item.id)" class="w-5 h-5 rounded-full border border-white/20 flex items-center justify-center shrink-0" :class="item.done ? 'bg-orange-500 border-orange-500' : ''">
                                    <svg x-show="item.done" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                                <span class="text-xs font-semibold text-white/80 flex-1 truncate" :class="item.done ? 'line-through opacity-50' : ''" x-text="item.text"></span>
                                <button @click="essentials = essentials.filter(e => e.id !== item.id); saveEssentials()" class="opacity-0 group-hover:opacity-100 text-white/20 hover:text-red-400 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </template>
                    </div>

                    <form @submit.prevent="addEssential" class="mt-4 flex items-center gap-2">
                        <input type="text" x-model="newEssential" placeholder="essential item..." class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-xs text-white focus:outline-none focus:border-orange-500 transition placeholder:text-white/30">
                        <button type="submit" class="w-9 h-9 rounded-xl bg-white text-black flex items-center justify-center hover:bg-white/80 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Bottom Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-12">
            <!-- QUICK WORKSPACE ACTIONS -->
            <div class="bg-[#1A1A1A] border border-zinc-800 rounded-2xl p-6 shadow-inner">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-5">Quick Workspace Actions</h3>
                
                <div class="space-y-3">
                    <a href="/trips/create" class="flex items-center justify-between p-3 rounded-xl hover:bg-zinc-800/50 transition group border border-transparent hover:border-zinc-800">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-zinc-800 flex items-center justify-center text-zinc-400 group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-white group-hover:text-indigo-400 transition">Plan Next Journey</div>
                                <div class="text-xs text-zinc-500 mt-0.5">Launch the creation module</div>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-zinc-600 group-hover:text-zinc-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    
                    <a href="/search" class="flex items-center justify-between p-3 rounded-xl hover:bg-zinc-800/50 transition group border border-transparent hover:border-zinc-800">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-zinc-800 flex items-center justify-center text-zinc-400 group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-white group-hover:text-indigo-400 transition">Global Command Search</div>
                                <div class="text-xs text-zinc-500 mt-0.5">Search tags, descriptions, destinations</div>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-zinc-600 group-hover:text-zinc-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    
                    <a href="/filters" class="flex items-center justify-between p-3 rounded-xl hover:bg-zinc-800/50 transition group border border-transparent hover:border-zinc-800">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-zinc-800 flex items-center justify-center text-zinc-400 group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-white group-hover:text-indigo-400 transition">Manage Tags & Labels</div>
                                <div class="text-xs text-zinc-500 mt-0.5">Review dynamic category filters</div>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-zinc-600 group-hover:text-zinc-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <!-- HOW TO PLAN A TRIP -->
            <div class="bg-[#1A1A1A] border border-zinc-800 rounded-2xl p-6 shadow-inner relative overflow-hidden group flex flex-col justify-between">
                <div>
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-1">How To Plan A Trip</h3>
                    <p class="text-xs text-zinc-500 mb-6">Key milestones for crafting travel itineraries.</p>
                    
                    <div class="space-y-5">
                        <div class="flex gap-4">
                            <div class="w-6 h-6 rounded-full bg-zinc-800 flex items-center justify-center text-xs font-bold text-zinc-400 shrink-0">1</div>
                            <div>
                                <div class="text-sm font-semibold text-white">Create a destination</div>
                                <div class="text-xs text-zinc-500 mt-1">Name your journey, add dates, and geocode dynamic current weather.</div>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-6 h-6 rounded-full bg-zinc-800 flex items-center justify-center text-xs font-bold text-zinc-400 shrink-0">2</div>
                            <div>
                                <div class="text-sm font-semibold text-white">Categorize with tags</div>
                                <div class="text-xs text-zinc-500 mt-1">Tag with preset labels like Solo Travel or Relaxation for instant filtering.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <a href="/get-started" class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-white rounded-lg text-xs font-semibold transition border border-zinc-700 inline-flex items-center gap-2">
                        Open Setup Guide
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
// We use a global function to define the alpine data to ensure it works properly inside the SPA layout
if (typeof tripDetails !== 'function') {
    window.tripDetails = function(tripId, destination) {
        return {
            coverImage: localStorage.getItem('trip_' + tripId + '_cover') || null,
            memoryImages: JSON.parse(localStorage.getItem('trip_' + tripId + '_memories')) || [],
            currentMemoryIndex: 0,
            budgetTotal: localStorage.getItem('trip_' + tripId + '_budget_total') || 150000,
            budgetItems: JSON.parse(localStorage.getItem('trip_' + tripId + '_budget_items')) || [
                { id: 1, name: 'Flights', amount: 63800, color: '#3b82f6' },
                { id: 2, name: 'Hotel', amount: 50000, color: '#f97316' },
                { id: 3, name: 'Food', amount: 37600, color: '#ef4444' }
            ],
            newBudgetName: '',
            newBudgetAmount: '',
            newEssential: '',
            essentials: JSON.parse(localStorage.getItem('trip_' + tripId + '_essentials')) || [
                { id: 1, text: 'PASSPORT & ID', done: true },
                { id: 2, text: 'TRAVEL TICKETS', done: false }
            ],
            forecast: [],
            
            init() {
                // Check if a draft cover was uploaded during creation
                const draftCover = localStorage.getItem('trip_draft_cover');
                if (draftCover && !this.coverImage) {
                    this.coverImage = draftCover;
                    localStorage.setItem('trip_' + tripId + '_cover', draftCover);
                    localStorage.removeItem('trip_draft_cover'); // clear it
                }
                
                // Migrate single memory image to array if necessary
                const oldMemory = localStorage.getItem('trip_' + tripId + '_memory');
                if (oldMemory && this.memoryImages.length === 0) {
                    this.memoryImages.push(oldMemory);
                    localStorage.setItem('trip_' + tripId + '_memories', JSON.stringify(this.memoryImages));
                    localStorage.removeItem('trip_' + tripId + '_memory');
                }
                
                this.fetchForecast();
            },
            
            fetchForecast() {
                fetch(`/trips/weather-forecast?city=${encodeURIComponent(destination)}`)
                    .then(res => res.json())
                    .then(data => {
                        if(!data.error) {
                            this.forecast = data;
                        }
                    });
            },

            get detectedLocationType() {
                const dest = destination.toLowerCase();
                const temp = this.forecast.length > 0 ? this.forecast[0].temperature : null;
                
                if (temp !== null && temp < 12) {
                    return 'cold';
                }
                
                if (dest.includes('beach') || dest.includes('goa') || dest.includes('bali') || 
                    dest.includes('hawaii') || dest.includes('maldives') || dest.includes('phuket') || 
                    dest.includes('pattaya') || dest.includes('island') || dest.includes('coast') || 
                    dest.includes('sea') || dest.includes('ocean') || dest.includes('miami')) {
                    return 'beach';
                }
                
                if (temp !== null && temp >= 26) {
                    return 'warm';
                }
                
                return 'scenic';
            },
            
            get isDomestic() {
                const dest = destination.toLowerCase();
                const indianKeywords = [
                    'india', 'goa', 'mumbai', 'delhi', 'kerala', 'rajasthan', 'bangalore', 
                    'chennai', 'kolkata', 'jaipur', 'agra', 'manali', 'shimla', 'ladakh', 
                    'srinagar', 'leh', 'rishikesh', 'pondicherry', 'hampi', 'varanasi',
                    'pune', 'hyderabad', 'amritsar', 'darjeeling', 'ooty', 'munnar'
                ];
                return indianKeywords.some(keyword => dest.includes(keyword));
            },

            get recommendedActivities() {
                const type = this.detectedLocationType;
                const isDom = this.isDomestic;
                
                if (type === 'cold') {
                    return [
                        { name: 'Ice Skating', category: '❄️ Winter Sport', cost: isDom ? 800 : 3200, icon: '⛸️', image: 'https://loremflickr.com/600/450/ice-skating,winter?random=' + tripId, description: 'Glide across frozen lakes and scenic ice rinks.' },
                        { name: 'Snowboarding / Skiing', category: '❄️ Winter Sport', cost: isDom ? 3500 : 12500, icon: '🏂', image: 'https://loremflickr.com/600/450/snowboarding,skiing?random=' + tripId, description: 'Shred down fresh powder slopes with professional gear.' },
                        { name: 'Alpine Gondola Ride', category: '⛰️ Scenic view', cost: isDom ? 1200 : 6500, icon: '🚠', image: 'https://loremflickr.com/600/450/gondola-lift,mountain?random=' + tripId, description: 'Soar above snow-covered peaks and evergreen forests.' },
                        { name: 'Hot Chocolate Tasting', category: '☕ Culinary', cost: isDom ? 350 : 1200, icon: '🍫', image: 'https://loremflickr.com/600/450/hot-chocolate?random=' + tripId, description: 'Cozy up in a mountainside chalet with premium warm cocoa.' },
                        { name: 'Geothermal Spa Soak', category: '♨️ Relaxation', cost: isDom ? 2500 : 9500, icon: '🧖', image: 'https://loremflickr.com/600/450/hot-spring?random=' + tripId, description: 'Unwind in steaming hot mineral pools amidst freezing air.' },
                    ];
                } else if (type === 'beach') {
                    return [
                        { name: 'Surfing Lesson', category: '🌊 Aquatic', cost: isDom ? 1500 : 5500, icon: '🏄', image: 'https://loremflickr.com/600/450/surfing,beach?random=' + tripId, description: 'Catch your first waves with certified local instructors.' },
                        { name: 'Scuba Diving / Snorkeling', category: '🤿 Aquatic', cost: isDom ? 4500 : 15000, icon: '🐠', image: 'https://loremflickr.com/600/450/scuba-diving,snorkeling?random=' + tripId, description: 'Explore vibrant coral reefs and swim with tropical marine life.' },
                        { name: 'Jet Ski Adventure', category: '⚡ Water Sport', cost: isDom ? 2000 : 7500, icon: '🚀', image: 'https://loremflickr.com/600/450/jet-ski?random=' + tripId, description: 'Feel the thrill of speeding across the ocean surface.' },
                        { name: 'Sunset Beach Yoga', category: '🧘 Wellness', cost: isDom ? 500 : 2500, icon: '🌅', image: 'https://loremflickr.com/600/450/beach-yoga?random=' + tripId, description: 'Realign your body and mind to the gentle sound of ocean waves.' },
                        { name: 'Island Boat Cruise', category: '⛵ Sightseeing', cost: isDom ? 3000 : 12000, icon: '🛥️', image: 'https://loremflickr.com/600/450/boat-cruise,ocean?random=' + tripId, description: 'Sail to hidden lagoons and remote beaches with lunch included.' },
                    ];
                } else if (type === 'warm') {
                    return [
                        { name: 'Skateboarding Park Tour', category: '🛹 Street Sport', cost: isDom ? 300 : 2000, icon: '🛹', image: 'https://loremflickr.com/600/450/skateboarding?random=' + tripId, description: 'Explore high-end local skateparks and urban spots.' },
                        { name: 'Hot Air Balloon Ride', category: '🎈 Adventure', cost: isDom ? 8500 : 28000, icon: '🎈', image: 'https://loremflickr.com/600/450/hot-air-balloon?random=' + tripId, description: 'Float gently above beautiful valleys at sunrise.' },
                        { name: 'Historic Walking Tour', category: '🏛️ Culture', cost: isDom ? 600 : 3500, icon: '🚶', image: 'https://loremflickr.com/600/450/historic-street?random=' + tripId, description: 'Discover ancient architecture and street art with a guide.' },
                        { name: 'Fruit & Flower Picking', category: '🌸 Agriculture', cost: isDom ? 450 : 2500, icon: '🍓', image: 'https://loremflickr.com/600/450/flower-picking?random=' + tripId, description: 'Pluck fresh local berries and orchids in organic fields.' },
                        { name: 'Night Street Food Crawl', category: '🍜 Culinary', cost: isDom ? 900 : 4800, icon: '🍢', image: 'https://loremflickr.com/600/450/street-food?random=' + tripId, description: 'Savor exotic local delicacies across vibrant night markets.' },
                    ];
                } else {
                    return [
                        { name: 'Sightseeing & Photography', category: '📸 Scenic', cost: isDom ? 500 : 3000, icon: '🗼', image: 'https://loremflickr.com/600/450/sightseeing,monument?random=' + tripId, description: 'Visit iconic cultural landmarks and capture breathtaking views.' },
                        { name: 'Hot Air Balloon Ride', category: '🎈 Adventure', cost: isDom ? 7500 : 25000, icon: '🎈', image: 'https://loremflickr.com/600/450/hot-air-balloon?random=' + tripId, description: 'Drift over majestic mountain vistas and valleys.' },
                        { name: 'Flower Picking / Botanical Tour', category: '🌸 Nature', cost: isDom ? 400 : 2200, icon: '🌻', image: 'https://loremflickr.com/600/450/botanical-garden?random=' + tripId, description: 'Wander through cherry blossom gardens or lavender fields.' },
                        { name: 'Skateboarding & Cycling', category: '🛹 Activity', cost: isDom ? 350 : 1800, icon: '🛹', image: 'https://loremflickr.com/600/450/cycling?random=' + tripId, description: 'Rent a premium cruiser board or bicycle along scenic riversides.' },
                        { name: 'Sunset Hill Hiking', category: '⛰️ Nature', cost: isDom ? 200 : 1500, icon: '🥾', image: 'https://loremflickr.com/600/450/hiking,sunset?random=' + tripId, description: 'Trek up popular panoramic lookout points for a perfect sunset.' },
                    ];
                }
            },
            
            addActivityToBudget(name, cost) {
                const colors = ['#3b82f6', '#f97316', '#ef4444', '#22c55e', '#a855f7', '#ec4899', '#eab308'];
                const color = colors[Math.floor(Math.random() * colors.length)];
                
                this.budgetItems.push({
                    id: Date.now(),
                    name: name,
                    amount: cost,
                    color: color
                });
                
                this.saveBudget();
                alert(`"${name}" added to your Budget Center!`);
            },
            
            handleCoverUpload(e) {
                const file = e.target.files[0];
                if(file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.coverImage = e.target.result;
                        localStorage.setItem('trip_' + tripId + '_cover', this.coverImage);
                    };
                    reader.readAsDataURL(file);
                }
            },
            
            handleMemoryUpload(e) {
                const file = e.target.files[0];
                if(file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.memoryImages.push(e.target.result);
                        this.currentMemoryIndex = this.memoryImages.length - 1;
                        localStorage.setItem('trip_' + tripId + '_memories', JSON.stringify(this.memoryImages));
                    };
                    reader.readAsDataURL(file);
                }
            },
            
            nextMemory() {
                if(this.memoryImages.length > 1) {
                    this.currentMemoryIndex = (this.currentMemoryIndex + 1) % this.memoryImages.length;
                }
            },
            
            prevMemory() {
                if(this.memoryImages.length > 1) {
                    this.currentMemoryIndex = (this.currentMemoryIndex - 1 + this.memoryImages.length) % this.memoryImages.length;
                }
            },
            
            deleteMemory(index) {
                this.memoryImages.splice(index, 1);
                if (this.currentMemoryIndex >= this.memoryImages.length) {
                    this.currentMemoryIndex = Math.max(0, this.memoryImages.length - 1);
                }
                localStorage.setItem('trip_' + tripId + '_memories', JSON.stringify(this.memoryImages));
            },

            saveBudget() {
                localStorage.setItem('trip_' + tripId + '_budget_total', this.budgetTotal);
                localStorage.setItem('trip_' + tripId + '_budget_items', JSON.stringify(this.budgetItems));
            },
            
            addBudgetItem() {
                if (this.newBudgetName.trim() && this.newBudgetAmount) {
                    const colors = ['#3b82f6', '#f97316', '#ef4444', '#22c55e', '#a855f7', '#ec4899', '#eab308'];
                    const color = colors[Math.floor(Math.random() * colors.length)];
                    this.budgetItems.push({
                        id: Date.now(),
                        name: this.newBudgetName.trim(),
                        amount: parseFloat(this.newBudgetAmount),
                        color: color
                    });
                    this.newBudgetName = '';
                    this.newBudgetAmount = '';
                    this.saveBudget();
                }
            },
            
            deleteBudgetItem(id) {
                this.budgetItems = this.budgetItems.filter(i => i.id !== id);
                this.saveBudget();
            },

            addEssential() {
                if(this.newEssential.trim() !== '') {
                    this.essentials.push({ id: Date.now(), text: this.newEssential.trim(), done: false });
                    this.newEssential = '';
                    this.saveEssentials();
                }
            },

            toggleEssential(id) {
                const item = this.essentials.find(e => e.id === id);
                if(item) {
                    item.done = !item.done;
                    this.saveEssentials();
                }
            },

            saveEssentials() {
                localStorage.setItem('trip_' + tripId + '_essentials', JSON.stringify(this.essentials));
            }
        };
    };
}
</script>
@endsection
