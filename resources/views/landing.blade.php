@extends('layouts.app')

@section('content')
<x-landing-navbar />
<section class="px-6" data-theme="dark">
    <div class="mb-24">
        <div class="py-6">
            <h2 class="text-sm font-semibold font-heading uppercase pt-18 mb-4 text-text tracking-[0.1rem]"> Customizable Travel Itinarary Planner</h2>
            <h1 class="text-7xl mb-4 text-white leading-23">We take travel, planning, and <br> itineraries to the next level.</h1>
        </div>
        <div class="flex gap-2">
            <a href="/trips/create" class="flex items-center gap-2 bg-orange hover:bg-white text-sm text-white hover:text-black px-8 py-6 rounded-lg uppercase font-semibold font-heading tracking-widest">
                Create Trip
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            </a>
            <a href="/explore" class="bg-card hover:bg-white text-sm text-white hover:text-black px-8 py-6 rounded-lg uppercase font-semibold font-heading tracking-widest">
                Let's Explore &rarr;
            </a>
        </div>
    </div>

    <!-- parallax scrolling -->
    <div class="flex justify-between gap-6 my-8 bg-bg relative z-10">
        <!-- LEFT (sticky image) -->
        <div class="w-1/2">
            <div class="sticky top-25">
                <img 
                    src="{{ asset('images/destination-see.jpg') }}" 
                    alt="destination-see" 
                    class="h-125 w-full object-cover rounded-lg"
                >
            </div>
        </div>

        <!-- RIGHT (scrolling content) -->
        <div class="w-1/2 py-6 space-y-24">
            <p class="text-3xl mb-4 text-white font-secondary">
                We help travelers plan smarter, not harder — bringing all your ideas, 
                places, and schedules into one simple, organized itinerary. 
                From your first destination to your final day, everything stays in one place.
            </p>

            <!-- Investors -->
            <div class="text-white">
                <p class="text-sm font-semibold uppercase mt-8 mb-6 text-text-muted tracking-[0.1rem]">
                    Designing products backed by top-tier investors
                </p>

                <div class="grid grid-cols-4 border-t border-gray-800">
                    <div class="flex items-center justify-center py-16 border-r border-gray-800">
                        <p class="text-xl font-semibold">techstars<span class="text-green-400">_</span></p>
                    </div>
                    <div class="flex items-center justify-center py-16 border-r border-gray-800 gap-3">
                        <div class="bg-white text-black w-8 h-8 flex items-center justify-center font-bold">Y</div>
                        <p class="text-lg">Combinator</p>
                    </div>
                    <div class="flex items-center justify-center py-16 border-r border-gray-800">
                        <p class="text-lg text-center leading-3.5">
                            andreessen<br>horowitz
                        </p>
                    </div>
                    <div class="flex items-center justify-center py-16">
                        <p class="uppercase tracking-[0.2em] text-gray-400 text-sm">and more</p>
                    </div>
                </div>
            </div>

            <!-- Numbers -->
            <div class="text-white" x-data="{ 
                animate(target, duration, precision = 0) {
                    let start = 0;
                    let end = parseFloat(target);
                    let startTime = null;
                    
                    const step = (timestamp) => {
                        if (!startTime) startTime = timestamp;
                        let progress = Math.min((timestamp - startTime) / duration, 1);
                        let current = progress * (end - start) + start;
                        return current.toFixed(precision);
                    };

                    return step;
                }
            }">
                <p class="text-sm font-semibold uppercase mt-20 mb-6 text-text-muted tracking-[0.1rem]">
                    TripTailor in numbers
                </p>

                <div class="grid grid-cols-2 border-t border-gray-800">
                    <div class="border-r border-b border-gray-800 flex flex-col items-center justify-center py-16"
                         x-data="{ count: 0, target: 1000, shown: false }"
                         x-intersect="if(!shown) { 
                             shown = true;
                             let start = null;
                             const step = (ts) => {
                                 if(!start) start = ts;
                                 let progress = Math.min((ts - start) / 2000, 1);
                                 count = Math.floor(progress * target);
                                 if(progress < 1) requestAnimationFrame(step);
                             };
                             requestAnimationFrame(step);
                         }">
                        <h1 class="text-5xl mb-4"><span x-text="count >= 1000 ? Math.floor(count/1000) + 'K' : count">0</span>+</h1>
                        <p class="text-gray-400 text-center">places travelled by our clients</p>
                    </div>

                    <div class="border-b border-gray-800 flex flex-col items-center justify-center py-16"
                         x-data="{ count: 0, target: 3, shown: false }"
                         x-intersect="if(!shown) { 
                             shown = true;
                             let start = null;
                             const step = (ts) => {
                                 if(!start) start = ts;
                                 let progress = Math.min((ts - start) / 1500, 1);
                                 count = Math.floor(progress * target);
                                 if(progress < 1) requestAnimationFrame(step);
                             };
                             requestAnimationFrame(step);
                         }">
                        <h1 class="text-5xl mb-4">x<span x-text="count">0</span></h1>
                        <p class="text-gray-400 text-center">avg trips per users — most come <br> back</p>
                    </div>

                    <div class="border-r border-gray-800 flex flex-col items-center justify-center py-16"
                         x-data="{ count: 0, target: 5.0, shown: false }"
                         x-intersect="if(!shown) { 
                             shown = true;
                             let start = null;
                             const step = (ts) => {
                                 if(!start) start = ts;
                                 let progress = Math.min((ts - start) / 1500, 1);
                                 count = (progress * target).toFixed(1);
                                 if(progress < 1) requestAnimationFrame(step);
                             };
                             requestAnimationFrame(step);
                         }">
                        <h1 class="text-5xl mb-4"><span x-text="count">0.0</span></h1>
                        <p class="text-gray-400 text-center">on clutch — 40+ reviews</p>
                    </div>

                    <div class="flex flex-col items-center justify-center py-16"
                         x-data="{ count: 0, target: 35, shown: false }"
                         x-intersect="if(!shown) { 
                             shown = true;
                             let start = null;
                             const step = (ts) => {
                                 if(!start) start = ts;
                                 let progress = Math.min((ts - start) / 2000, 1);
                                 count = Math.floor(progress * target);
                                 if(progress < 1) requestAnimationFrame(step);
                             };
                             requestAnimationFrame(step);
                         }">
                        <h1 class="text-5xl mb-4"><span x-text="count">0</span>%</h1>
                        <p class="text-gray-400 text-center">conversion lift — klickex case</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="bg-bg">
    <div class="h-32 bg-white rounded-t-[80px] md:rounded-t-[120px]"></div>
