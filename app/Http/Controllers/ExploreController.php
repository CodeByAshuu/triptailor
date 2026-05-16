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
            'image' => $item->image ?? ExploreItem::imageUrlFor($title, $location, $country, $category, $index),
            'resolved_image' => $item->resolved_image ?? ExploreItem::imageUrlFor($title, $location, $country, $category, $index),
            'gallery_images' => $item->gallery_images ?? ExploreItem::galleryImagesFor($title, $location, $country, $category),
            'region' => $item->region ?? ExploreItem::regionForCountry($country),
            'search_text' => $item->search_text ?? ExploreItem::searchTextFor($title, $location, $country, $category, $season, $description),
        ];
    }

    private function fallbackImage(): string
    {
        return 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80';
    }
}
