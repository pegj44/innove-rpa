<?php

namespace App\Http\Controllers;

use App\Forms\TradeReportForm;
use App\Forms\TradingAccountCredentialForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class TradeReportController extends Controller
{
    public function index()
    {
        $items = requestApi('get', 'trade/reports');

        return view('dashboard.trade.report.index')->with([
            'items' => $items
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

        return redirect()->route('trade.report')->with('success', $itemUpdate['message']);
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
