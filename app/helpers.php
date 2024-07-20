<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

function getFunderAmountsType($amount, $type)
{
    if ($type === 'percentage') {
        return $amount .'%';
    } elseif ($type === 'fixed') {
        return '$'. $amount;
    }

    return $amount;
}

function getPhaseName($phase)
{
    $phases = [
        'phase-1' => __('Phase 1'),
        'phase-2' => __('Phase 2'),
        'phase-3' => __('Phase 3')
    ];

    if (!isset($phases[$phase])) {
        return '';
    }

    return $phases[$phase];
}

function getFunderStepName($key)
{
    $steps = [
        '1-step' => __('1 Step'),
        '2-step' => __('2 Step'),
        'funded' => __('Funded')
    ];

    if (!isset($steps[$key])) {
        return '';
    }

    return $steps[$key];
}

function lastRouteSegment()
{
    $urlSegments = request()->segments();
    return \Illuminate\Support\Arr::last($urlSegments);
}

function firstRouteSegment()
{
    $urlSegments = request()->segments();
    return \Illuminate\Support\Arr::first($urlSegments);
}

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

function getTimeZoneOffset($timezone)
{
    $timezones = getTimezonesWithOffsets(false);

    return $timezones[$timezone];
}

function getTimezonesWithOffsets($hasAbbreviation = true)
{
    $timezoneMapping = [
        'Pacific/Honolulu' => ['abbr' => 'HST', 'city' => 'Honolulu'],
        'America/Anchorage' => ['abbr' => 'AKST', 'city' => 'Anchorage'],
        'America/Los_Angeles' => ['abbr' => 'PST', 'city' => 'Los Angeles'],
        'America/Denver' => ['abbr' => 'MST', 'city' => 'Denver'],
        'America/Phoenix' => ['abbr' => 'MST', 'city' => 'Phoenix'],
        'America/Chicago' => ['abbr' => 'CST', 'city' => 'Chicago'],
        'America/New_York' => ['abbr' => 'EST', 'city' => 'New York'],
        'America/Caracas' => ['abbr' => 'VET', 'city' => 'Caracas'],
        'America/Sao_Paulo' => ['abbr' => 'BRT', 'city' => 'São Paulo'],
        'Atlantic/Azores' => ['abbr' => 'AZOT', 'city' => 'Azores'],
        'Europe/London' => ['abbr' => 'GMT', 'city' => 'London'],
        'Europe/Paris' => ['abbr' => 'CET', 'city' => 'Paris'],
        'Europe/Berlin' => ['abbr' => 'CET', 'city' => 'Berlin'],
        'Europe/Moscow' => ['abbr' => 'MSK', 'city' => 'Moscow'],
        'Africa/Cairo' => ['abbr' => 'EET', 'city' => 'Cairo'],
        'Asia/Dubai' => ['abbr' => 'GST', 'city' => 'Dubai'],
        'Asia/Karachi' => ['abbr' => 'PKT', 'city' => 'Karachi'],
        'Asia/Kolkata' => ['abbr' => 'IST', 'city' => 'Kolkata'],
        'Asia/Bangkok' => ['abbr' => 'ICT', 'city' => 'Bangkok'],
        'Asia/Hong_Kong' => ['abbr' => 'HKT', 'city' => 'Hong Kong'],
        'Asia/Tokyo' => ['abbr' => 'JST', 'city' => 'Tokyo'],
        'Australia/Sydney' => ['abbr' => 'AEST', 'city' => 'Sydney'],
        'Pacific/Auckland' => ['abbr' => 'NZST', 'city' => 'Auckland'],
    ];

    $timezoneAbbreviations = [];

    foreach ($timezoneMapping as $timezone => $info) {
        $datetime = new DateTime('now', new DateTimeZone($timezone));
        $offset = $datetime->format('P'); // Format the offset as +hh:mm or -hh:mm
        $abbreviation = $info['abbr'];
        $city = $info['city'];

        if ($hasAbbreviation) {
            $timezoneAbbreviations[$timezone] = "{$abbreviation} - GMT{$offset} ({$city})";
        } else {
            $timezoneAbbreviations[$timezone] = "GMT{$offset} ({$city})";
        }
    }

    return $timezoneAbbreviations;
}
