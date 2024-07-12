<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

function requestApi($method, $endpoint, $args = [])
{
    try {
        $sessionToken = Session::get('innove_auth_api');

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $sessionToken,
        ];

        switch (strtoupper($method)) {
            case 'GET':
                $response = Http::withHeaders($headers)->get(env('RPA_API_URL'). $endpoint, $args);
                break;
            case 'POST':
                $response = Http::withHeaders($headers)->post(env('RPA_API_URL'). $endpoint, $args);
                break;
            case 'PUT':
                $response = Http::withHeaders($headers)->put(env('RPA_API_URL'). $endpoint, $args);
                break;
            case 'DELETE':
                $response = Http::withHeaders($headers)->delete(env('RPA_API_URL'). $endpoint, $args);
                break;
            default:
                throw new InvalidArgumentException("Invalid HTTP method: $method");
        }

        return $response->json();
    } catch (\Exception $e) {
        return [];
    }
}

function getRequest($endpoint, $args = [])
{
    try {
        $sessionToken = Session::get('innove_auth_api');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $sessionToken,
        ])->get(env('RPA_API_URL'). $endpoint, $args);

        return $response->json();
    } catch (\Exception $e) {
        return [];
    }
}

function postRequest($endpoint, $args = [])
{
    try {
        $sessionToken = Session::get('innove_auth_api');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $sessionToken,
        ])->post(env('RPA_API_URL'). $endpoint, $args);

        return $response->json();
    } catch (\Exception $e) {
        return [];
    }
}
