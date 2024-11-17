<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

function getCalculatedConsistency($data)
{
    //@todo Add trading rules to admin.
    if ($data['trading_account_credential']['funder']['alias'] === 'UPFT' && $data['trading_account_credential']['starting_balance'] === '50000') {
        return '';
    }


    if (!empty($data['trading_account_credential']['history_v3'])) {
        $PnLs = [];
        $latestPayout = getLatestPayout($data);

        foreach ($data['trading_account_credential']['history_v3'] as $tradeItem) {
            if ($data['trading_account_credential']['current_phase'] === $tradeItem['status']) {
                if ($latestPayout) {
                    if ($tradeItem['created_at'] > $latestPayout) {
                        $PnLs[] = (float) $tradeItem['latest_equity'] - (float) $tradeItem['starting_daily_equity'];
                    }
                } else {
                    $PnLs[] = (float) $tradeItem['latest_equity'] - (float) $tradeItem['starting_daily_equity'];
                }
            }
        }

        if (empty($PnLs)) {
            return 100;
        }

        $highestPnL = max($PnLs);
        $totalPn = array_sum($PnLs);
        $consis = ($highestPnL/$totalPn) * 100;
        $consis = round($consis, 2);

        return ($consis >= 100)? '100+' : round($consis, 0);
    }

    return 0;
}

function getCalculatedRdd($data)
{
    $currentPhase = str_replace('phase-', '', $data['trading_account_credential']['current_phase']);
    $highestBalArr = [];

    $startingBal = (float) $data['trading_account_credential']['starting_balance'];
    $latestEqty = (float) $data['latest_equity'];
    $maxDrawdown = (float) $data['trading_account_credential']['phase_'. $currentPhase .'_max_drawdown'];

    if ($data['trading_account_credential']['drawdown_type'] === 'trailing_endofday') {
        if (!empty($data['trading_account_credential']['history_v3'])) {
            foreach ($data['trading_account_credential']['history_v3'] as $tradeItem) {
                $highestBalArr[] = (float) $tradeItem['highest_balance'];
            }
        }

        $highestBal = (!empty($highestBalArr))? max($highestBalArr) : $latestEqty;
        $bufferZone = $startingBal + $maxDrawdown;

        if ($highestBal >= $bufferZone) {
            return $latestEqty - $startingBal;
        }

        if ($highestBal <= $startingBal) {
            $maxThreshold = $startingBal - $maxDrawdown;
        } else {
            $maxThreshold = $highestBal - $maxDrawdown;
        }

        return $latestEqty - $maxThreshold;
    }

    if ($data['trading_account_credential']['drawdown_type'] === 'static') {
        $maxTreshold = $startingBal - $maxDrawdown;
        return $latestEqty - $maxTreshold;
    }

    return 'N/A';
}

function getCalculatedRdd_old($data)
{
    $currentPhase = str_replace('phase-', '', $data['trading_account_credential']['current_phase']);

    if ($data['trading_account_credential']['drawdown_type'] === 'trailing_endofday') {
        $highestBal = [$data['trading_account_credential']['starting_balance']];

        if (!empty($data['trading_account_credential']['history_v2'])) {
            foreach ($data['trading_account_credential']['history_v2'] as $tradeItem) {
                $highestBal[] = (float) $tradeItem['latest_equity'];
            }
        }

        $highestBal = max($highestBal);
        $maxTreshold = (float) $highestBal - (float) $data['trading_account_credential']['phase_'. $currentPhase .'_max_drawdown'];

        return ($highestBal >= $data['latest_equity'])? (float) $data['latest_equity'] - $maxTreshold : $data['trading_account_credential']['phase_'. $currentPhase .'_max_drawdown'];
    }

    if ($data['trading_account_credential']['drawdown_type'] === 'static') {
        $latestEquity = (float) $data['latest_equity'];
        $maxTreshold = (float) $data['trading_account_credential']['starting_balance'] - (float) $data['trading_account_credential']['phase_'. $currentPhase .'_max_drawdown'];

        return $latestEquity - $maxTreshold;
    }

    return 'N/A';
}

