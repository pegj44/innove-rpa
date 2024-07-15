<?php

namespace App\Http\Controllers;

use App\Forms\AddFunderForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class FunderController extends Controller
{
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
        $funder = requestApi('post', 'funder', array_filter($request->except('_token')));

        if (!empty($funder['errors'])) {
            return redirect()->back()->withErrors($funder['errors'])->withInput();
        }

        return redirect()->back()->with('success', 'Successfully saved Funder.');
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

        if (!empty($funder['errors'])) {
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
        $funderUpdate = requestApi('post', 'funder/'. $id, array_filter($request->except('_token')));

        if (!empty($funderUpdate['errors'])) {
            return redirect()->back()->withErrors($funderUpdate['errors'])->withInput();
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
