<?php

namespace App\Http\Controllers;

use App\Forms\AddFunderForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class FunderController extends Controller
{
    public static $platforms = [
        'MT5_Web' => 'MT5-Web',
        'Rtrader_base' => 'Rithmic Trader',
        'UProfitTradingView' => 'UProfit Trading View',
        'Tradoverse_1' => 'Tradoverse',
        'ProjectX_1' => 'ProjectX',
        'NinjaTrader' => 'Ninja Trader',
        'TradingView_1' => 'TradingView'
    ];

    public static $webPlatforms = [
        'MT5_Web' => 'MT5-Web',
        'UProfitTradingView' => 'UProfit Trading View',
    ];

    public static $pipCalculationTypes = [
        'volume' => 'Volume',
        'contract' => 'Contract'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $funders = requestApi('get', 'funders');

        return view('dashboard.funders.index')->with([
            'funders' => $funders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(AddFunderForm::class, [
            'method' => 'POST',
            'url' => route('funder.store')
        ]);

        return view('dashboard.funders.add')->with([
            'form' => $form
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $funder = requestApi('post', 'funder', parseArgs($request->except('_token'), [
            'reset_time' => '',
            'reset_time_zone' => ''
        ]));

        if (!empty($funder['validation_error'])) {
            return redirect()->back()->with('error', __('Please check the field errors below.'))->withErrors($funder['validation_error'])->withInput();
        }

        if (!empty($funder['errors'])) {
            return redirect()->back()->with('error', $funder['errors']);
        }

        return redirect()->route('funders')->with('success', $funder['message']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormBuilder $formBuilder, string $id)
    {
        $funder = requestApi('get', 'funder/'. $id);

        if (empty($funder) || !empty($funder['errors'])) {
            return redirect('funder/list');
        }

        $form = $formBuilder->create(AddFunderForm::class, [
            'method' => 'POST',
            'url' => route('funder.edit', $funder['id'])
        ], $funder);

        return view('dashboard.funders.edit')->with([
            'form' => $form
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $funderUpdate = requestApi('post', 'funder/'. $id, parseArgs($request->except('_token'), [
            'reset_time' => '',
            'reset_time_zone' => ''
        ]));

        if (!empty($funderUpdate['validation_error'])) {
            return redirect()->back()->withErrors($funderUpdate['validation_error'])->withInput()->with('error', 'Failed to update item, please check the fields.');
        }

        if (!empty($funderUpdate['errors'])) {
            return redirect()->back()->with('error', $funderUpdate['errors']);
        }

        return redirect()->back()->with('success', $funderUpdate['message']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $removeFunder = requestApi('delete', 'funder/'. $id);

        if (!empty($removeFunder['errors'])) {
            return redirect()->back()->with('error', $removeFunder['errors']);
        }

        return redirect()->back()->with('success', $removeFunder['message']);
    }
}
