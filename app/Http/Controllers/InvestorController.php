<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function tradeAccounts()
    {
        $queueItems = requestApi('get', 'trade/queue');
        $tradingAccounts = requestApi('get', 'trade/reports');

        return view('dashboard.trade.investor.trade-accounts')->with([
            'tradingItems' => $queueItems['tradingItems'],
            'tradingAccounts' => $tradingAccounts,
            'enableTradeControls' => false
        ]);
    }

    public function tradeHistory()
    {
        $ongoingTrades = requestApi('get', 'investor/ongoing-trades');
        $tradeHistory = requestApi('get', 'trade-history/list');

        return view('dashboard.trade.history.index', [
            'items' => [],
            'tradeHistory' => $tradeHistory,
            'ongoingTrades' => $ongoingTrades
        ]);
    }

    public function profitReport()
    {

    }

    public function funderAccounts()
    {
        $items = requestApi('get', 'credentials');

        return view('dashboard.trading-credentials.investor.index')->with([
            'items' => $items
        ]);
    }

    public function userAccounts()
    {
        $items = requestApi('get', 'trading-individuals');

        return view('dashboard.trading-individual.investor.index')->with([
            'items' => $items
        ]);
    }

    public function funders()
    {
        $funders = requestApi('get', 'funders');

        return view('dashboard.funders.investor.index')->with([
            'funders' => $funders
        ]);
    }
}
