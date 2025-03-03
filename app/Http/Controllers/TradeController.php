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

    public function magicPair(Request $request)
    {
//        $tradeStart = requestApi('post', 'trade/start', $request->except('_token'));

        return response()->json(['test' => 1, 'data' => $request->all()]);
    }

    public function recoverTrade(Request $request)
    {
        $tradeRecover = requestApi('post', 'trade/recover', $request->except('_token'));

        if (!empty($tradeRecover['errors'])) {
            return redirect()->back()->with('error', $tradeRecover['errors']);
        }

        return redirect()->back()->with('success', 'Recovering trade...');
    }

    public function startTrade(Request $request)
    {
        $tradeStart = requestApi('post', 'trade/start', $request->except('_token'));

        if (!empty($tradeStart['errors'])) {
            return redirect()->back()->with('error', $tradeStart['errors']);
        }

        return redirect()->back()->with('success', $tradeStart['message']);
    }

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

    public function getPairData(Request $request)
    {
        $queueData = requestApi('post', 'trade/pair-units', $request->except('_token'));

        return response()->json($queueData);
    }

    public function removeAllPairs()
    {
        $remove = requestApi('get', 'remove-all-pairs');

        return response()->json($remove);
    }

    public function index()
    {
        $queueItems = requestApi('get', 'trade/queue');
        $tradingAccounts = requestApi('get', 'trade/reports');
        $funders = requestApi('get', 'funders');
        $filterSettings = requestApi('get', 'user/settings', [
            'key' => 'trading_filters'
        ]);

        $workingItemsHandler = [];
        $pairingUnitsHandler = [];

        foreach ($queueItems['pairedItems'] as $pairedItem) {
            foreach ($pairedItem['data'] as $pairedItemData) {
                $itemFunder = str_replace(' ', '_', $pairedItemData['funder']);
                $workingItemsHandler[] = strtolower($itemFunder) .'_'. $pairedItemData['unit_id'];
                $pairingUnitsHandler[] = $pairedItemData['unit_id'];
            }
        }

        foreach ($queueItems['tradingItems'] as $tradingItem) {
            foreach ($tradingItem['data'] as $tradingItemData) {
                $itemFunder = str_replace(' ', '_', $tradingItemData['funder']);
                $workingItemsHandler[] = strtolower($itemFunder) .'_'. $tradingItemData['unit_id'];
            }
        }

        return view('dashboard.trade.play.index')->with([
            'pairedItems' => $queueItems['pairedItems'],
            'tradingItems' => $queueItems['tradingItems'],
            'workingItemsHandler' => $workingItemsHandler,
            'pairingUnitsHandler' => $pairingUnitsHandler,
            'tradingAccounts' => $tradingAccounts,
            'funders' => $funders,
            'filterSettings' => (!empty($filterSettings))? $filterSettings['value'] : []
        ]);
    }

    public function removePair(Request $request, $id)
    {
        $removePair = requestApi('delete', 'trade/pair/'. $id .'/remove', $request->except('_token'));

        return redirect()->route('trade.play');

//        if (empty($removePair) || isset($removePair['error'])) {
//            return response()->json([
//                'success' => false,
//                'error' => $removePair['error']
//            ]);
//        }
//
//        return response()->json([
//            'success' => true,
//            'message' => __('Successfully cancelled pairing')
//        ]);
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

    public function reInitializeTrade(Request $request)
    {
        $response = requestApi('post', 'trade/re-initialize', $request->except('_token'));

        if (isset($response['error'])) {
            return redirect()->back()->with('error', $response['error']);
        }

        return redirect()->back()->with('success', $response['message']);
    }

    public function initiateTradeV2(Request $request)
    {
        $response = requestApi('post', 'trade/initiate-v2', $request->except('_token'));

        if (isset($response['error'])) {
            return response()->json([
                'error' => $response['error'],
                'message' => view('components.notification-error', ['message' => $response['error'], 'index' => 1])->render()
            ]);
        }

        return response()->json([
            'message' => view('components.notification-error', ['message' => $response['message'], 'index' => 1])->render()
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