</div>

<!-- fix krna hai isse maybe (why triptailor? ) -->
<section id="white-section" class="bg-white py-6 px-12" data-theme="light">
    <p class="text-sm font-semibold uppercase mb-6 text-gray-400 tracking-[0.1rem]">
        Product design and development agency
    </p>

    <h1 class="text-6xl font-medium mb-16">
        Our featured client wins
    </h1>

    <!-- company grid -->
    <div class="grid grid-cols-4 border-t border-gray-200">
        <div class="py-24 border-r border-b border-gray-200 flex justify-center font-semibold hover:bg-bg hover:text-white duration-500">airportr</div>
        <div class="py-24 border-r border-b border-gray-200 flex justify-center font-bold hover:bg-bg hover:text-white duration-500">nomupay.</div>
        <div class="py-24 border-r border-b border-gray-200 flex justify-center font-bold hover:bg-bg hover:text-white  duration-500">OneText</div>
        <div class="py-24 border-b border-gray-200 flex justify-center tracking-[1.4rem] hover:bg-bg hover:text-white duration-500">SHAGA</div>
        <div class="py-24 border-r  border-gray-200 flex justify-center font-secondary text-2xl uppercase tracking-widest hover:bg-bg hover:text-white duration-500">D0Stuff</div>
        <div class="py-24 border-r border-gray-200 flex justify-center font-bold text-xl font-secondary hover:bg-bg hover:text-white duration-500">IsoraGRC</div>
        <div class="py-24 border-r border-gray-200 flex justify-center font-secondary font-medium hover:bg-bg hover:text-white  duration-500">Wisdom</div>
        <div class="py-24 flex justify-center uppercase hover:bg-bg hover:text-white duration-500">Qurtuba<br>online academy</div>
    </div>
</section>

<div class="bg-white">
    <div class="h-32 bg-bg rounded-t-[80px] md:rounded-t-[120px]"></div>
</div>

