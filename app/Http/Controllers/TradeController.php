<?php

namespace App\Http\Controllers;

use App\Forms\TradeReportForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Session;

class TradeController extends Controller
{
    public function index()
    {
        $pairedItems = requestApi('get', 'trade/paired-items');

        return view('dashboard.trade.play.index')->with([
            'pairedItems' => $pairedItems
        ]);
    }

    public function setTradeAccountPurchaseType(Request $request)
    {
        $response = requestApi('post', 'trade/set-account-purchase-type', $request->except('__token'));

        if (empty($response)) {
            return response()->json('error', __('Error updating the purchase type.'));
        }

        return response()->json($response);
    }

    public function pairAccounts()
    {
        $pairs = requestApi('post', 'trade/pair-accounts');

        if (empty($pairs)) {
//            return redirect()->back()->with('error', __('No available accounts to pair'));
            return response()->json(['result' => false]);
        }

//        return redirect()->route('trade.play')->with('pairedItems', $pairs);

        return response()->json(['result' => $pairs]);
    }

    public function initiateTrade(Request $request)
    {
        $response = requestApi('post', 'trade/initiate', $request->except('__token'));

        if (empty($response)) {
            return redirect()->back()->with('error', __('The unit is not connected.'));
        }

        return redirect()->back()->with('success', __('Unit is now initiating.'));
    }

    public function clearPairing()
    {
        $response = requestApi('delete', 'trade/paired-items');

        return redirect()->route('trade.play');
    }
}
