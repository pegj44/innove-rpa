<?php

namespace App\Http\Controllers;

use App\Forms\PayoutForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class PayoutController extends Controller
{
    public function index()
    {
        $items = requestApi('get', 'trade/payouts');

        return view('dashboard.trade.payouts.index')->with([
            'items' => $items
        ]);
    }

    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(PayoutForm::class, [
            'method' => 'POST',
            'url' => route('trade.payouts.store')
        ]);

        return view('dashboard.trade.payouts.create')->with([
            'form' => $form
        ]);
    }

    public function store(Request $request)
    {
        $item = requestApi('post', 'trade/payout', $request->except('_token'));

        if (!empty($item['validation_error'])) {
            return redirect()->back()->with('error', __('Please check the field errors below.'))->withErrors($item['validation_error'])->withInput();
        }

        if (!empty($item['errors'])) {
            return redirect()->back()->with('error', $item['errors']);
        }

        return redirect()->route('trade.payouts')->with('success', $item['message']);
    }

    public function edit(FormBuilder $formBuilder, string $id)
    {
        $item = requestApi('get', 'trade/payout/'. $id);

        if (empty($item) || !empty($item['errors'])) {
            return redirect()->route('trade.payouts');
        }

        $form = $formBuilder->create(PayoutForm::class, [
            'method' => 'put',
            'url' => route('trade.payout.update', $id)
        ], $item);

        return view('dashboard.trade.payouts.edit')->with([
            'form' => $form
        ]);
    }

    public function update(Request $request, string $id)
    {
        $item = requestApi('put', 'trade/payout/'. $id, $request->except('_token'));

        if (!empty($item['validation_error'])) {
            return redirect()->back()->withErrors($item['validation_error'])->withInput()->with('error', 'Failed to update item, please check the fields.');
        }

        if (!empty($item['errors'])) {
            return redirect()->back()->with('error', $item['errors']);
        }

        return redirect()->route('trade.payouts')->with('success', $item['message']);
    }

    public function destroy(string $id)
    {

    }
}
