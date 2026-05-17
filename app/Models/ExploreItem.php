<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ExploreItem extends Model
{
    protected $fillable = [
        'title',
        'location',
        'country',
        'category',
        'duration',
        'price_from',
        'rating',
        'hotels',
        'season',
        'featured',
        'description',
        'image',
    ];

    protected $appends = [
        'region',
        'resolved_image',
        'gallery_images',
        'search_text',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'featured' => 'boolean',
    ];

    protected function region(): Attribute
    {
        return Attribute::get(fn (): string => static::regionForCountry($this->country));
    }

    protected function resolvedImage(): Attribute
    {
        return Attribute::get(fn (): string => static::imageUrlFor(
            $this->title,
            $this->location,
            $this->country,
            $this->category
        ));
    }

    protected function galleryImages(): Attribute
    {
        return Attribute::get(fn (): array => static::galleryImagesFor(
            $this->title,
            $this->location,
            $this->country,
            $this->category
        ));
    }

    protected function searchText(): Attribute
    {
        return Attribute::get(fn (): string => static::searchTextFor(
            $this->title,
            $this->location,
            $this->country,
            $this->category,
            $this->season,
            $this->description
        ));
    }

    public static function regionForCountry(?string $country): string
    {
        $country = Str::lower(trim((string) $country));

        $regions = [
            'Asia' => [
                'india', 'indonesia', 'japan', 'thailand', 'singapore', 'south korea',
                'vietnam', 'cambodia', 'laos', 'nepal', 'qatar', 'oman', 'united arab emirates', 'uae',
            ],
            'Europe' => [
                'france', 'italy', 'switzerland', 'spain', 'portugal', 'netherlands',
                'czech republic', 'austria', 'uk', 'united kingdom', 'turkey',
            ],
            'USA' => [
                'usa', 'united states', 'united states of america', 'canada',
            ],
            'Africa' => [
                'south africa', 'kenya', 'morocco', 'egypt', 'tanzania',
            ],
            'Oceania' => [
                'australia', 'new zealand',
            ],
            'South America' => [
                'brazil', 'argentina', 'chile', 'peru',
            ],
        ];

        foreach ($regions as $region => $countries) {
            if (in_array($country, $countries, true)) {
                return $region;
            }
        }

        return 'Other';
    }

    public static function imageUrlFor(?string $title, ?string $location, ?string $country, ?string $category, int $variant = 0): string
    {
        $locClean = static::cleanSearchTerm($location ?: $title ?: 'travel');

        $variantTerms = [
            'scenic',
            'culture',
            'street',
            'nature',
            'landmark',
        ];
        
        $term = $variantTerms[$variant % count($variantTerms)];

        $query = implode(',', array_filter([
            $locClean,
            $term
        ]));

        return 'https://loremflickr.com/1200/900/'.rawurlencode($query).'?random='.$variant;
    }

    public static function galleryImagesFor(?string $title, ?string $location, ?string $country, ?string $category): array
    {
        $locLower = strtolower($location ?? $title ?? '');

        if (str_contains($locLower, 'barcelona')) {
            return [
                'https://images.unsplash.com/photo-1583422409516-2895a77efedd?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1523531294919-4bea7c65e894?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1511527661048-7fe73d85e9a4?auto=format&fit=crop&w=400&q=80',
            ];
        }

        if (str_contains($locLower, 'tokyo') || str_contains($locLower, 'japan')) {
            return [
                'https://images.unsplash.com/photo-1542051841857-5f90071e7989?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?auto=format&fit=crop&w=400&q=80',
            ];
        }

        if (str_contains($locLower, 'rome') || str_contains($locLower, 'italy')) {
            return [
                'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1515542622106-78bda8ba0e5b?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1529260830199-445524553b14?auto=format&fit=crop&w=400&q=80',
            ];
        }

        if (str_contains($locLower, 'zurich') || str_contains($locLower, 'switzerland')) {
            return [
                'https://images.unsplash.com/photo-1505761671935-60b3a7427bad?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1527668752968-14dc70a27c95?auto=format&fit=crop&w=400&q=80',
            ];
        }

        if (str_contains($locLower, 'bali')) {
            return [
                'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?auto=format&fit=crop&w=400&q=80',
            ];
        }

        if (str_contains($locLower, 'maasai mara') || str_contains($locLower, 'kenya') || str_contains($locLower, 'safari')) {
            return [
                'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1523805009345-7448845a9e53?auto=format&fit=crop&w=400&q=80',
            ];
        }

        // Category-based fallbacks to ensure beautiful, matching, and distinct galleries
        $catLower = strtolower($category ?? '');

        if (str_contains($catLower, 'beach') || str_contains($catLower, 'island') || str_contains($catLower, 'coast')) {
            return [
                'https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?auto=format&fit=crop&w=400&q=80',
            ];
        }

        if (str_contains($catLower, 'nature') || str_contains($catLower, 'mountain') || str_contains($catLower, 'hill') || str_contains($catLower, 'wellness')) {
            return [
                'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1447752875215-b2761acb3c5d?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=400&q=80',
            ];
        }

        if (str_contains($catLower, 'adventure') || str_contains($catLower, 'safari') || str_contains($catLower, 'wildlife') || str_contains($catLower, 'trek')) {
            return [
                'https://images.unsplash.com/photo-1533240332313-0db49b439ad3?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1527631746610-bca00a040d60?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=400&q=80',
            ];
        }

        if (str_contains($catLower, 'city') || str_contains($catLower, 'town') || str_contains($catLower, 'urban') || str_contains($catLower, 'luxury') || str_contains($catLower, 'entertainment')) {
            return [
                'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1496568818309-53d7c7753022?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=400&q=80',
            ];
        }

        if (str_contains($catLower, 'culture') || str_contains($catLower, 'heritage') || str_contains($catLower, 'romantic') || str_contains($catLower, 'food') || str_contains($catLower, 'festival')) {
            return [
                'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1518391846015-55a9cc003b25?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1533105079780-92b9be482077?auto=format&fit=crop&w=400&q=80',
            ];
        }

        return [
            static::imageUrlFor($title, $location, $country, $category, 1),
            static::imageUrlFor($title, $location, $country, $category, 2),
            static::imageUrlFor($title, $location, $country, $category, 3),
        ];
    }

    public static function searchTextFor(?string ...$parts): string
    {
        return Str::lower(implode(' ', array_filter(array_map(
            static fn (?string $part): string => trim((string) $part),
            $parts
        ))));
    }

    protected static function cleanSearchTerm(?string $value): string
    {
        $value = Str::of((string) $value)
            ->replaceMatches('/[^\pL\pN]+/u', ' ')
            ->squish()
            ->trim();

        return $value->isNotEmpty() ? $value->toString() : '';
    }

    protected static function sceneTermsFor(?string $category): array
    {
        $category = Str::lower((string) $category);

        return match (true) {
            Str::contains($category, ['beach', 'island']) => ['coastline', 'seaside', 'tropical shore', 'oceanfront', 'lagoon'],
            Str::contains($category, ['city', 'town', 'urban']) => ['skyline', 'street life', 'city lights', 'downtown', 'architecture'],
            Str::contains($category, ['culture', 'heritage', 'romantic']) => ['historic district', 'landmark', 'old town', 'cultural street', 'plaza'],
            Str::contains($category, ['adventure', 'safari', 'wildlife']) => ['mountains', 'trail', 'savannah', 'forest', 'adventure landscape'],
            Str::contains($category, ['nature', 'mountain', 'wellness']) => ['lake', 'valley', 'mountain view', 'green landscape', 'misty hills'],
            Str::contains($category, ['luxury']) => ['premium resort', 'luxury skyline', 'boutique stay', 'upscale travel', 'panoramic view'],
            default => ['travel destination', 'scenic view', 'landscape', 'explorer', 'journey'],
        };
    }

}
