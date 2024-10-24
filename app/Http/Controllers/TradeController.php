<?php

namespace App\Http\Controllers;

use App\Forms\TradeHistoryForm;
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

    public function destroyHistory(string $id)
    {
        $item = requestApi('delete', 'trade-history/'. $id);

        if (!empty($item['errors'])) {
            return redirect()->back()->with('error', $item['errors']);
        }

        return redirect()->back()->with('success', $item['message']);
    }

    public function updateHistory(Request $request, string $id)
    {
        $item = requestApi('put', 'trade-history/'. $id, $request->except('_token'));

        if (!empty($item['validation_error'])) {
            return redirect()->back()->withErrors($item['validation_error'])->withInput()->with('error', 'Failed to update item, please check the fields.');
        }

        if (!empty($item['errors'])) {
            return redirect()->back()->with('error', $item['errors']);
        }

        return redirect()->route('trade.history')->with('success', $item['message']);
    }

    public function editHistory(FormBuilder $formBuilder, string $id)
    {
        $item = requestApi('get', 'trade-history/'. $id);

        if (empty($item) || !empty($item['errors'])) {
            return redirect('trade/history');
        }

        $form = $formBuilder->create(TradeHistoryForm::class, [
            'method' => 'PUT',
            'url' => route('trade.history.edit', $item['id'])
        ], $item);

        return view('dashboard.trade.history.edit')->with([
            'form' => $form
        ]);
    }

    public function createHistory(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(TradeHistoryForm::class, [
            'method' => 'POST',
            'url' => route('trade.history.store')
        ]);

        return view('dashboard.trade.history.create')->with([
            'form' => $form
        ]);
    }

    public function storeHistory(Request $request)
    {
        $response = requestApi('post', 'trade-history/add', $request->except('_token'));

        if (!empty($response['validation_error'])) {
            return redirect()->back()->with('error', __('Please check the field errors below.'))->withErrors($response['validation_error'])->withInput();
        }

        if (!empty($response['errors'])) {
            return redirect()->back()->with('error', $response['errors']);
        }

        return redirect()->route('trade.history')->with('success', $response['message']);
    }

    public function getTradeHistoryView()
    {
        $tradeHistory = requestApi('get', 'trade-history/list');

        return view('dashboard.trade.history.index', [
            'items' => [],
            'tradeHistory' => $tradeHistory
        ]);
    }

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
