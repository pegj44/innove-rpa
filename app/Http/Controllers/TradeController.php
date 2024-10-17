<?php

namespace App\Http\Controllers;

use App\Forms\TradeReportForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Session;

class TradeController extends Controller
{
    public static $futuresTpPips = 49;
    public static $futuresSlPips = 51;
    public static $forexTpPips = 4.9;
    public static $forexSlPips = 5.1;

    public function removeAllPairs()
    {
        $remove = requestApi('get', 'remove-all-pairs');

        return response()->json($remove);
    }

    public function index()
    {
        $pairedItems = requestApi('get', 'trade/paired-items');
        $tradingAccounts = requestApi('get', 'trade/reports');;

        return view('dashboard.trade.play.index')->with([
            'pairedItems' => $pairedItems,
            'tradingAccounts' => $tradingAccounts
        ]);
    }

    public function removePair(Request $request, $id)
    {
        $removePair = requestApi('delete', 'trade/pair/'. $id .'/remove', $request->except('_token'));

        return redirect()->route('trade.play');
    }

    public function pairManual(Request $request)
    {
        $pair = requestApi('post', 'trade/pair-manual', $request->except('_token'));

        return redirect()->route('trade.play');
    }

    public function pairAccounts()
    {
        $pairs = requestApi('post', 'trade/pair-accounts');

        if (empty($pairs) || isset($pairs['error'])) {
//            return redirect()->back()->with('error', __('No available accounts to pair'));
            return response()->json([
                'success' => false,
                'error' => $pairs['error']
            ]);
        }

//        return redirect()->route('trade.play')->with('pairedItems', $pairs);

        return response()->json([
            'success' => true,
            'accounts' => $pairs
        ]);
    }

    public function initiateTrade(Request $request)
    {
        $response = requestApi('post', 'trade/initiate', $request->except('__token'));

        if (isset($response['error'])) {
            return redirect()->back()->with('error', $response['error']);
        }

        return redirect()->back()->with('success', $response['message']);
    }

    public function clearPairing()
    {
        $response = requestApi('delete', 'trade/paired-items');

        return redirect()->route('trade.play');
    }
}
