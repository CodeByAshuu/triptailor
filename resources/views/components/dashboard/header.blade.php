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
