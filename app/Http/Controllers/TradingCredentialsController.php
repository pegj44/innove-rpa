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
