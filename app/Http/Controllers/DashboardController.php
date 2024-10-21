<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function auditionDashboard()
    {

    }

    public function dashboard()
    {
        $tradingReport = $this->getTradingReport('phase-3');

        return view('dashboard', [
            'ongoingTrades'     => $tradingReport['ongoingTrades'],
            'totalDailyProfit'  => $tradingReport['totalDailyProfit'],
            'totalWeeklyProfit' => $tradingReport['totalWeeklyProfit'],
            'finalTotalProfit'  => $tradingReport['finalTotalProfit'],
            'tradeCount'        => $tradingReport['tradeCount'],
            'recentTrades'      => $tradingReport['recentTrades'],
            'forPayouts'        => $tradingReport['forPayouts']
        ]);
    }

    private function getTradingReport($phase = null)
    {
        $ongoingTrades = requestApi('get', 'investor/ongoing-trades', [
            'current_phase' => $phase
        ]);

        $tradeHistory = requestApi('get', 'trade/history', [
            'current_phase' => $phase
        ]);

        $forPayouts = requestApi('get', 'trade/payouts');

        $totalWeeklyProfit = [];
        $totalDailyProfit = [];
        $finalTotalProfit = [];
        $recentTrades = [];

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

                $recentTrades[] = $item;
            }
        }

        return [
            'ongoingTrades' => $ongoingTrades,
            'totalDailyProfit' => array_sum($totalDailyProfit),
            'totalWeeklyProfit' => array_sum($totalWeeklyProfit),
            'finalTotalProfit' => array_sum($finalTotalProfit),
            'tradeCount' => count($tradeHistory),
            'recentTrades' => $recentTrades,
            'forPayouts' => $forPayouts
        ];
    }
}
