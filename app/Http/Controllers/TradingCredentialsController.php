<?php

namespace App\Http\Controllers;

use App\Forms\TradingAccountCredentialForm;
use App\Forms\UserPlatformCredentialsForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class TradingCredentialsController extends Controller
{

    public function getFunderAccountCredentials()
    {
        $items = requestApi('get', 'credential/funder/accounts');

        return view('dashboard.trading-account-credentials.index')->with([
            'items' => $items
        ]);
    }

    public function storeFunderAccountCredential(Request $request)
    {
        $response = requestApi('post', 'credential/funder/account', $request->except('_token'));

        if (!empty($response['validation_error'])) {
            return redirect()->back()->withErrors($response['validation_error'])->withInput();
        }

        if (!empty($response['error'])) {
            return redirect()->back()->withErrors($response['error'])->withInput();
        }

        return redirect()->route('trading-account.credential.funders.accounts')->with('success', $response['message']);
    }

    public function createFunderAccountCredential(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(UserPlatformCredentialsForm::class, [
            'method' => 'POST',
            'url' => route('trading-account.credential.funders.accounts.create')
        ]);

        return view('dashboard.trading-account-credentials.create')->with([
            'form' => $form
        ]);
    }

    public function editFunderAccountCredential(FormBuilder $formBuilder, string $id)
    {
        $item = requestApi('get', 'credential/funder/account/'. $id);

        if (empty($item) || !empty($item['errors'])) {
            return redirect('credential.funders.accounts');
        }

        $form = $formBuilder->create(UserPlatformCredentialsForm::class, [
            'method' => 'patch',
            'url' => route('trading-account.credential.funders.accounts.update', $id)
        ], $item);

        return view('dashboard.trading-account-credentials.edit')->with([
            'form' => $form
        ]);
    }

    public function updateFunderAccountCredential(Request $request, string $id)
    {
        $response = requestApi('put', 'credential/funder/account/'. $id, $request->except('_token'));

        if (!empty($response['validation_error'])) {
            return redirect()->back()->withErrors($response['validation_error'])->withInput();
        }

        if (!empty($response['error'])) {
            return redirect()->back()->withErrors($response['error'])->withInput();
        }

        return redirect()->route('trading-account.credential.funders.accounts')->with('success', $response['message']);
    }

    public function deleteFunderAccountCredential(string $id)
    {
        $removeFunder = requestApi('delete', 'credential/funder/account/'. $id);

        if (!empty($removeFunder['errors'])) {
            return redirect()->back()->with('error', $removeFunder['errors']);
        }

        return redirect()->back()->with('success', $removeFunder['message']);
    }

    public function getCredentials()
    {
        $items = requestApi('get', 'credentials');

        return view('dashboard.trading-credentials.index')->with([
            'items' => $items
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
