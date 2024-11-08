<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function auditionDashboard()
    {
        $tradingReport = $this->getTradingReport('phase-2');

        return view('dashboard', $tradingReport);
    }

    public function dashboard()
    {
        $tradingReport = $this->getTradingReport('phase-3');

        return view('dashboard', $tradingReport);
    }

    private function getTradingReport($phase = null)
    {
        $ongoingTrades = $this->getOngoingTrades(new Request([
            'current_phase' => $phase
        ]));

        $forPayouts = [];

        if ($phase === 'phase-3') {
            $forPayouts = requestApi('get', 'trade/payouts');
        }

        $recentTrades = $this->getTradeHistory(new Request([
            'current_phase' => $phase,
            'orderBy' => 'created_at',
            'order' => 'desc',
            'range' => 'currentMonth'
        ]));
//!d($recentTrades);
//die();
        $dashboardReports = $this->getDashboardGeneralReports($recentTrades, $phase);

        return [
            'ongoingTrades' => $ongoingTrades,
            'dashboardReports' => $dashboardReports,
            'recentTrades' => $recentTrades,
            'forPayouts' => $forPayouts
        ];
    }

    public function getDashboardGeneralReports($recentTrades = [], $phase = null)
    {
        $totalDailyProfit = [];
        $totalWeeklyProfit = [];

        if (empty($recentTrades)) {
            $recentTrades = $this->getTradeHistory(new Request([
                'current_phase' => $phase,
                'orderBy' => 'created_at',
                'order' => 'desc',
                'range' => 'currentMonth'
            ]));
        }

        foreach ($recentTrades as $historyItem) {

            $date = Carbon::parse($historyItem['created_at']);
            $dailyProfit = (float) $historyItem['latest_equity'] - (float) $historyItem['starting_daily_equity'];
            $totalProfit = (float) $historyItem['trading_account_credential']['trade_reports']['latest_equity'] - (float) $historyItem['trading_account_credential']['starting_balance'];

            if ($dailyProfit > 0 && $date->isToday() && !isset($totalDailyProfit[$historyItem['trade_account_credential_id']])) {
                $totalDailyProfit[$historyItem['trade_account_credential_id']] = $dailyProfit;
            }

            if ($totalProfit > 0 && $date->isCurrentWeek() && !isset($totalWeeklyProfit[$historyItem['trade_account_credential_id']])) {
                $totalWeeklyProfit[$historyItem['trade_account_credential_id']] = $totalProfit;
            }

            $tradeAccountIds[] = $historyItem['trade_account_credential_id'];
        }

        $totalMonthlyProfit = $this->getTotalProfitWithinMonth($recentTrades);

        $reportItems = requestApi('get', 'trade/reports', [
            'current_phase' => $phase
        ]);

        $totalEquity = [];

        foreach ($reportItems as $item) {
            $totalEquity[] = $item['latest_equity'];
        }

        return [
            'totalDailyProfit'     => array_sum($totalDailyProfit),
            'totalWeeklyProfit'    => array_sum($totalWeeklyProfit),
            'totalMonthlyProfit'   => $totalMonthlyProfit,
            'totalEquity'          => array_sum($totalEquity)
        ];
    }

    public function getTotalProfitWithinMonth(array $records)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Step 1: Filter records for the current month
        $filteredRecords = collect($records)->filter(function ($record) use ($currentMonth, $currentYear) {
            $createdAt = Carbon::parse($record['created_at']);
            return $createdAt->month == $currentMonth && $createdAt->year == $currentYear;
        });

        // Step 2: Group by trade_account_credential_id and filter by the latest record within the same week
        $groupedRecords = $filteredRecords->groupBy('trade_account_credential_id')->map(function ($group) {
            return $group->sortByDesc('created_at')->unique(function ($record) {
                // Group by week number (to make sure we only include the latest one per week)
                return Carbon::parse($record['created_at'])->weekOfYear;
            });
        });

        // Step 3: Calculate the total profit
        $totalProfit = $groupedRecords->flatten(1)->sum(function ($record) {
            $startingBalance = $record['trading_account_credential']['starting_balance'];
            $latestEquity = $record['trading_account_credential']['trade_reports']['latest_equity'];
            $profit = $latestEquity - $startingBalance;

            // Only sum the positive profits
            return $profit > 0 ? $profit : 0;
        });

        return $totalProfit;
    }


//    public function getTradeHistoryIds($params)
//    {
//        $tradeAccountIds = [];
//        $recentTrades = $this->getTradeHistory(new Request($params));
//
//        if (!empty($recentTrades)) {
//            foreach ($recentTrades as $item) {
//                $tradeAccountIds[] = $item['trade_account_credential_id'];
//            }
//        }
//
//        return $tradeAccountIds;
//    }

    public function getOngoingTrades(Request $request)
    {
        return requestApi('get', 'investor/ongoing-trades', $request->all());
    }

    public function getTradeHistory(Request $request)
    {
        return requestApi('get', 'trade/history', $request->all());
    }

    public function getPayouts(Request $request)
    {
        return requestApi('get', 'trade/payouts', $request->all());
    }
}
