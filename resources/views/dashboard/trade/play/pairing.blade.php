
<div class="flex items-center">
    <form method="POST" id="pair-accounts" action="{{ route('trade.pair') }}" class="mr-5">
        @csrf
        <button type="submit" class="px-5 py-3 text-base font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-[28px] h-[28px] mr-1 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 10 3-3m0 0-3-3m3 3H5v3m3 4-3 3m0 0 3 3m-3-3h14v-3"/>
            </svg>
            Pair Accounts
        </button>
        <div class="mt-2 text-sm text-red-600 pairing-error"></div>
    </form>
    @if(!empty($pairedItems))
        <form method="POST" action="{{ route('trade.pair.clear') }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-blue-500">Clear Pairing</button>
        </form>
    @endif
</div>

@if(!empty($pairedItems))
    <div class="mt-10">
        <h3 class="mb-5">{{ __('Paired Accounts') }}</h3>
        @foreach($pairedItems as $item)
            @php
                if (empty($item['trade_report_pair1']) || empty($item['trade_report_pair2'])) {
                    continue;
                }

                $pair1 = $item['trade_report_pair1'];
                $pair2 = $item['trade_report_pair2'];

                $reportInfo = [
                    'pair1' => getTradeReportCalculations($pair1),
                    'pair2' => getTradeReportCalculations($pair2)
                ];

                $pair1FunderMetadata = [];
                foreach($pair1['trade_credential']['funder']['metadata'] as $funderMeta1) {
                    $pair1FunderMetadata[$funderMeta1['key']] = $funderMeta1['value'];
                }

                $pair2FunderMetadata = [];
                foreach($pair2['trade_credential']['funder']['metadata'] as $funderMeta2) {
                    $pair2FunderMetadata[$funderMeta2['key']] = $funderMeta2['value'];
                }

            @endphp
            <div class="mb-10 flex bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-1 flex-col max-w-[300px] p-6">
                    @if($item['status'] === 'paired')
                        <div class="flex flex-1 justify-center items-center">
                            <h4 class="text-green-500">{{ __('Ready to Trade') }}</h4>
                        </div>
                        <div class="h-12 text-center">
                            <form method="POST" action="{{ route('trade.initiate') }}">
                                @csrf
                                <input type="hidden" name="unit1[ip]" value="{{ $pair1['trade_credential']['trading_individual']['trading_unit']['ip_address'] }}">
                                <input type="hidden" name="unit1[machine]" value="{{ $pair1['trade_credential']['funder']['automation'] }}">
                                <input type="hidden" name="unit1[latest_equity]" value="{{ $pair1['latest_equity'] }}">
                                <input type="hidden" name="unit1[purchase_type]" value="{{ $pair1['purchase_type'] }}">
                                <input type="hidden" name="unit1[order_amount]" value="{{ $pair1['order_amount'] }}">
                                <input type="hidden" name="unit1[take_profit_ticks]" value="{{ $pair1['take_profit_ticks'] }}">
                                <input type="hidden" name="unit1[stop_loss_ticks]" value="{{ $pair1['stop_loss_ticks'] }}">
                                <input type="hidden" name="unit1[account_id]" value="{{ $pair1['trade_credential']['account_id'] }}">
                                <input type="hidden" name="unit1[asset_type]" value="{{ $pair1['trade_credential']['funder']['asset_type'] }}">

                                <input type="hidden" name="unit2[ip]" value="{{ $pair2['trade_credential']['trading_individual']['trading_unit']['ip_address'] }}">
                                <input type="hidden" name="unit2[machine]" value="{{ $pair2['trade_credential']['funder']['automation'] }}">
                                <input type="hidden" name="unit2[latest_equity]" value="{{ $pair2['latest_equity'] }}">
                                <input type="hidden" name="unit2[purchase_type]" value="{{ $pair2['purchase_type'] }}">
                                <input type="hidden" name="unit2[order_amount]" value="{{ $pair2['order_amount'] }}">
                                <input type="hidden" name="unit2[take_profit_ticks]" value="{{ $pair2['take_profit_ticks'] }}">
                                <input type="hidden" name="unit2[stop_loss_ticks]" value="{{ $pair2['stop_loss_ticks'] }}">
                                <input type="hidden" name="unit2[account_id]" value="{{ $pair2['trade_credential']['account_id'] }}">
                                <input type="hidden" name="unit2[asset_type]" value="{{ $pair2['trade_credential']['funder']['asset_type'] }}">

                                <button type="submit" class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="w-[24px] h-[24px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 18V6l8 6-8 6Z"/>
                                    </svg>
                                    {{ __('Initiate Trade') }}
                                </button>
                            </form>
                        </div>
                    @else

                    @endif
                </div>
                <div class="grid grid-cols-2 flex-1">
                    <div class="p-6 dark:bg-gray-900 p-6">
                        <div class="border-b dark:border-gray-600 flex justify-between">
                            <h5 class="dark:text-white font-bold mb-2 text-gray-900 text-lg tracking-tight">
                                {{ $pair1['trade_credential']['trading_individual']['trading_unit']['name'] }} <span class="mb-3 font-normal text-gray-700 dark:text-gray-400">| {{ $pair1['trade_credential']['account_id'] }}</span>
                            </h5>
                            <h5 class="dark:text-white font-bold mb-2 text-gray-900 text-lg tracking-tight">
                                {{ $pair1['trade_credential']['funder']['alias'] }}
                            </h5>
                        </div>
                        <div class="relative overflow-x-auto shadow-md">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <tbody>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                            {{ __('Starting Balance') }}
                                        </th>
                                        <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                            {{ number_format($pair1['starting_balance'], 2) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                            {{ __('Starting Daily Equity') }}
                                        </th>
                                        <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                            {{ number_format($pair1['starting_equity'], 2) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                            {{ __('Latest Equity') }}
                                        </th>
                                        <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                            {{ number_format($pair1['latest_equity'], 2) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                            {{ __('Daily P&L') }}
                                        </th>
                                        <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                            {{ number_format($reportInfo['pair1']['daily_pl'], 2) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                            {{ __('Daily P&L %') }}
                                        </th>
                                        <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                            {{ number_format($reportInfo['pair1']['daily_pl_percent'], 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-5">
                            <form method="post" action="{{ route('trade.update-trade-report-settings') }}" class="update-trade-report-settings">
                                @csrf
                                <input type="hidden" name="trade_report_id" value="{{ $pair1['id'] }}">
                                <input type="hidden" name="trade_report_pair_id" value="{{ $pair2['id'] }}">
                                <table>
                                    <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                        <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-2 text-gray-900 whitespace-nowrap">
                                            @if($pair1['order_type'] === 'quantity')
                                                Quantity/Contract
                                            @endif
                                            @if($pair1['order_type'] === 'lot')
                                                Lot/Volume
                                            @endif
                                        </th>
                                        <td class="px-6 py-2 w-1/2 dark:bg-gray-900 text-left">
                                            <input type="number" name="order_amount" step="0.01" value="{{ $pair1['order_amount'] }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                        <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-2 text-gray-900 whitespace-nowrap">
                                            Take Profit (Ticks)
                                        </th>
                                        <td class="px-6 py-2 w-1/2 dark:bg-gray-900 text-left">
                                            <input type="number" name="take_profit_ticks" value="{{ $pair1['take_profit_ticks'] }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                        <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-2 text-gray-900 whitespace-nowrap">
                                            Stop Loss (Ticks)
                                        </th>
                                        <td class="px-6 py-2 w-1/2 dark:bg-gray-900 text-left">
                                            <input type="number" name="stop_loss_ticks" value="{{ $pair1['stop_loss_ticks'] }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                        <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-2 text-gray-900 whitespace-nowrap">
                                            Purchase Type
                                        </th>
                                        <td class="px-6 py-2 w-1/2 dark:bg-gray-900">
                                            <select name="purchase_type" class="purchase-type bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="buy" class="buy" {{ (isset($pair1['purchase_type']) && $pair1['purchase_type'] === 'buy')? 'selected' : '' }} style="background: green">Buy</option>
                                                <option value="sell" class="sell" {{ (isset($pair1['purchase_type']) && $pair1['purchase_type'] === 'sell')? 'selected' : '' }} style="background: #fb4c4c">Sell</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <div class="mt-2 text-center">
                                    <button type="submit" class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="p-6">

                        <div class="border-b dark:border-gray-600 flex justify-between">
                            <h5 class="dark:text-white font-bold mb-2 text-gray-900 text-lg tracking-tight">
                                {{ $pair2['trade_credential']['trading_individual']['trading_unit']['name'] }} <span class="mb-3 font-normal text-gray-700 dark:text-gray-400">| {{ $pair2['trade_credential']['account_id'] }}</span>
                            </h5>
                            <h5 class="dark:text-white font-bold mb-2 text-gray-900 text-lg tracking-tight">
                                {{ $pair2['trade_credential']['funder']['alias'] }}
                            </h5>
                        </div>

                        <div class="relative overflow-x-auto shadow-md">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <tbody>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                        {{ __('Starting Balance') }}
                                    </th>
                                    <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                        {{ number_format($pair2['starting_balance'], 2) }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                        {{ __('Starting Daily Equity') }}
                                    </th>
                                    <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                        {{ number_format($pair2['starting_equity'], 2) }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                        {{ __('Latest Equity') }}
                                    </th>
                                    <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                        {{ number_format($pair2['latest_equity'], 2) }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                        {{ __('Daily P&L') }}
                                    </th>
                                    <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                        {{ number_format($reportInfo['pair2']['daily_pl'], 2) }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                        {{ __('Daily P&L %') }}
                                    </th>
                                    <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                        {{ number_format($reportInfo['pair2']['daily_pl_percent'], 2) }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-5">
                            <form method="post" action="{{ route('trade.update-trade-report-settings') }}" class="update-trade-report-settings">
                                @csrf
                                <input type="hidden" name="trade_report_id" value="{{ $pair2['id'] }}">
                                <input type="hidden" name="trade_report_pair_id" value="{{ $pair1['id'] }}">
                                <table>
                                    <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                        <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-2 text-gray-900 whitespace-nowrap">
                                            @if($pair2['order_type'] === 'quantity')
                                                Quantity/Contract
                                            @endif
                                            @if($pair2['order_type'] === 'lot')
                                                Lot/Volume
                                            @endif
                                        </th>
                                        <td class="px-6 py-2 w-1/2 dark:bg-gray-900 text-left">
                                            <input type="number" name="order_amount" step="0.01" value="{{ $pair2['order_amount'] }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                        <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-2 text-gray-900 whitespace-nowrap">
                                            Take Profit (Ticks)
                                        </th>
                                        <td class="px-6 py-2 w-1/2 dark:bg-gray-900 text-left">
                                            <input type="number" name="take_profit_ticks" value="{{ $pair2['take_profit_ticks'] }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                        <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-2 text-gray-900 whitespace-nowrap">
                                            Stop Loss (Ticks)
                                        </th>
                                        <td class="px-6 py-2 w-1/2 dark:bg-gray-900 text-left">
                                            <input type="number" name="stop_loss_ticks" value="{{ $pair2['stop_loss_ticks'] }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                        <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-2 text-gray-900 whitespace-nowrap">
                                            Purchase Type
                                        </th>
                                        <td class="px-6 py-2 w-1/2 dark:bg-gray-900">
                                            <select name="purchase_type" class="purchase-type bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="buy" class="buy" {{ (isset($pair2['purchase_type']) && $pair2['purchase_type'] === 'buy')? 'selected' : '' }} style="background: green">Buy</option>
                                                <option value="sell" class="sell" {{ (isset($pair2['purchase_type']) && $pair2['purchase_type'] === 'sell')? 'selected' : '' }} style="background: #fb4c4c">Sell</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <div class="mt-2 text-center">
                                    <button type="submit" class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<script>

    const form = document.getElementById('pair-accounts');
    const submitButton = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Disable the submit button and add the class
        submitButton.disabled = true;
        submitButton.classList.add('dark:bg-gray-700', 'bg-gray-700');

        const formData = new FormData(form);

        fetch('{{ route('trade.pair') }}', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Request failed with status code ' + response.status);
                }
            })
            .then(data => {
                console.log('data::', data);
                if (!data.success) {
                    form.querySelector('.pairing-error').textContent = data.error;
                }
                // Enable the submit button again and remove the class
            })
            .catch(error => {
                console.error(error);
                // Enable the submit button again and remove the class
                submitButton.disabled = false;
                submitButton.classList.remove('dark:bg-gray-700', 'bg-gray-700');
            });
    });


    document.addEventListener('pusherNotificationEvent', function(event) {
        console.log('event triggered: ', event.detail);

        if(event.detail.action === 'no-pairable-accounts') {
            form.querySelector('.pairing-error').textContent = 'No pairs found.';
            submitButton.disabled = false;
            submitButton.classList.remove('dark:bg-gray-700', 'bg-gray-700');
        }

        if(event.detail.action === 'pair_accounts-success') {
            location.reload();
        }
    });

    //
    // document.addEventListener('DOMContentLoaded', function() {
    //     // Select all .update-trade-report-settings forms
    //     const forms = document.querySelectorAll('.update-trade-report-settings');
    //
    //     forms.forEach(form => {
    //         // Select the purchase-type select element within each form
    //         const select = form.querySelector('.purchase-type');
    //
    //         // Add change event listener to the select element
    //         select.addEventListener('change', function() {
    //             form.submit();
    //         });
    //     });
    // });

</script>
