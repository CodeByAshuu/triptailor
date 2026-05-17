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

        $city = trim($city);
        $cacheKey = 'weather_' . strtolower(str_replace(' ', '_', $city));

        if ($cached = Cache::get($cacheKey)) {
            return $cached;
        }

        $response = Http::get($this->baseUrl, [
            'q'     => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        if (!$response->successful()) {
            \Log::error('Weather API failed for city: ' . $city, [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return null;
        }

        $data = $response->json();

        $weather = [
            'temperature' => round($data['main']['temp']) . '°C',
            'condition'   => ucfirst($data['weather'][0]['description']),
            'humidity'    => 'Humidity ' . $data['main']['humidity'] . '%',
            'icon'        => $this->mapIcon($data['weather'][0]['icon']),
            'city'        => $data['name'],
        ];

        Cache::put($cacheKey, $weather, now()->addMinutes(30));

        return $weather;
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

    public function getForecastForCity(string $city): ?array
    {
        if (!$this->apiKey) {
            return null;
        }

        $city = trim($city);
        $cacheKey = 'forecast_' . strtolower(str_replace(' ', '_', $city));

        if ($cached = Cache::get($cacheKey)) {
            return $cached;
        }

        $forecastUrl = str_replace('/weather', '/forecast', $this->baseUrl);
        $response = Http::get($forecastUrl, [
            'q'     => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        if (!$response->successful()) {
            \Log::error('Weather API failed for city: ' . $city, [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return null;
        }

        $data = $response->json();
        
        // Extract daily forecasts (taking one reading per day around noon)
        $dailyForecasts = [];
        foreach ($data['list'] as $item) {
            $date = explode(' ', $item['dt_txt'])[0];
            if (!isset($dailyForecasts[$date]) || str_contains($item['dt_txt'], '12:00:00')) {
                $dailyForecasts[$date] = [
                    'date' => $date,
                    'temperature' => round($item['main']['temp']),
                    'icon' => $this->mapIcon($item['weather'][0]['icon'])
                ];
            }
        }

        $forecast = array_values(array_slice($dailyForecasts, 0, 5));
        
        Cache::put($cacheKey, $forecast, now()->addMinutes(120));

        return $forecast;
    }
}