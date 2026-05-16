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
        $baseTerms = array_values(array_filter(array_unique([
            static::cleanSearchTerm($location),
            static::cleanSearchTerm($country),
            static::cleanSearchTerm($title),
        ])));

        $sceneTerms = static::sceneTermsFor($category);
        $variantTerms = [
            'hero',
            'wide view',
            'street scene',
            'sunrise',
            'landscape',
        ];

        $query = implode(', ', array_filter([
            $baseTerms[0] ?? '',
            $baseTerms[1] ?? '',
            $sceneTerms[$variant % count($sceneTerms)],
            $variantTerms[$variant % count($variantTerms)],
        ]));

        $signature = substr(hash('sha256', $query.'|'.$variant.'|'.($title ?? '')), 0, 12);

        return 'https://source.unsplash.com/1200x900/?'.rawurlencode($query).'&sig='.$signature;
    }

    public static function galleryImagesFor(?string $title, ?string $location, ?string $country, ?string $category): array
    {
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
