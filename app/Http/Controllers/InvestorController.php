<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvestorController extends Controller
{
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

    public function funders()
    {
        $funders = requestApi('get', 'funders');

        return view('dashboard.funders.investor.index')->with([
            'funders' => $funders
        ]);
    }
}
