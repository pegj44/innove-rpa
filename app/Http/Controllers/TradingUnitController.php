<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TradingUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = getRequest('trading-units');

        return view('dashboard.trading-units.index')->with([
            'tradingUnits' => $units
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $enable = $request->get('enable');

        $createUnit = postRequest('trading-unit', [
            'name' => $request->get('unit_name'),
            'ip_address' => $request->get('ip_address'),
            'status' => ($enable)? 1 : 0
        ]);

        if (!empty($createUnit['errors'])) {
            return redirect()->back()->withErrors($createUnit['errors']);
        }

        return redirect()->back()->with('success', 'Successfully registered a unit.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
