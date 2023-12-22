<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\CachedWeather;

class WeatherController extends Controller
{
    public function current(Request $request)
    {
        try {
            $city = $request->query('query');

            if(!$city){
                return response()->json(['error' => 'An error occurred while fetching weather data, need a query']);
            }

            //Check if we already have the city's data in the database
            $cachedData = CachedWeather::where('city_name', $city)
                ->where('created_at', '>=', now()->subHour())
                ->first();

            if (!$cachedData) {
                $accessKey = env('WEATHER_API_ACCESS_KEY');

                $response = Http::get('http://api.weatherstack.com/current', [
                    'access_key' => $accessKey,
                    'query' => $city,
                ]);
        
                $api_result = $response->json();

                if(!isset($api_result['current'])){
                    return response()->json(['error' => 'Invalid data format or missing "current" key']);
                }

                //Storee only the current data
                $currentWeather = $api_result['current'];
                
        
                //Store data in the database
                CachedWeather::create([
                    'city_name' => $city,
                    'weather_data' => json_encode($currentWeather)
                ]);
            }

            return response()->json(
                isset($api_result) ? $api_result : json_decode($cachedData->weather_data)
            );
        }catch (RequestException $e) {
            // Handle HTTP request exception
            return response()->json(['error' => 'HTTP request failed']);
        }
    }

    //Scrapeo
    public function baWeather(Request $request)
    {
        try {
            $response = Http::get('https://www.tiempo.com/buenos-aires.htm');

            $crawler = new Crawler($response->body());

            if (!$crawler->filter('.dato-temperatura')->count()) {
                return response()->json(['error' => 'Temperature is not available at this time.']);
            }

            $temperature = $crawler->filter('.dato-temperatura')->text();

            return response()->json(['temperature' => $temperature]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching temperature data']);
        }
    }
}
