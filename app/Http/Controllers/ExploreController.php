<?php

namespace App\Http\Controllers;

use App\Models\ExploreItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ExploreController extends Controller
{
    /**
     * Display the explore page.
     */
    public function index(): View
    {
        $exploreItems = Schema::hasTable('explore_items') && ExploreItem::query()->exists()
            ? ExploreItem::query()
                ->whereNotIn('country', ['USA', 'United States', 'United States of America'])
                ->orderByDesc('featured')
                ->orderByDesc('rating')
                ->orderBy('title')
                ->get()
            : $this->fallbackExploreItems();
        
        return view('explore', [
            'exploreItems' => $exploreItems,
            'fallbackImage' => $this->fallbackImage(),
        ]);
    }

    /**
     * Fallback content for environments where explore items have not been seeded yet.
     */
    private function fallbackExploreItems(): Collection
    {
        $items = [
            [
                'title' => 'Spain',
                'location' => 'Barcelona',
                'country' => 'Spain',
                'category' => 'City Escape',
                'duration' => '4 days',
                'price_from' => '$1399',
                'rating' => 4.9,
                'hotels' => 14,
                'season' => 'All year-round',
                'featured' => true,
                'image' => asset('images/barcelona.png'),
                'description' => 'Discover Spain with curated stays, local food, and coastal city views.',
            ],
            [
                'title' => 'Japan',
                'location' => 'Tokyo',
                'country' => 'Japan',
                'category' => 'Culture Trip',
                'duration' => '7 days',
                'price_from' => '$1650',
                'rating' => 4.8,
                'hotels' => 27,
                'season' => 'All year-round',
                'featured' => true,
                'image' => asset('images/tokyo.jpg'),
                'description' => 'Experience Japan through food, tradition, and modern city energy.',
            ],
            [
                'title' => 'Italy',
                'location' => 'Rome',
                'country' => 'Italy',
                'category' => 'Romantic Escape',
                'duration' => '6 days',
                'price_from' => '$1969',
                'rating' => 4.9,
                'hotels' => 12,
                'season' => 'Spring / Summer',
                'featured' => true,
                'image' => asset('images/rome.webp'),
                'description' => 'See Italy through historic streets, scenic routes, and excellent cuisine.',
            ],
            [
                'title' => 'Switzerland',
                'location' => 'Zurich',
                'country' => 'Switzerland',
                'category' => 'Mountain Escape',
                'duration' => '10 days',
                'price_from' => '$2000',
                'rating' => 4.8,
                'hotels' => 22,
                'season' => 'Winter',
                'featured' => true,
                'image' => asset('images/zurich.jpg'),
                'description' => 'A calm alpine journey with scenic trains, lakes, and mountain views.',
            ],
            [
                'title' => 'Paradise in Bali',
                'location' => 'Bali',
                'country' => 'Indonesia',
                'category' => 'Beach Retreat',
                'duration' => '6 days',
                'price_from' => '$1,250',
                'rating' => 4.9,
                'hotels' => 18,
                'season' => 'All year-round',
                'featured' => true,
                'image' => asset('images/bali.webp'),
                'description' => 'Boutique villa accommodation, yoga classes, and guided temple tours included.',
            ],
            [
                'title' => 'Journey to Japan',
                'location' => 'Japan',
                'country' => 'Japan',
                'category' => 'Culture Trip',
                'duration' => '8 days',
                'price_from' => '$1,659',
                'rating' => 4.8,
                'hotels' => 24,
                'season' => 'All year-round',
                'featured' => true,
                'image' => asset('images/japan.jpg'),
                'description' => 'Culture lovers and foodies eager to explore Japan through local experiences and hidden gems.',
            ],
            [
                'title' => 'Safari & Wildlife Adventure in Kenya',
                'location' => 'Maasai Mara National Reserve',
                'country' => 'Kenya',
                'category' => 'Safari',
                'duration' => '7 days, 6 nights',
                'price_from' => '$1,659',
                'rating' => 4.9,
                'hotels' => 16,
                'season' => 'Dry season',
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A once-in-a-lifetime safari adventure with wildlife in its natural habitat.',
            ],
        ];

        return collect($items)->map(fn (array $item, int $index) => $this->shapeExploreItem($item, $index))->values();
    }

    private function shapeExploreItem(array|object $item, int $index): object
    {
        $item = (object) $item;

        $title = $item->title ?? 'Curated escape';
        $location = $item->location ?? $title;
        $country = $item->country ?? 'Worldwide';
        $category = $item->category ?? 'Tour';
        $season = $item->season ?? 'Year-round';
        $description = $item->description ?? 'Experience amazing destinations with curated activities and accommodations.';

        $image = $item->image ?? null;
        $locLower = strtolower($location);
        $titleLower = strtolower($title);
        $countryLower = strtolower($country);

        if (str_contains($locLower, 'barcelona')) {
            $image = asset('images/barcelona.png');
        } elseif (str_contains($locLower, 'tokyo')) {
            $image = asset('images/tokyo.jpg');
        } elseif (str_contains($locLower, 'rome')) {
            $image = asset('images/rome.webp');
        } elseif (str_contains($locLower, 'zurich')) {
            $image = asset('images/zurich.jpg');
        } elseif (str_contains($locLower, 'bali')) {
            $image = asset('images/bali.webp');
        } elseif ($locLower === 'japan' || str_contains($titleLower, 'journey to japan') || str_contains($titleLower, 'japan') || str_contains($countryLower, 'japan') || str_contains($locLower, 'kyoto') || str_contains($locLower, 'osaka')) {
            $image = asset('images/japan.jpg');
        } elseif (str_contains($locLower, 'maasai mara') || str_contains($titleLower, 'kenya') || str_contains($titleLower, 'maasai mara') || str_contains($titleLower, 'reserve')) {
            $image = asset('images/reserve.jpg');
        }

        $image = $image ?: ExploreItem::imageUrlFor($title, $location, $country, $category, $index);

        return (object) [
            'id' => $item->id ?? $index + 1,
            'title' => $title,
            'location' => $location,
            'country' => $country,
            'category' => $category,
            'duration' => $item->duration ?? 'Flexible',
            'price_from' => $item->price_from ?? 'Contact us',
            'rating' => (float) ($item->rating ?? 0),
            'hotels' => (int) ($item->hotels ?? 0),
            'season' => $season,
            'featured' => (bool) ($item->featured ?? false),
            'description' => $description,
            'image' => $image,
            'resolved_image' => $image,
            'gallery_images' => $item->gallery_images ?? ExploreItem::galleryImagesFor($title, $location, $country, $category),
            'region' => $item->region ?? ExploreItem::regionForCountry($country),
            'search_text' => $item->search_text ?? ExploreItem::searchTextFor($title, $location, $country, $category, $season, $description),
        ];
    }

    private function fallbackImage(): string
    {
        return 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=1200&q=80';
    }
}
