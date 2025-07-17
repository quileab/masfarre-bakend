<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GoogleMapsController extends Controller
{
    public function getReviews()
    {
        $placeId = env('GMAPS_PLACE_ID');
        $apiKey = env('GMAPS_API_KEY');

        if (!$placeId || !$apiKey) {
            return response()->json(['error' => 'Google Maps API Key or Place ID not configured.'], 500);
        }

        $url = "https://maps.googleapis.com/maps/api/place/details/json?place_id=" . urlencode($placeId) . "&fields=reviews&key=" . urlencode($apiKey) . "&language=es";

        $response = Http::get($url);
        $data = $response->json();

        if ($data && isset($data['result']['reviews'])) {
            $comentariosFiltrados = array_filter($data['result']['reviews'], function ($review) {
                return $review['rating'] > 3;
            });

            $comentariosFiltrados = array_slice($comentariosFiltrados, 0, 5);

            return response()->json($comentariosFiltrados);
        } else {
            return response()->json(['error' => 'No se pudieron obtener los comentarios.'], 500);
        }
    }
}