<?php

namespace App\Http\Controllers;

use App\Forms\AddFunderForm;
use App\Forms\FunderConfigForm;
use App\Forms\FunderPackages;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

class FunderController extends Controller
{
    public static $platforms = [
        'MT5_Web' => 'MT5-Web',
        'Rtrader_base' => 'Rithmic Trader',
        'CTrader_2' => 'CTrader',
        'Tradoverse_3' => 'Tradoverse',
        'ProjectX_1' => 'ProjectX',
        'TradeLocker_1' => 'TradeLocker (Demo)',
        'TradeLocker_Live_1' => 'TradeLocker (Live)',
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

    public function storeFundersPackages(Request $request)
    {
        $response = requestApi('post', 'funders/packages', $request->except('_token'));

        if (!empty($response['errors'])) {
            return redirect()->back()->with('error', $response['errors']);
        }

        return redirect()->route('funders.packages')->with('success', $response['message']);
    }

    public function editFunderPackage(FormBuilder $formBuilder, string $id)
    {
        $package = requestApi('get', 'funders/package/'. $id);

        $form = $formBuilder->create(FunderPackages::class, [
            'method' => 'POST',
            'url' => route('funders.packages.update', $id)
        ], $package);

        return view('dashboard.funders.packages.edit')->with([
            'form' => $form
        ]);
    }

    public function updateFunderPackage(Request $request, string $id)
    {
        $response = requestApi('post', 'funders/package/'. $id, $request->except('_token'));

        if (!empty($response['errors'])) {
            return redirect()->back()->with('error', $response['errors']);
        }

        return redirect()->back()->with('success', $response['message']);
    }

    public function deleteFunderPackage(string $id)
    {
        $response = requestApi('delete', 'funders/package/'. $id);

        if (!empty($response['errors'])) {
            return redirect()->back()->with('error', $response['errors']);
        }

        return redirect()->back()->with('success', $response['message']);
    }

    public function createFunderPackage(FormBuilder $formBuilder)
    {
        $packages = [];

        $form = $formBuilder->create(FunderPackages::class, [
            'method' => 'POST',
            'url' => route('funders.packages.store')
        ], $packages);

        return view('dashboard.funders.packages.create')->with([
            'form' => $form
        ]);
    }

    public function fundersPackages()
    {
        $packages = requestApi('get', 'funders/packages');

        return view('dashboard.funders.packages.index')->with([
            'packages' => $packages
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
