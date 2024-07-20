<?php

namespace App\Http\Controllers;

use App\Forms\TradingAccountCredentialForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class TradingCredentialsController extends Controller
{

    public function getCredentials()
    {
        $items = requestApi('get', 'credentials');
        $credentials = [];

        if (!empty($items)){
            foreach ($items as $item) {

                $nameKeys = ['first_name', 'middle_name', 'last_name'];
                $nameArray = [];
                foreach ($item['trading_individual']['metadata'] as $individualMeta) {
                    if (in_array($individualMeta['key'], $nameKeys)) {
                        $nameArray[$individualMeta['key']] = $individualMeta['value'];
                    }
                }
                $completeName = trim(
                    (isset($nameArray['first_name']) ? $nameArray['first_name'] : '') . ' ' .
                    (isset($nameArray['middle_name']) ? $nameArray['middle_name'] : '') . ' ' .
                    (isset($nameArray['last_name']) ? $nameArray['last_name'] : '')
                );

                $funderName = '';

                foreach ($item['funder']['metadata'] as $funder) {
                    if ($funder['key'] === 'name') {
                        $funderName = $funder['value'];
                    }
                }

                $credentials[$item['id']]['id'] = $item['id'];
                $credentials[$item['id']]['name'] = $completeName;
                $credentials[$item['id']]['funder'] = $funderName;
                $credentials[$item['id']]['account_id'] = $item['account_id'];
                $credentials[$item['id']]['status'] = $item['status'];
                $credentials[$item['id']]['phase'] = $item['phase'];
                $credentials[$item['id']]['dashboard_login_url'] = $item['dashboard_login_url'];
                $credentials[$item['id']]['dashboard_login_username'] = $item['dashboard_login_username'];
                $credentials[$item['id']]['dashboard_login_password'] = $item['dashboard_login_password'];

                $credentials[$item['id']]['platform_login_url'] = $item['platform_login_url'];
                $credentials[$item['id']]['platform_login_username'] = $item['platform_login_username'];
                $credentials[$item['id']]['platform_login_password'] = $item['platform_login_password'];
            }
        }

        return view('dashboard.trading-credentials.index')->with([
            'items' => $credentials
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(TradingAccountCredentialForm::class, [
            'method' => 'POST',
            'url' => route('trading-account.credential.store')
        ]);

        return view('dashboard.trading-credentials.create')->with([
            'form' => $form
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = requestApi('post', 'credential', $request->except('_token'));

        if (!empty($response['errors'])) {
            return redirect()->back()->withErrors($response['errors'])->withInput();
        }

        return redirect()->route('trading-account.credential.list')->with('success', $response['message']);
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
        $item = requestApi('get', 'credential/'. $id);

        if (empty($item) || !empty($item['errors'])) {
            return redirect()->route('trading-account.credential.list');
        }

        $form = $formBuilder->create(TradingAccountCredentialForm::class, [
            'method' => 'POST',
            'url' => route('trading-account.credential.update', $item['id'])
        ], ['data' => $item]);

        return view('dashboard.trading-credentials.edit')->with([
            'form' => $form
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $itemUpdate = requestApi('post', 'credential/'. $id, array_filter($request->except('_token')));

        if (!empty($itemUpdate['errors'])) {
            return redirect()->back()->withErrors($itemUpdate['errors'])->withInput();
        }

        return redirect()->back()->with('success', $itemUpdate['message']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $removeFunder = requestApi('delete', 'credential/'. $id);

        if (!empty($removeFunder['errors'])) {
            return redirect()->back()->with('error', $removeFunder['errors']);
        }

        return redirect()->back()->with('success', $removeFunder['message']);
    }
}
