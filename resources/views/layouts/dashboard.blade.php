@extends('layouts.app')

@section('content')
<!-- Application Shell -->
<div x-data="workspaceApp()" class="flex min-h-screen bg-[#1A1A1A] text-white font-sans antialiased selection:bg-orange-500/30">
    
    <!-- Sidebar Component -->
    <x-dashboard.sidebar :trips="$trips ?? []" />

    <!-- Main Workspace -->
    <main class="flex-1 min-h-screen flex flex-col relative min-w-0 bg-[#1A1A1A]">
        
        <!-- Header Component -->
        <x-dashboard.header />

        <!-- Dynamic Workspace Container -->
        <div id="workspace-container" class="flex-1 overflow-y-auto relative custom-scrollbar transition-opacity duration-200" :class="{ 'opacity-50 pointer-events-none': loading }">
            @yield('workspace')
        </div>

    </main>

    <!-- Alpine.js Workspace Logic -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('workspaceApp', () => ({
                sidebarOpen: true,
                activeTripMenu: null,
                loading: false,

                init() {
                    // Intercept clicks for workspace navigation
                    document.body.addEventListener('click', (e) => {
                        let link = e.target.closest('a');
                        
                        // Ignore if it's not a link, or if it doesn't start with '/', or if it has target="_blank"
                        if (link && link.getAttribute('href') && link.getAttribute('href').startsWith('/') && !link.hasAttribute('target')) {
                            // Check if it's meant to bypass AJAX (yeh baad mei fix krunga)
                            if (link.hasAttribute('data-no-ajax')) return;
                            
                            e.preventDefault();
                            this.navigateTo(link.getAttribute('href'));
                        }
                    });

                    // Handle back/forward navigation
                    window.addEventListener('popstate', (e) => {
                        if (e.state && e.state.url) {
                            this.navigateTo(e.state.url, false);
                        } else {
                            this.navigateTo(window.location.pathname, false);
                        }
                    });
                },

                async navigateTo(url, pushState = true) {
                    if (this.loading) return;
                    this.loading = true;
                    this.activeTripMenu = null; // Close any open menus
                    
                    try {
                        let response = await fetch(url, {
                            headers: { 
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-Workspace-Request': 'true'
                            }
                        });
                        
                        if (response.ok) {
                            let html = await response.text();
                            
                            // Parse the incoming HTML
                            let parser = new DOMParser();
                            let doc = parser.parseFromString(html, 'text/html');
                            
                            // Find the workspace container in the fetched HTML
                            let newWorkspace = doc.querySelector('#workspace-container');
                            
                            if (newWorkspace) {
                                // Swap content
                                let container = document.querySelector('#workspace-container');
                                container.innerHTML = newWorkspace.innerHTML;
                                
                                // Dynamically clone and execute scripts in the new content
                                newWorkspace.querySelectorAll('script').forEach(oldScript => {
                                    let newScript = document.createElement('script');
                                    Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
                                    newScript.appendChild(document.createTextNode(oldScript.innerHTML));
                                    container.appendChild(newScript);
                                });

                                // Re-initialize Alpine tree to discover/boot new components
                                if (window.Alpine) {
                                    window.Alpine.initTree(container);
                                }
                                
                                // Update Title
                                document.title = doc.title;
                                
                                // Push state
                                if (pushState) {
                                    window.history.pushState({url: url}, doc.title, url);
                                }
                            } else {
                                // Fallback if container is missing (e.g. redirected to login page)
                                window.location.href = url;
                            }
                        } else {
                            window.location.href = url;
                        }
                    } catch (err) {
                        window.location.href = url;
                    } finally {
                        this.loading = false;
                    }
                }
            }));
        });
    </script>
    <!-- Global Delete Confirmation Modal -->
    <div 
        x-data="{ open: false, tripId: null, tripTitle: '' }"
        @open-delete-modal.window="open = true; tripId = $event.detail.id; tripTitle = $event.detail.title"
        x-show="open"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
        style="display: none;"
    >
        <!-- Modal panel -->
        <div 
            @click.away="open = false"
            class="w-full max-w-lg overflow-hidden rounded-3xl border border-white/10 bg-[#0F1115]/95 backdrop-blur-xl shadow-2xl shadow-black/40"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        >

            <!-- top glow -->
            <div class="h-px w-full bg-linear-to-r from-transparent via-white/10 to-transparent"></div>

            <div class="p-7">

                <!-- icon -->
                <div class="mb-6 flex items-center justify-between">

                    <div class="flex items-center gap-4">

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-orange-500/10 bg-orange-500/5 text-orange-400">

                            <svg 
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">

                                <path 
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19 7L5 7M10 11V17M14 11V17M6 7L7 19C7.05263 20.0547 7.94536 20.875 9 20.875H15C16.0546 20.875 16.9474 20.0547 17 19L18 7M9 7V5C9 4.44772 9.44772 4 10 4H14C14.5523 4 15 4.44772 15 5V7"/>

                            </svg>

                        </div>

                        <div>
                            <h3 class="text-xl font-semibold tracking-tight text-white">
                                Delete trip?
                            </h3>

                            <p class="mt-1 text-sm text-white/40">
                                This action permanently removes the trip workspace.
                            </p>
                        </div>

                    </div>

                    <!-- close -->
                    <button
                        @click="open = false"
                        class="flex h-9 w-9 items-center justify-center rounded-xl border border-white/5 bg-white/03 text-white/40 transition hover:bg-white/6 hover:text-white">

                        <svg 
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24">

                            <path 
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"/>

                        </svg>

                    </button>

                </div>

                <!-- content -->
                <div class="rounded-2xl border border-white/5 bg-white/2 p-5">

                    <p class="text-sm leading-7 text-white/55">
                        You’re about to permanently delete
                        <span 
                            class="font-medium text-white"
                            x-text="tripTitle"></span>.

                        All itinerary plans, activities, and associated trip data will be removed from your workspace.
                    </p>

                </div>

                <!-- actions -->
                <div class="mt-7 flex items-center justify-end gap-3">

                    <button 
                        @click="open = false"
                        type="button"
                        class="rounded-xl border border-white/8 bg-white/3 px-5 py-2.5 text-sm font-medium text-white/60 transition hover:bg-white/5 hover:text-white">

                        Cancel

                    </button>

                    <form :action="'/trips/' + tripId" method="POST" class="m-0">

                        @csrf
                        @method('DELETE')

                        <button 
                            type="submit"
                            class="rounded-xl bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-400 active:scale-[0.98]">

                            Delete Trip

                        </button>

                    </form>

                </div>

            </div>

        </div>
    </div>
</div>

<style>
/* Optional custom scrollbar utilities for Tailwind since standard utilities don't cover everything smoothly */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.2);
}
</style>
@endsection
