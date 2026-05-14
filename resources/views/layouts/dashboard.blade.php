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
                                document.querySelector('#workspace-container').innerHTML = newWorkspace.innerHTML;
                                
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
