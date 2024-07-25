<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

function getTradeReportCalculations($data)
{
    $funderDailyThreshold = 0;
    $funderDailyThresholdType = 'percentage';
    $funderMaxDrawdown = 0;
    $funderMaxDrawdownType = 'percentage';
    $funderPhaseOneTargetProfit = 0;
    $funderPhaseOneTargetProfitType = 'percentage';
    $funderPhaseTwoTargetProfit = 0;
    $funderPhaseTwoTargetProfitType = 'percentage';

    foreach ($data['trade_credential']['funder']['metadata'] as $funderMeta) {
        if ($funderMeta['key'] === 'daily_threshold') {
            $funderDailyThreshold = $funderMeta['value'];
        }
        if ($funderMeta['key'] === 'daily_threshold_type') {
            $funderDailyThresholdType = $funderMeta['value'];
        }
        if ($funderMeta['key'] === 'max_drawdown') {
            $funderMaxDrawdown = $funderMeta['value'];
        }
        if ($funderMeta['key'] === 'max_drawdown_type') {
            $funderMaxDrawdownType = $funderMeta['value'];
        }
        if ($funderMeta['key'] === 'phase_one_target_profit') {
            $funderPhaseOneTargetProfit = $funderMeta['value'];
        }
        if ($funderMeta['key'] === 'phase_one_target_profit_type') {
            $funderPhaseOneTargetProfitType = $funderMeta['value'];
        }
        if ($funderMeta['key'] === 'phase_two_target_profit') {
            $funderPhaseTwoTargetProfit = $funderMeta['value'];
        }
        if ($funderMeta['key'] === 'phase_two_target_profit_type') {
            $funderPhaseTwoTargetProfitType = $funderMeta['value'];
        }
    }

    $currentPhase = $data['trade_credential']['phase'];

    if ($currentPhase === 'phase-1') {
        $targetProfit = $funderPhaseOneTargetProfit;
        $targetProfitStr = ($funderPhaseOneTargetProfitType === 'percentage')? $targetProfit .'%' : $targetProfit;
    } elseif ($currentPhase === 'phase-2') {
        $targetProfit = $funderPhaseTwoTargetProfit;
        $targetProfitStr = ($funderPhaseTwoTargetProfitType === 'percentage')? $targetProfit .'%' : $targetProfit;
    } else {
        $targetProfit = 0;
        $targetProfitStr = '';
    }

    $dailyThresholdDeduction = ($funderDailyThresholdType === 'percentage')? floatval($data['latest_equity']) * (floatval($funderDailyThreshold) / 100) : floatval($funderDailyThreshold);
    $finalDailyThresholdAmount = floatval($data['latest_equity']) - floatval($dailyThresholdDeduction);
    $dailyThreshold = $finalDailyThresholdAmount;

    $maxThresholdDeduction = ($funderMaxDrawdownType === 'percentage')? floatval($data['starting_balance']) * (floatval($funderMaxDrawdown) / 100) : floatval($funderMaxDrawdown);
    $finalMaxDrawdownAmount = floatval($data['starting_balance']) - floatval($maxThresholdDeduction);
    $maxThreshold = $finalMaxDrawdownAmount;

    $rdd = ($finalDailyThresholdAmount > $finalMaxDrawdownAmount)? floatval($data['latest_equity']) - $finalDailyThresholdAmount : floatval($data['latest_equity'] - $finalMaxDrawdownAmount);

    $totalProfit = floatval($data['latest_equity']) - floatval($data['starting_balance']);
    $totalProfitPercent = ($totalProfit / floatval($data['starting_balance'])) * 100;
    $dailyPL = floatval($data['latest_equity']) - floatval($data['starting_equity']);
    $dailyPLPercent = $dailyPL / floatval($data['starting_equity']);

    $remainingTargetProfit = (floatval($data['starting_balance']) * ($targetProfit / 100)) - $totalProfit;
    $maxDrawdown = floatval($data['latest_equity'] - $finalMaxDrawdownAmount);

    return [
        'target_profit' => $targetProfit,
        'target_profit_str' => $targetProfitStr,
        'daily_threshold' => $dailyThreshold,
        'max_threshold' => $maxThreshold,
        'rdd' => $rdd,
        'total_profit' => $totalProfit,
        'total_profit_percent' => $totalProfitPercent,
        'daily_pl' => $dailyPL,
        'daily_pl_percent' => $dailyPLPercent,
        'remaining_target_profit' => $remainingTargetProfit,
        'max_drawdown' => $maxDrawdown
    ];
}

function parseArgs($array, $default)
{
    if (!is_array($array)) {
        $array = [];
    }
    if (!is_array($default)) {
        $default = [];
    }

    $newArr = [];

    foreach ($array as $key => $value) {
        $newArr[$key] = $value;
        if ($value === null && isset($default[$key])) {
            $newArr[$key] = $default[$key];
        }
    }

    return array_merge($default, $newArr);
}

function getFunderAmountsType($amount, $type)
{
    if (empty($amount)) {
        return '';
    }

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
            case 'ATTACH_SINGLE':
                $response = Http::withHeaders($headers)->attach(
                    'file', fopen($args['file']->getRealPath(), 'r'), $args['file']->getClientOriginalName()
                )->post(env('RPA_API_URL'). $endpoint);
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

    if (!isset($timezones[$timezone])) {
        return '';
    }

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
