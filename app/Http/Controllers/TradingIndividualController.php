<?php

namespace App\Http\Controllers;

use App\Forms\AddIndividualForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class TradingIndividualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(AddIndividualForm::class, [
            'method' => 'POST',
            'url' => route('trading-individual.store')
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
        $response = requestApi('post', 'trading-individual', array_filter($request->except('_token')));

        if (!empty($response['errors'])) {
            return redirect()->back()->withErrors($response['errors'])->withInput();
        }

        return redirect()->back()->with('success', 'Successfully saved item.');
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
