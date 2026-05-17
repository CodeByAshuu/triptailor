<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.openweathermap.org/data/2.5/weather';

    public function __construct()
    {
        $this->apiKey = config('services.openweather.key');
    }

    public function getWeatherForCity(string $city): ?array
    {
        if (!$this->apiKey) {
            return null;
        }

        $cacheKey = 'weather_' . strtolower(str_replace(' ', '_', $city));

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($city) {
            $response = Http::get($this->baseUrl, [
                'q'     => $city,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ]);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();

            return [
                'temperature' => round($data['main']['temp']) . '°C',
                'condition'   => ucfirst($data['weather'][0]['description']),
                'humidity'    => 'Humidity ' . $data['main']['humidity'] . '%',
                'icon'        => $this->mapIcon($data['weather'][0]['icon']),
                'city'        => $data['name'],
            ];
        });
    }

    private function mapIcon(string $iconCode): string
    {
        return match(true) {
            str_starts_with($iconCode, '01') => '☀️',
            str_starts_with($iconCode, '02') => '⛅',
            str_starts_with($iconCode, '03'),
            str_starts_with($iconCode, '04') => '☁️',
            str_starts_with($iconCode, '09'),
            str_starts_with($iconCode, '10') => '🌧️',
            str_starts_with($iconCode, '11') => '⛈️',
            str_starts_with($iconCode, '13') => '❄️',
            str_starts_with($iconCode, '50') => '🌫️',
            default                          => '🌡️',
        };
    }
}