<!-- steps wala section -->
<section class="px-6 my-20" data-theme="dark">
    <div class="text-white mb-16">
        <p class="text-sm font-semibold uppercase mb-6 text-text-muted tracking-[0.1rem]">
            Smart travel planning platform
        </p>
        <h1 class="text-7xl mb-6 leading-[1.1]">
            Plan better trips, from first <br>
            idea to final day
        </h1>
        <p class="text-2xl font-secondary text-text leading-relaxed">
            Trips shouldn't feel chaotic. TripTailor helps you organize destinations, timelines, <br>
            and plans into one clear itinerary. From saving places to structuring <br>
            day-wise travel, everything stays simple, flexible, and in one place.
        </p>
    </div>

    <!-- steps main -->
    <div class="flex justify-between gap-10 relative">

        <!-- left sidebar -->
        <div class="w-[22%]">
            <div class="sticky top-28 flex flex-col gap-6" style="min-height: calc(90vh - 7rem);">

                <a href="#create-trip"
                    class="feature-link text-white transition duration-300 uppercase tracking-wider text-lg font-heading"
                    data-target="create-trip">
                    Create Trip
                </a>
                <a href="#edit-trip"
                    class="feature-link text-text-muted transition duration-300 uppercase tracking-wider text-lg font-heading"
                    data-target="edit-trip">
                    Edit Trip
                </a>
                <a href="#add-activity"
                    class="feature-link text-text-muted transition duration-300 uppercase tracking-wider text-lg font-heading"
                    data-target="add-activity">
                    Add Activities
                </a>
                <a href="#save-trip"
                    class="feature-link text-text-muted transition duration-300 uppercase tracking-wider text-lg font-heading"
                    data-target="save-trip">
                    Save Trips
                </a>

                <!-- mt-auto pushes this to the bottom of the sticky box -->
                <a href="/explore"
                    class="mt-auto bg-orange hover:bg-white text-sm text-white hover:text-black px-8 py-6 rounded-lg uppercase font-semibold font-heading tracking-widest text-center">
                    Explore All &rarr;
                </a>
            </div>
        </div>

        <!-- rigth content -->
        <div class="w-[78%] flex flex-col gap-24">

            <!-- CREATE TRIP -->
            <section id="create-trip"
                class="feature-section min-h-screen border-t border-white/10 pt-12">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
                    <div class="md:col-span-5">
                        <p class="text-6xl text-text-muted mb-12">01</p>

                        <h2 class="text-5xl text-white mb-6 font-heading">
                            Create your trip
                        </h2>

                        <p class="text-text text-xl leading-relaxed mb-10">
                            Start by creating a trip with destination, dates,
                            and basic details to structure your itinerary.
                        </p>

                        <!-- Mini Steps -->
                        <div class="flex flex-col gap-6">

                            <div>
                                <p class="text-orange-500 text-sm mb-2 border-br">01</p>
                                <h3 class="text-white text-2xl mb-2">Choose destination</h3>
                                <p class="text-text-muted">
                                    Add your city, country, or travel route.
                                </p>
                            </div>

                            <div>
                                <p class="text-orange-500 text-sm mb-2">02</p>
                                <h3 class="text-white text-2xl mb-2">Set dates</h3>
                                <p class="text-text-muted">
                                    Select start and end dates for the trip.
                                </p>
                            </div>

                            <div>
                                <p class="text-orange-500 text-sm mb-2">03</p>
                                <h3 class="text-white text-2xl mb-2">Save details</h3>
                                <p class="text-text-muted">
                                    Your trip becomes your planning workspace.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- IMAGE -->
                    <div class="md:col-span-7">
                        <img src="{{ asset('images/create-trip.jpg') }}"
                            class="w-full rounded-2xl opacity-90 hover:opacity-100 transition duration-500 shadow-2xl">
                    </div>

                </div>

            </section>

            <!-- EDIT TRIP -->
            <section id="edit-trip"
                class="feature-section min-h-screen border-t border-white/10 pt-12">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-center">

                    <div class="md:col-span-5">

                        <p class="text-6xl text-text-muted mb-12">02</p>

                        <h2 class="text-5xl text-white mb-6 font-heading">
                            Edit anytime
                        </h2>

                        <p class="text-text text-xl leading-relaxed mb-10">
                            Plans change. Easily modify destinations,
                            dates, and schedules whenever needed.
                        </p>

                        <div class="flex flex-col gap-6">

                            <div>
                                <p class="text-orange-500 text-sm mb-2">01</p>
                                <h3 class="text-white text-2xl mb-2">Update destinations</h3>
                                <p class="text-text-muted">
                                    Add or remove locations anytime.
                                </p>
                            </div>

                            <div>
                                <p class="text-orange-500 text-sm mb-2">02</p>
                                <h3 class="text-white text-2xl mb-2">Adjust timelines</h3>
                                <p class="text-text-muted">
                                    Rearrange days and schedules smoothly.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="md:col-span-7">
                        <img src="{{ asset('images/edit_trip.jpg') }}"
                            class="w-full rounded-2xl shadow-2xl opacity-90 hover:opacity-100 transition duration-500">
                    </div>

                </div>

            </section>

            <!-- ADD ACTIVITY -->
            <section id="add-activity"
                class="feature-section min-h-screen border-t border-white/10 pt-12">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-center">

                    <div class="md:col-span-4">

                        <p class="text-6xl text-text-muted mb-12">03</p>

                        <h2 class="text-5xl text-white mb-6 font-heading">
                            Organize activities
                        </h2>

                        <p class="text-text text-xl leading-relaxed mb-10">
                            Structure your trip day-by-day with activities,
                            timings, notes, and plans.
                        </p>

                    </div>

                    <div class="md:col-span-8">
                        <img src="{{ asset('images/organise_activities.jpg') }}"
                            class="w-full rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white/5 opacity-95 hover:opacity-100 transition duration-500 transform hover:scale-[1.02]">
                    </div>

                </div>

            </section>

            <!-- SAVE -->
            <section id="save-trip"
                class="feature-section min-h-screen border-t border-white/10 pt-12">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-center">

                    <div class="md:col-span-4">

                        <p class="text-6xl text-text-muted mb-12">04</p>

                        <h2 class="text-5xl text-white mb-6 font-heading">
                            Save and revisit
                        </h2>

                        <p class="text-text text-xl leading-relaxed mb-10">
                            Access your itineraries anytime and continue
                            planning whenever inspiration strikes.
                        </p>

                    </div>

                    <div class="md:col-span-8">
                        <img src="{{ asset('images/revisit.jpg') }}"
                            class="w-full rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white/5 opacity-95 hover:opacity-100 transition duration-500 transform hover:scale-[1.02]">
                    </div>

                </div>
            </section>
        </div>
    </div>
