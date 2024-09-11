
<div class="flex items-center">
    <form method="POST" id="pair-accounts" action="{{ route('trade.pair') }}" class="mr-5">
        @csrf
        <button type="submit" class="px-5 py-3 text-base font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-[28px] h-[28px] mr-1 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 10 3-3m0 0-3-3m3 3H5v3m3 4-3 3m0 0 3 3m-3-3h14v-3"/>
            </svg>
            Pair Accounts
        </button>
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
                                <input type="hidden" name="unit1[machine]" value="{{ $pair1['trade_credential']['funder']['alias'] .'_'. $pair1['trade_credential']['account_id'] }}">
                                <input type="hidden" name="unit1[latest_equity]" value="{{ $pair1['latest_equity'] }}">
                                <input type="hidden" name="unit1[purchase_type]" value="sell">

                                <input type="hidden" name="unit2[ip]" value="{{ $pair2['trade_credential']['trading_individual']['trading_unit']['ip_address'] }}">
                                <input type="hidden" name="unit2[machine]" value="{{ $pair2['trade_credential']['funder']['alias'] .'_'. $pair2['trade_credential']['account_id'] }}">
                                <input type="hidden" name="unit2[latest_equity]" value="{{ $pair2['latest_equity'] }}">
                                <input type="hidden" name="unit2[purchase_type]" value="buy">

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

{{--                        <div class="mt-5 w-20">--}}
{{--                            <form method="post" action="{{ route('trade.set-purchase-type') }}" class="set-purchase-type">--}}
{{--                                @csrf--}}
{{--                                <input type="hidden" name="funder_id" value="{{ $pair1['trade_credential']['funder']['id'] }}">--}}
{{--                                <select name="purchase_type" class="purchase-type bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}
{{--                                    <option value="buy" class="buy" {{ (isset($pair1FunderMetadata['purchase_type']) && $pair1FunderMetadata['purchase_type'] === 'buy')? 'selected' : '' }} style="background: green">Buy</option>--}}
{{--                                    <option value="sell" class="sell" {{ (isset($pair1FunderMetadata['purchase_type']) && $pair1FunderMetadata['purchase_type'] === 'sell')? 'selected' : '' }} style="background: #fb4c4c">Sell</option>--}}
{{--                                </select>--}}
{{--                            </form>--}}
{{--                        </div>--}}
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

{{--                        <div class="mt-5 w-20">--}}
{{--                            <form method="post" action="{{ route('trade.set-purchase-type') }}" class="set-purchase-type">--}}
{{--                                @csrf--}}
{{--                                <input type="hidden" name="funder_id" value="{{ $pair2['trade_credential']['funder']['id'] }}">--}}
{{--                                <select name="purchase_type" class="purchase-type bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}
{{--                                    <option class="buy" {{ (isset($pair2FunderMetadata['purchase_type']) && $pair2FunderMetadata['purchase_type'] === 'buy')? 'selected' : '' }} style="background: green" value="buy">Buy</option>--}}
{{--                                    <option class="sell" {{ (isset($pair2FunderMetadata['purchase_type']) && $pair2FunderMetadata['purchase_type'] === 'sell')? 'selected' : '' }} style="background: #fb4c4c" value="sell">Sell</option>--}}
{{--                                </select>--}}
{{--                            </form>--}}
{{--                        </div>--}}
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
                console.log(data);
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

        if(event.detail.action === 'pair_accounts-success') {
            location.reload();
        }
    });


    document.addEventListener('DOMContentLoaded', function() {
        // Select all .set-purchase-type forms
        const forms = document.querySelectorAll('.set-purchase-type');

        forms.forEach(form => {
            // Select the purchase-type select element within each form
            const select = form.querySelector('.purchase-type');

            // Add change event listener to the select element
            select.addEventListener('change', function() {
                // Create a new FormData object from the form
                const formData = new FormData(form);

                // Create a new XMLHttpRequest object
                const xhr = new XMLHttpRequest();
                xhr.open('POST', form.action, true);

                // Set up the callback function to handle the response
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        // Success: handle the response if needed
                        console.log('Form submitted successfully:', xhr.responseText);
                    } else {
                        // Error: handle the error if needed
                        console.error('Form submission failed:', xhr.statusText);
                    }
                };

                // Handle request errors
                xhr.onerror = function() {
                    console.error('Request error.');
                };

                // Send the form data via AJAX
                xhr.send(formData);
            });
        });
    });

</script>
