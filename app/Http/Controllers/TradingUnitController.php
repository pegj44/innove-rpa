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
        $units = requestApi( 'get','trading-units');

        return view('dashboard.trading-units.index')->with([
            'tradingUnits' => $units
        ]);
    }

    public function settings()
    {
        $settings = requestApi('get', 'trading-unit/settings');

        return view('dashboard.trading-units.settings.index')->with([
            'settings' => $settings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $enable = $request->get('enable');

        $createUnit = requestApi( 'post','trading-unit', [
            'name' => $request->get('unit_name'),
            'ip_address' => $request->get('ip_address'),
            'status' => ($enable)? 1 : 0
        ]);

        if (!empty($createUnit['errors'])) {
            return redirect()->back()->with('error', $createUnit['errors']);
        }

        return redirect()->back()->with('success', 'Successfully registered a unit.');
    }

    public function setUnitPassword(Request $request)
    {
        $unitsPw = requestApi('post', 'trading-units/settings/set-password', [
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'password_confirmation' => $request->get('password_confirm')
        ]);

        if (!empty($unitsPw['errors'])) {
            return redirect()->back()->with('error', $unitsPw['errors']);
        }

        return redirect()->back()->with('success', $unitsPw['message']);
    }

    public function updateUnitPassword(Request $request)
    {
        $unitsPw = requestApi('post', 'trading-units/settings/update-password', array_filter([
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'password_confirmation' => $request->get('password_confirm')
        ]));

        if (!empty($unitsPw['errors'])) {
            return redirect()->back()->with('error', $unitsPw['errors']);
        }

        return redirect()->back()->with('success', $unitsPw['message']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->only(['status', 'name', 'ip_address']);
        $data['status'] = (!empty($data['status']))? 1 : 0;

        requestApi('post', 'trading-unit/'. $id, $data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        requestApi('delete', 'trading-unit/'. $id);

        return redirect()->back();
    }
}
