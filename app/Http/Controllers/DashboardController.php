<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $ongoingTrades = requestApi('get', 'investor/ongoing-trades');
        $tradeHistory = requestApi('get', 'trade/history');

        $totalWeeklyProfit = [];
        $totalDailyProfit = [];
        $finalTotalProfit = [];


        if (!empty($tradeHistory)) {
            foreach ($tradeHistory as $item) {
                $date = Carbon::parse($item['created_at']);
                $dailyProfit = (float) $item['latest_equity'] - (float) $item['starting_daily_equity'];
                $totalProfit = (float) $item['latest_equity'] - (float) $item['trading_account_credential']['starting_balance'];
                $totalProfit = ($totalProfit > 0)? $totalProfit : 0;

                $finalTotalProfit[] = $totalProfit;

                if ($dailyProfit > 0 && $date->isToday()) {
                    $totalDailyProfit[] = $dailyProfit;
                }

                if ($dailyProfit > 0 && $date->isCurrentWeek()) {
                    $totalWeeklyProfit[] = $dailyProfit;
                }
            }
        }

        return view('dashboard', [
            'ongoingTrades' => $ongoingTrades,
            'totalDailyProfit' => array_sum($totalDailyProfit),
            'totalWeeklyProfit' => array_sum($totalWeeklyProfit),
            'finalTotalProfit' => array_sum($finalTotalProfit),
            'tradeCount' => count($tradeHistory)
        ]);
    }
}
