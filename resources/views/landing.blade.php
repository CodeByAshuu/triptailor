@extends('layouts.app')

@section('content')

<div class="my-4">
    <div class="py-6">
        <h2 class="text-sm font-semibold font-heading uppercase pt-18 mb-4 text-text tracking-[0.1rem]"> Customizable Travel Itinarary Planner</h2>
        <h1 class="text-7xl mb-4 text-white leading-23">We take travel, planning, and <br> itineraries to the next level.</h1>
    </div>
    <div class="flex items-center gap-2">
        <a href="/trips/create" class="bg-orange hover:bg-white text-sm text-white hover:text-black px-8 py-6 rounded-lg uppercase font-semibold font-heading tracking-widest">
            Create Trip +
        </a>
        <a href="/explore" class="bg-card hover:bg-white text-sm text-white hover:text-black px-8 py-6 rounded-lg uppercase font-semibold font-heading tracking-widest">
            Let's Explore &rarr;
        </a>
    </div>
</div>

@endsection