function getFunderAccountShortName($accountId)
{
    $toRemove = [
        'FTT-RALLY-',
        'Zero\d+k-s',
        'LV-Zero\d+k-s',
        'LV-\d+k-s'
    ];

    foreach ($toRemove as $pattern) {
        $regexPattern = '/^' . $pattern . '/';
        $accountId = preg_replace($regexPattern, '', $accountId);
    }

    return (strlen($accountId) > 7)? substr($accountId, 0, 7) .'...' : $accountId;
}

function getLatestPayout($item)
{
    if (empty($item['trading_account_credential']['payouts'])) {
        return false;
    }

    $payouts = collect($item['trading_account_credential']['payouts']);
    $filtered = $payouts->filter(function ($item) {
        return $item['status'] === 'received';
    });

    $latestPayout = $filtered->sortByDesc('created_at')->first();
    return (!empty($latestPayout['created_at']))? $latestPayout['created_at'] : false;
}

function getRemainingTargetProfit($item)
{
    $currentPhase = str_replace('phase-', '', $item['trading_account_credential']['current_phase']);
    $targetProfit = (float) $item['trading_account_credential']['phase_'. $currentPhase .'_total_target_profit'];
    $totalPnL = (float) $item['latest_equity'] - (float) $item['trading_account_credential']['starting_balance'];
    $remainingTP = $targetProfit - $totalPnL;
    $remainingTP = round($remainingTP, 2);

    return ($remainingTP <= 0 )? 0 : $remainingTP;
}

function getRemainingTradingDays($item)
{
    //@todo add trading days to admin.
    $requiredDays = 10;

    if (($item['trading_account_credential']['funder']['alias'] === 'UPFT' && $item['trading_account_credential']['starting_balance'] === '50000') ||
        ($item['trading_account_credential']['funder']['alias'] === 'UPFT' && $item['trading_account_credential']['starting_balance'] === '30000')) {
        $requiredDays = 5;
    }

    $tradingDays = getTradingDays($item);

    return $requiredDays - $tradingDays;
}

function getTradingDays($item)
{
    $history = $item['trading_account_credential']['history_v3'];

    if (empty($history)) {
        return 0;
    }

    $positiveTradingDaysFunders = [
        'upft'
    ];

    $positiveTradingDays = (in_array(strtolower($item['trading_account_credential']['funder']['alias']), $positiveTradingDaysFunders));
    $current_phase = $item['trading_account_credential']['current_phase'];
    $latestPayout = getLatestPayout($item);

    $history = collect($history);

    $tradingDaysArr = $history->filter(function ($item) use ($latestPayout, $current_phase, $positiveTradingDays) {
        if ($item['status'] === $current_phase) {
            if ($positiveTradingDays) {
                $pnl = (float) $item['latest_equity'] - (float) $item['starting_daily_equity'];
                if ($pnl <= 0) {
                    return false;
                }
            }
            if (!empty($latestPayout)) {
                return $item['created_at'] > $latestPayout;
            }
            return true;
        }
    });

    return count($tradingDaysArr);
}

function isChecked($value, $collection, $default = '', $echo = true)
{
    $checked = '';

    if (empty($collection)) {
        $checked = (!empty($default))? 'checked="checked"' : '';
    } elseif(in_array($value, $collection)) {
        $checked = 'checked="checked"';
    }

    if ($echo) {
        echo $checked;
    } else {
        return $checked;
    }
}

function renderFunderAliasAttr($funder)
{
    $theme = [
        'background_color' => '',
        'text_color' => ''
    ];

    if (!empty($funder['theme'])) {
        $theme = explode('|', $funder['theme']);
        $theme = [
            'background_color' => $theme[0],
            'text_color' => $theme[1]
        ];
    }

    return 'style="background-color: '. $theme['background_color'] .' !important; color: '. $theme['text_color'] .' !important;"';
}

function hasFunderAccountCredential($credentials, $funderId)
{
    $funderIds = [];
    foreach ($credentials as $item) {
        $funderIds[] = $item['funder_id'];
    }

    if (in_array($funderId, $funderIds)) {
        return true;
    }

    return false;
}

function getTradingSymbols()
{
    $symbolsStr = env('TRADING_SYMBOLS');
    $symbols = explode('|', $symbolsStr);
    $symbolsArr = [];

    foreach ($symbols as $val) {
        $symbolsArr[$val] = $val;
    }

    return $symbolsArr;
}

