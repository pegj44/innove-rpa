<?php

namespace App\Http\Controllers;

use App\Forms\AddIndividualForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class TradingIndividualController extends Controller
{
    public function getIndividuals()
    {
        $items = requestApi('get', 'trading-individuals');

        return view('dashboard.trading-individual.index')->with([
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(AddIndividualForm::class, [
            'method' => 'POST',
            'url' => route('trading-account.individual.store')
        ]);

        return view('dashboard.trading-individual.create')->with([
            'form' => $form
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = requestApi('post', 'trading-individual', $request->except('_token'));

        if (isset($response['validation_error'])) {
            return redirect()->back()->withErrors($response['validation_error'])->withInput()->with('error', 'Failed to add item, please check the fields.');
        }

        if (isset($response['errors'])) {
            return redirect()->back()->with('error', $response['errors']);
        }

        return redirect()->route('trading-account.individual.list')->with('success', 'Successfully saved item.');
    }

    public function uploadIndividuals(Request $request)
    {
        $response = requestApi('attach_single', 'trading-individuals', [
            'file' => $request->file('individuals_record')
        ]);

        if (!empty($response['errors'])) {
            return redirect()->route('trading-account.individual.list')->with('error', $response['errors']);
        }

        return redirect()->route('trading-account.individual.list')->with('success', $response['message']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormBuilder $formBuilder, string $id)
    {
        $item = requestApi('get', 'trading-individual/'. $id);

        if (empty($item) || !empty($item['errors'])) {
            return redirect()->route('trading-account.individual.list');
        }

        $form = $formBuilder->create(AddIndividualForm::class, [
            'method' => 'POST',
            'url' => route('trading-account.individual.update', $item['id'])
        ], $item);

        return view('dashboard.trading-individual.edit')->with([
            'form' => $form
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = requestApi('post', 'trading-individual/'. $id, $request->except('_token'));

        if (!empty($item['validation_error'])) {
            return redirect()->back()->withErrors($item['validation_error'])->withInput()->with('error', 'Failed to add item, please check the fields.');
        }

        if (!empty($item['errors'])) {
            return redirect()->back()->with('error', $item['errors']);
        }

        return redirect()->back()->with('success', $item['message']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $removeItem = requestApi('delete', 'trading-individual/'. $id);

        if (!empty($removeItem['errors'])) {
            return redirect()->back()->with('error', $removeItem['errors']);
        }

        return redirect()->back()->with('success', $removeItem['message']);
    }
}