</section>
<div class="bg-bg">
    <div class="h-32 bg-white rounded-t-[80px] md:rounded-t-[120px]"></div>
</div>

<!-- testimonials (real wale baad mei i'll put here) -->
<section class="bg-white py-24 px-12" data-theme="light">
    <p class="text-sm font-semibold uppercase mb-6 text-gray-400 tracking-[0.1rem]">
        What travelers say
    </p>

    <h1 class="text-6xl font-medium mb-16">
        Real trips. Real people.
    </h1>

    <div class="grid grid-cols-3 gap-6">
        <div class="bg-gray-50 rounded-2xl p-8">
            <p class="text-gray-700 text-lg leading-relaxed mb-8">
                "TripTailor completely changed how I plan vacations. Everything is in one place — no more messy spreadsheets."
            </p>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-orange flex items-center justify-center text-white font-bold text-sm">AK</div>
                <div>
                    <p class="font-semibold text-sm">Ayesha Khan</p>
                    <p class="text-gray-500 text-sm">Traveled to 6 countries</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-2xl p-8">
            <p class="text-gray-700 text-lg leading-relaxed mb-8">
                "I planned a 3-week Europe trip in under an hour. The day-by-day view is brilliant — I could see the whole trip at a glance."
            </p>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-orange flex items-center justify-center text-white font-bold text-sm">RJ</div>
                <div>
                    <p class="font-semibold text-sm">Rohan Joshi</p>
                    <p class="text-gray-500 text-sm">Solo backpacker</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-2xl p-8">
            <p class="text-gray-700 text-lg leading-relaxed mb-8">
                "My travel group used TripTailor for our group trip and it kept everyone on the same page. Highly recommended."
            </p>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-orange flex items-center justify-center text-white font-bold text-sm">SM</div>
                <div>
                    <p class="font-semibold text-sm">Sara Malik</p>
                    <p class="text-gray-500 text-sm">Group travel organizer</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="bg-white py-24 px-12" data-theme="light">
    <p class="text-sm font-semibold uppercase mb-6 text-gray-400 tracking-[0.1rem]">
        Got questions?
    </p>

    <h1 class="text-6xl font-medium mb-16">
        Frequently asked questions
    </h1>

    <div class="max-w-3xl flex flex-col divide-y divide-gray-200" x-data="{ open: null }">
        @foreach ([
            ['q' => 'Is TripTailor free to use?', 'a' => 'Yes! You can start for free with up to 3 trips. Upgrade to Pro for unlimited trips and extra features.'],
            ['q' => 'Can I plan trips with friends?', 'a' => 'Collaborative planning is available on our Team plan, allowing up to 10 members to plan together in real time.'],
            ['q' => 'Can I export my itinerary?', 'a' => 'Pro and Team users can export full itineraries to PDF — perfect for printing or sharing offline.'],
            ['q' => 'Is my data safe?', 'a' => 'Absolutely. We use industry-standard encryption and never sell your data to third parties.'],
            ['q' => 'Can I edit my trip after creating it?', 'a' => 'Yes, trips are fully editable at any time. Add destinations, shift dates, and rearrange activities whenever you need.'],
        ] as $index => $item)
        <div class="py-6" x-data="{ open: false }">
            <button
                @click="open = !open"
                class="w-full flex justify-between items-center text-left text-xl font-medium text-gray-900"
            >
                {{ $item['q'] }}
                <span class="ml-4 text-gray-400 text-2xl" x-text="open ? '−' : '+'"></span>
            </button>
            <p class="mt-4 text-gray-600 text-lg leading-relaxed" x-show="open" x-transition>
                {{ $item['a'] }}
            </p>
        </div>
        @endforeach
    </div>
</section>

<!-- footer -->
<div class="bg-white">
    <div class="h-32 bg-bg rounded-t-[80px] md:rounded-t-[120px]"></div>
</div>

<footer class="bg-bg border-t border-gray-800 px-12 py-16 text-white" data-theme="dark">
    <div class="flex justify-between gap-12 mb-16">
        <!-- logo lgana hai baadmei -->
        <div class="w-1/3">
            <h2 class="text-8xl font-heading font-bold mb-4">TripTailor</h2>
            <p class="text-text text-sm leading-relaxed mb-6">
                Smarter travel planning — from first idea to final day.
                All your trips, organized in one place.
            </p>
            <div class="flex gap-4">
                <a href="https://x.com/" class="text-text-muted hover:text-white transition text-sm">Twitter</a>
                <a href="https://www.instagram.com/?hl=en" class="text-text-muted hover:text-white transition text-sm">Instagram</a>
                <a href="https://www.linkedin.com/" class="text-text-muted hover:text-white transition text-sm">LinkedIn</a>
            </div>
        </div>

        <!-- links -->
        <div class="flex gap-20">
            <div>
                <p class="text-xs uppercase tracking-[0.1rem] text-text-muted mb-4">Product</p>
                <ul class="flex flex-col gap-3 text-sm text-text">
                    <li><a href="/trips/create" class="hover:text-white transition">Create Trip</a></li>
                    <li><a href="/explore" class="hover:text-white transition">Explore</a></li>
                    <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                    <li><a href="#" class="hover:text-white transition">Changelog</a></li>
                </ul>
            </div>

            <div>
                <p class="text-xs uppercase tracking-[0.1rem] text-text-muted mb-4">Company</p>
                <ul class="flex flex-col gap-3 text-sm text-text">
                    <li><a href="#" class="hover:text-white transition">About</a></li>
                    <li><a href="#" class="hover:text-white transition">Blog</a></li>
                    <li><a href="#" class="hover:text-white transition">Careers</a></li>
                    <li><a href="#" class="hover:text-white transition">Contact</a></li>
                </ul>
            </div>

            <div>
                <p class="text-xs uppercase tracking-[0.1rem] text-text-muted mb-4">Legal</p>
                <ul class="flex flex-col gap-3 text-sm text-text">
                    <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                    <li><a href="#" class="hover:text-white transition">Terms</a></li>
                    <li><a href="#" class="hover:text-white transition">Cookies</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-gray-800 pt-8 flex justify-between items-center text-sm text-text-muted">
        <p>&copy; {{ date('Y') }} TripTailor. All rights reserved.</p>
        <p class="text-center text-gray-600 text-xs">
            Built for educational &amp; learning purposes only. Not a commercial product.
        </p>
        <p>Designed with care &mdash; built for travelers.</p>
    </div>
</footer>

<!-- scroll behaviour for steps wala section -->
<script>
    const sections = document.querySelectorAll('.feature-section');
    const links = document.querySelectorAll('.feature-link');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                links.forEach(link => {
                    link.classList.remove('text-white');
                    link.classList.add('text-text-muted');
                });

                const activeLink = document.querySelector(
                    `.feature-link[data-target="${entry.target.id}"]`
                );
                if (activeLink) {
                    activeLink.classList.remove('text-text-muted');
                    activeLink.classList.add('text-white');
                }
            }
        });
    }, {
        rootMargin: '-30% 0px -60% 0px', // triggers when section is in the middle 10% of viewport
        threshold: 0
    });

    sections.forEach(section => observer.observe(section));
</script>

@endsection