function getTradeReportCalculations($data)
{
    $currentPhase = $data['trading_account_credential']['current_phase'];

    $targetProfit = 0;
    $funderDailyThreshold = 0;
    $funderDailyThresholdType = 'fixed';
    $funderMaxDrawdown = 0;
    $funderMaxDrawdownType = 'fixed';
    $funderPhaseOneTargetProfit = 0;
    $funderPhaseOneTargetProfitType = 'fixed';
    $funderPhaseTwoTargetProfit = 0;
    $funderPhaseTwoTargetProfitType = 'fixed';

    if ($currentPhase === 'phase-1') {
        $funderDailyThreshold = (float) $data['trading_account_credential']['phase_1_daily_drawdown'];
        $funderMaxDrawdown = (float) $data['trading_account_credential']['phase_1_max_drawdown'];
        $targetProfit = (float) $data['trading_account_credential']['phase_1_daily_target_profit'];
    } elseif ($currentPhase === 'phase-2') {
        $funderDailyThreshold = (float) $data['trading_account_credential']['phase_2_daily_drawdown'];
        $funderMaxDrawdown = (float) $data['trading_account_credential']['phase_2_max_drawdown'];
        $targetProfit = (float) $data['trading_account_credential']['phase_2_daily_target_profit'];
    } elseif ($currentPhase === 'phase-3') {
        $funderDailyThreshold = (float) $data['trading_account_credential']['phase_3_daily_drawdown'];
        $funderMaxDrawdown = (float) $data['trading_account_credential']['phase_3_max_drawdown'];
        $targetProfit = (float) $data['trading_account_credential']['phase_3_daily_target_profit'];
    }

    $targetProfitStr = $targetProfit;

//    $currentPhase = $data['trading_account_credential']['current_phase'];

//    if ($currentPhase === 'phase-1') {
//        $targetProfit = $funderPhaseOneTargetProfit;
//        $targetProfitStr = ($funderPhaseOneTargetProfitType === 'percentage')? $targetProfit .'%' : $targetProfit;
//    } elseif ($currentPhase === 'phase-2') {
//        $targetProfit = $funderPhaseTwoTargetProfit;
//        $targetProfitStr = ($funderPhaseTwoTargetProfitType === 'percentage')? $targetProfit .'%' : $targetProfit;
//    } else {
//        $targetProfit = 0;
//        $targetProfitStr = '';
//    }

    $dailyThresholdDeduction = ($funderDailyThresholdType === 'percentage')? floatval($data['latest_equity']) * (floatval($funderDailyThreshold) / 100) : floatval($funderDailyThreshold);
    $finalDailyThresholdAmount = floatval($data['latest_equity']) - floatval($dailyThresholdDeduction);
    $dailyThreshold = $finalDailyThresholdAmount;

    $maxThresholdDeduction = ($funderMaxDrawdownType === 'percentage')? floatval($data['trading_account_credential']['starting_balance']) * (floatval($funderMaxDrawdown) / 100) : floatval($funderMaxDrawdown);
    $finalMaxDrawdownAmount = floatval($data['trading_account_credential']['starting_balance']) - floatval($maxThresholdDeduction);
    $maxThreshold = $finalMaxDrawdownAmount;

    $rdd = ($finalDailyThresholdAmount > $finalMaxDrawdownAmount)? floatval($data['latest_equity']) - $finalDailyThresholdAmount : floatval($data['latest_equity'] - $finalMaxDrawdownAmount);

    $totalProfit = floatval($data['latest_equity']) - floatval($data['trading_account_credential']['starting_balance']);
    $totalProfitPercent = ($totalProfit / floatval($data['trading_account_credential']['starting_balance'])) * 100;
    $dailyPL = floatval($data['latest_equity']) - floatval($data['starting_daily_equity']);
    $dailyPLPercent = $dailyPL / floatval($data['starting_daily_equity']);

    $remainingTargetProfit = (floatval($data['trading_account_credential']['starting_balance']) * ($targetProfit / 100)) - $totalProfit;
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

function getPnLHtml($data, $duration = 'daily')
{
    $pnl = ($duration === 'daily')? getDailyPnLCalculation($data, false) : getTotalPnLCalculation($data, false);
    $pnlHtmlClass = '';

    if ($pnl > 0) {
        $pnlHtmlClass = 'text-green-500';
    } elseif ($pnl < 0) {
        $pnlHtmlClass = 'text-red-500';
    }

    return '<span class="'. $pnlHtmlClass .'">'. number_format($pnl, 2) .'</span>';
}

function getTakeProfitTicks($data)
{
    if ($data['trading_account_credential']['asset_type'] === 'futures') {
        return \App\Http\Controllers\TradeController::$futuresTpPips;
    }
    if ($data['trading_account_credential']['asset_type'] === 'forex') {
        return \App\Http\Controllers\TradeController::$forexTpPips;
    }

    return 0;
}

function getStopLossTicks($data)
{
    if ($data['trading_account_credential']['asset_type'] === 'futures') {
        return \App\Http\Controllers\TradeController::$futuresSlPips;
    }
    if ($data['trading_account_credential']['asset_type'] === 'forex') {
        return \App\Http\Controllers\TradeController::$forexSlPips;
    }

    return 0;
}

function getTotalPnLCalculation($data, $formatted = true)
{
    $startingBal = (float) $data['trading_account_credential']['starting_balance'];
    $latestEquity = (float) $data['latest_equity'];
    $pnl = $latestEquity - $startingBal;

    if ($formatted) {
        return number_format($pnl, 2);
    }

    return $pnl;
}

function getDailyPnLCalculation($data, $formatted = true)
{
    $dailyEquity = (float) $data['starting_daily_equity'];
    $latestEquity = (float) $data['latest_equity'];
    $pnl = $latestEquity - $dailyEquity;

    if ($formatted) {
        return number_format($pnl, 2);
    }

    return $pnl;
}

function getCurrentRoutName()
{
    return  \Illuminate\Support\Facades\Route::currentRouteName();
}

function getCalculatedOrderAmount($data, $orderType = 'futures', $outputType = 'pips')
{
    $currentPhase = str_replace('phase-', '', $data['trading_account_credential']['current_phase']);

    $consistencyRuleType = 'fixed';
    $consistencyRule = (float) $data['trading_account_credential']['phase_'. $currentPhase .'_daily_target_profit'];
    $latestEquity = (float) $data['latest_equity'];
    $startingEquity = (float) $data['starting_daily_equity'];

    $consistencyAmount = ($consistencyRuleType === 'fixed')? $consistencyRule : ($consistencyRule / 100) * $startingEquity;
    $idealAmount = $startingEquity + $consistencyAmount;
    $takeProfit = $consistencyAmount;

    if ($latestEquity > $startingEquity && $latestEquity < $idealAmount) {
        $takeProfit = $idealAmount - $latestEquity;
    }

    if ($outputType === 'pips') {

        if ($orderType === 'futures') {
            return floor(300 / 49);
        }

        if ($orderType === 'forex') {
            $takeProfit = floor($takeProfit / 4.9);
            return $takeProfit / 100;
        }
    }

    return $takeProfit;
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
        'phase-3' => __('Live')
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

function getApiInputResponse($response, $redirect = '')
{
    if (!empty($response['validation_error'])) {
        return redirect()->back()->withErrors($response['validation_error'])->withInput();
    }

    if (!empty($response['error'])) {
        return redirect()->back()->withErrors($response['error'])->withInput();
    }

    if ($redirect !== '') {
        return redirect()->route('trading-account.credential.funders.accounts')->with('success', $response['message']);
    }

    return redirect()->back()->with('success', $response['message']);
}

function requestApi($method, $endpoint, $args = [], $token = false)
{
    try {
        $sessionToken = (!$token)? Session::get('innove_auth_api') : $token;

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

function getProfileIcon($fileName)
{
    $url = rtrim(env('RPA_API_URL'), '/');
    $url = str_replace('api', '', $url);
    return $url .'/storage/images/'. $fileName;
}

function getCountryImage($country)
{
    $country = strtolower($country);

    switch ($country) {
        case 'philippines':
        case 'ph':
            return 'ph.jpg';
        case 'america':
        case 'united states':
        case 'us':
        case 'usa':
            return 'us.png';
    }

    return '';
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
