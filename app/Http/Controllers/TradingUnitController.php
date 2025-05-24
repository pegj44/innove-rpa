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
        $activityCount = requestApi('get', 'trade/activity-count');
        $fundersCount = requestApi('get', 'units/funders-count');

        return view('dashboard.trading-units.index')->with([
            'tradingUnits' => $units,
            'activityCount' => $activityCount,
            'statusIcons' => self::getUnitStatuses(),
            'fundersCount' => $fundersCount
        ]);
    }

    public static function getUnitStatuses()
    {
        return [
            1 => [
                'name' => 'Enabled',
                'html' => '<svg class="w-5 h-5 text-green-400 dark:text-green-400 inline-block" data-tooltip-handler="0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/> </svg>',
            ],
            2 => [
                'name' => 'Processing',
                'html' => '<svg class="w-5 h-5 text-white dark:text-white inline-block" data-tooltip-handler="0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"> <path fill-rule="evenodd" d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6Zm4.996 2a1 1 0 0 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 8a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 11a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 14a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Z" clip-rule="evenodd"/> </svg>',
            ],
            3 => [
                'name' => 'Slow Network',
                'html' => '<svg class="w-5 h-5 text-orange-400 dark:text-orange-400 inline-block" data-tooltip-handler="0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"> <path fill-rule="evenodd" d="M8.64 4.737A7.97 7.97 0 0 1 12 4a7.997 7.997 0 0 1 6.933 4.006h-.738c-.65 0-1.177.25-1.177.9 0 .33 0 2.04-2.026 2.008-1.972 0-1.972-1.732-1.972-2.008 0-1.429-.787-1.65-1.752-1.923-.374-.105-.774-.218-1.166-.411-1.004-.497-1.347-1.183-1.461-1.835ZM6 4a10.06 10.06 0 0 0-2.812 3.27A9.956 9.956 0 0 0 2 12c0 5.289 4.106 9.619 9.304 9.976l.054.004a10.12 10.12 0 0 0 1.155.007h.002a10.024 10.024 0 0 0 1.5-.19 9.925 9.925 0 0 0 2.259-.754 10.041 10.041 0 0 0 4.987-5.263A9.917 9.917 0 0 0 22 12a10.025 10.025 0 0 0-.315-2.5A10.001 10.001 0 0 0 12 2a9.964 9.964 0 0 0-6 2Zm13.372 11.113a2.575 2.575 0 0 0-.75-.112h-.217A3.405 3.405 0 0 0 15 18.405v1.014a8.027 8.027 0 0 0 4.372-4.307ZM12.114 20H12A8 8 0 0 1 5.1 7.95c.95.541 1.421 1.537 1.835 2.415.209.441.403.853.637 1.162.54.712 1.063 1.019 1.591 1.328.52.305 1.047.613 1.6 1.316 1.44 1.825 1.419 4.366 1.35 5.828Z" clip-rule="evenodd"/> </svg>',
            ],
            4 => [
                'name' => 'Not Connected',
                'html' => '<svg class="w-5 h-5 text-red-400 dark:text-red-400 inline-block" data-tooltip-handler="0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/> </svg>',
            ],
            5 => [
                'name' => 'PC Issue',
                'html' => '<svg class="w-5 h-5 text-red-400 dark:text-red-400 inline-block" data-tooltip-handler="0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 16H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v1M9 12H4m8 8V9h8v11h-8Zm0 0H9m8-4a1 1 0 1 0-2 0 1 1 0 0 0 2 0Z"/> </svg>'
            ],
            0 => [
                'name' => 'Disabled',
                'html' => '<svg class="w-6 h-6 text-gray-400 dark:text-gray-400 inline-block" data-tooltip-handler="0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"> <path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd"/> </svg>',
            ]
        ];
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
            'unit_id' => $request->get('unit_id'),
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
        $data = $request->only(['status', 'name', 'unit_id']);
        $data['status'] = (!empty($data['status']))? (int) $data['status'] : 0;

        requestApi('post', 'trading-unit/'. $id, $data);

//        return redirect()->back();
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
