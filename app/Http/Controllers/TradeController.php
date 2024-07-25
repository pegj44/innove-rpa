<?php

namespace App\Http\Controllers;

use App\Forms\TradeReportForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class TradeController extends Controller
{
    public function index()
    {
        $pairedItems = requestApi('get', 'trade/paired-items');

        return view('dashboard.trade.play.index')->with([
            'pairedItems' => $pairedItems
        ]);
    }

    public function pairAccounts()
    {
        $pairs = requestApi('post', 'trade/pair-accounts');

        if (empty($pairs)) {
            return redirect()->back()->with('success', __('No available accounts to pair'));
        }

        return redirect()->route('trade.play')->with('pairedItems', $pairs);
    }
}
