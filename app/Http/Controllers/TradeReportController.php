<?php

namespace App\Http\Controllers;

use App\Forms\TradeReportForm;
use App\Forms\TradingAccountCredentialForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class TradeReportController extends Controller
{
    public static $statuses = [
        'idle' => 'Idle',
        'trading' => 'Trading',
        'pairing' => 'Paired',
        'abstained' => 'ABS',
        'breached' => 'BRC',
        'breachedcheck' => 'BRC-CHECK',
        'waiting' => 'WAITING',
        'onhold' => 'OH',
        'kyc' => 'KYC',
        'payout' => 'FOR PAYOUT'
    ];

    public function index()
    {
        $items = requestApi('get', 'trade/reports');

        return view('dashboard.trade.report.index')->with([
            'items' => $items
        ]);
    }

    public function getLatestTrades()
    {
        $items = requestApi('get', 'trade/report/latest');

        return view('dashboard.trade.history-v2.index')->with([
           'tradeHistory' => $items
        ]);
    }

    public function getReports(Request $request)
    {
        $pairingItemsList = requestApi('get', 'trade/reports', $request->except('_token'));
        $queueItems = requestApi('get', 'trade/queue');

        $htmlList = [];

        foreach ($pairingItemsList as $item) {
            $htmlList[$item['id']] = view('dashboard.trade.report.item', [
                'item' => $item,
                'controls' => true,
                'pairingUnitsHandler' => [$item['trading_account_credential']['user_account']['trading_unit']['unit_id']]
            ])->render();
        }

        $htmlPairedItems = [];

        foreach ($queueItems['pairedItems'] as $index => $pairedItem) {
            $htmlPairedItems[] = view('dashboard.trade.play.paired-item', [
                'pairedItemData' => $pairedItem,
                'index' => $index
            ])->render();
        }

        return response()->json([
            'list' => $htmlList,
            'pairedItems' => $htmlPairedItems
        ]);
    }

    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(TradeReportForm::class, [
            'method' => 'POST',
            'url' => route('trade.report.store')
        ]);

        return view('dashboard.trade.report.create')->with([
            'form' => $form
        ]);
    }

    public function store(Request $request)
    {
        $response = requestApi('post', 'trade/report', $request->except('_token'));

        if (!empty($response['errors'])) {
            return redirect()->back()->withErrors($response['errors'])->withInput();
        }

        return redirect()->route('trade.report')->with('success', $response['message']);
    }

    public function edit(FormBuilder $formBuilder, string $id)
    {
        $item = requestApi('get', 'trade/report/'. $id);

        if (empty($item) || !empty($item['errors'])) {
            return redirect()->route('trade.report');
        }

        $form = $formBuilder->create(TradeReportForm::class, [
            'method' => 'POST',
            'url' => route('trade.report.update', $item['id'])
        ], ['data' => $item]);

        return view('dashboard.trade.report.edit')->with([
            'form' => $form
        ]);
    }

    public function update(Request $request, string $id)
    {
        $itemUpdate = requestApi('post', 'trade/report/'. $id, array_filter($request->except('_token')));

        if (!empty($itemUpdate['errors'])) {
            return redirect()->back()->withErrors($itemUpdate['errors'])->withInput();
        }

        return redirect()->route('trade.play')->with('success', $itemUpdate['message']);
    }

    public function updateTradeSettings(Request $request)
    {
        $response = requestApi('post', 'trade/update-trade-report-settings', $request->except('__token'));

        if (empty($response)) {
            return redirect()->back()->with('error', __('Error updating the purchase type'));
        }

        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $removeFunder = requestApi('delete', 'trade/report/'. $id);

        if (!empty($removeFunder['errors'])) {
            return redirect()->back()->with('error', $removeFunder['errors']);
        }

        return redirect()->route('trade.report')->with('success', $removeFunder['message']);
    }
}
