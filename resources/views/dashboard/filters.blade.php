@extends('layouts.dashboard')

@section('workspace')
<div class="p-8 side">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 border-b border-white/5 pb-5">
            <h1 class="text-3xl font-bold text-white tracking-tight">Filters & Labels</h1>
            <p class="text-white/40 mt-2">Organize your trips with custom labels and smart filters.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="col-span-2 space-y-6">
                <!-- Labels -->
                <div class="bg-[#1E1E1E] border border-white/5 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-white/90">Your Labels</h3>
                        <button class="text-sm font-medium text-orange-400 hover:text-orange-300 transition">+ New Label</button>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-500/10 text-blue-400 text-sm font-medium rounded-lg border border-blue-500/20 cursor-pointer hover:bg-blue-500/20 transition">Family</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-500/10 text-green-400 text-sm font-medium rounded-lg border border-green-500/20 cursor-pointer hover:bg-green-500/20 transition">Work</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-500/10 text-purple-400 text-sm font-medium rounded-lg border border-purple-500/20 cursor-pointer hover:bg-purple-500/20 transition">Solo Travel</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/5 text-white/60 text-sm font-medium rounded-lg border border-white/10 cursor-pointer hover:bg-white/10 transition">Archive</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
