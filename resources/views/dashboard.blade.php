@extends('layouts.app')

@section('content')
<x-landing-navbar />

<div class="px-6 py-12">
    <h1 class="text-2xl font-bold mb-4 text-white">Your Trips</h1>

    <a href="/trips/create" class="bg-[#F3652F] text-white px-4 py-2 rounded">
        + Create Trip
    </a>
</div>

@endsection