@if(!empty($waitingPairedItems))

    <div id="accordion-traded-items" data-accordion="collapse">

        @foreach($waitingPairedItems as $index => $pairedItem)
            <h2 id="accordion-paired-collapse-heading-{{$index}}">
                <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-white border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 text-white hover:bg-gray-{{$index}}00 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-paired-collapse-body-{{$index}}" aria-expanded="false" aria-controls="accordion-paired-collapse-body-{{$index}}">
                    <span>
                        <span class="px-2 py-1 text-white rounded {{ (($pairedItem['pair1']['purchase_type'] === 'sell')? 'bg-red-500' : 'bg-green-700') }}">{{ $pairedItem['pair1']['trade_credential']['account_id'] }}</span>
                        <span class="px-2 py-1 text-white rounded {{ (($pairedItem['pair2']['purchase_type'] === 'sell')? 'bg-red-500' : 'bg-green-700') }}">{{ $pairedItem['pair2']['trade_credential']['account_id'] }}</span>
                    </span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-{{$index}}80 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>

            <div id="accordion-paired-collapse-body-{{$index}}" class="hidden" aria-labelledby="accordion-paired-collapse-heading-{{$index}}">
                <div class="p-5 border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    <div class="mb-5 flex bg-white border border-gray-200 shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="grid grid-cols-2 flex-1">
                            <div class="p-6 dark:bg-gray-900 p-6">
                                <div class="border-b dark:border-gray-600 flex justify-between">
                                    <h5 class="dark:text-white font-bold mb-2 text-gray-900 text-lg tracking-tight">
                                        {{ $pairedItem['pair1']['trade_credential']['trading_individual']['trading_unit']['name'] }} <span class="mb-3 font-normal text-gray-700 dark:text-gray-400">| {{ $pairedItem['pair1']['trade_credential']['account_id'] }}</span>
                                    </h5>
                                    <h5 class="dark:text-white font-bold mb-2 text-gray-900 text-lg tracking-tight">
                                        {{ $pairedItem['pair1']['trade_credential']['funder']['alias'] }}
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
                                                    {{ number_format($pairedItem['pair1']['starting_balance'], 2) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Starting Daily Equity') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($pairedItem['pair1']['starting_equity'], 2) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Latest Equity') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($pairedItem['pair1']['latest_equity'], 2) }}
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
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    @if($pairedItem['pair1']['order_type'] === 'quantity')
                                                        Quantity/Contract
                                                    @endif
                                                    @if($pairedItem['pair1']['order_type'] === 'lot')
                                                        Lot/Volume
                                                    @endif
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <input type="number" name="order_amount" step="0.01" value="{{ $pairedItem['pair1']['order_amount'] }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Take Profit (Ticks)') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <input type="number" name="take_profit_ticks" value="{{ $pairedItem['pair1']['take_profit_ticks'] }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Stop Loss (Ticks)') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <input type="number" name="stop_loss_ticks" value="{{ $pairedItem['pair1']['stop_loss_ticks'] }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Purchase Type') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <select name="purchase_type" id="purchase-type-{{ $pairedItem['pair1']['id'] }}" data-pair="purchase-type-{{ $pairedItem['pair2']['id'] }}" class="purchase-type bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                        <option value="buy" class="buy" {{ (isset($pairedItem['pair1']['purchase_type']) && $pairedItem['pair1']['purchase_type'] === 'buy')? 'selected' : '' }}>Buy</option>
                                                        <option value="sell" class="sell" {{ (isset($pairedItem['pair1']['purchase_type']) && $pairedItem['pair1']['purchase_type'] === 'sell')? 'selected' : '' }}>Sell</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="p-6">

                                <div class="border-b dark:border-gray-600 flex justify-between">
                                    <h5 class="dark:text-white font-bold mb-2 text-gray-900 text-lg tracking-tight">
                                        {{ $pairedItem['pair2']['trade_credential']['trading_individual']['trading_unit']['name'] }} <span class="mb-3 font-normal text-gray-700 dark:text-gray-400">| {{ $pairedItem['pair2']['trade_credential']['account_id'] }}</span>
                                    </h5>
                                    <h5 class="dark:text-white font-bold mb-2 text-gray-900 text-lg tracking-tight">
                                        {{ $pairedItem['pair2']['trade_credential']['funder']['alias'] }}
                                    </h5>
                                </div>

                                <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tbody>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Starting Balance') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($pairedItem['pair2']['starting_balance'], 2) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Starting Daily Equity') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($pairedItem['pair2']['starting_equity'], 2) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Latest Equity') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($pairedItem['pair2']['latest_equity'], 2) }}
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
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    @if($pairedItem['pair2']['order_type'] === 'quantity')
                                                        Quantity/Contract
                                                    @endif
                                                    @if($pairedItem['pair2']['order_type'] === 'lot')
                                                        Lot/Volume
                                                    @endif
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <input type="number" name="order_amount" step="0.01" value="{{ $pairedItem['pair2']['order_amount'] }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Take Profit (Ticks)') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <input type="number" name="take_profit_ticks" value="{{ $pairedItem['pair2']['take_profit_ticks'] }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Stop Loss (Ticks)') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <input type="number" name="stop_loss_ticks" value="{{ $pairedItem['pair2']['stop_loss_ticks'] }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Purchase Type') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <select name="purchase_type" id="purchase-type-{{ $pairedItem['pair2']['id'] }}" data-pair="purchase-type-{{ $pairedItem['pair1']['id'] }}" class="purchase-type bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                        <option value="buy" class="buy" {{ (isset($pairedItem['pair2']['purchase_type']) && $pairedItem['pair2']['purchase_type'] === 'buy')? 'selected' : '' }}>Buy</option>
                                                        <option value="sell" class="sell" {{ (isset($pairedItem['pair2']['purchase_type']) && $pairedItem['pair2']['purchase_type'] === 'sell')? 'selected' : '' }}>Sell</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="h-12 text-center">
                        <form method="POST" action="{{ route('trade.initiate') }}">
                            @csrf
                            <input type="hidden" name="paired_id" value="{{ $index }}">
                            <input type="hidden" name="unit1[ip]" value="{{ $pairedItem['pair1']['trade_credential']['trading_individual']['trading_unit']['ip_address'] }}">
                            <input type="hidden" name="unit1[machine]" value="{{ $pairedItem['pair1']['trade_credential']['funder']['automation'] }}">
                            <input type="hidden" name="unit1[latest_equity]" value="{{ $pairedItem['pair1']['latest_equity'] }}">
                            <input type="hidden" name="unit1[purchase_type]" value="{{ $pairedItem['pair1']['purchase_type'] }}">
                            <input type="hidden" name="unit1[order_amount]" value="{{ $pairedItem['pair1']['order_amount'] }}">
                            <input type="hidden" name="unit1[take_profit_ticks]" value="{{ $pairedItem['pair1']['take_profit_ticks'] }}">
                            <input type="hidden" name="unit1[stop_loss_ticks]" value="{{ $pairedItem['pair1']['stop_loss_ticks'] }}">
                            <input type="hidden" name="unit1[account_id]" value="{{ $pairedItem['pair1']['trade_credential']['account_id'] }}">
                            <input type="hidden" name="unit1[asset_type]" value="{{ $pairedItem['pair1']['trade_credential']['funder']['asset_type'] }}">

                            <input type="hidden" name="unit2[ip]" value="{{ $pairedItem['pair2']['trade_credential']['trading_individual']['trading_unit']['ip_address'] }}">
                            <input type="hidden" name="unit2[machine]" value="{{ $pairedItem['pair2']['trade_credential']['funder']['automation'] }}">
                            <input type="hidden" name="unit2[latest_equity]" value="{{ $pairedItem['pair2']['latest_equity'] }}">
                            <input type="hidden" name="unit2[purchase_type]" value="{{ $pairedItem['pair2']['purchase_type'] }}">
                            <input type="hidden" name="unit2[order_amount]" value="{{ $pairedItem['pair2']['order_amount'] }}">
                            <input type="hidden" name="unit2[take_profit_ticks]" value="{{ $pairedItem['pair2']['take_profit_ticks'] }}">
                            <input type="hidden" name="unit2[stop_loss_ticks]" value="{{ $pairedItem['pair2']['stop_loss_ticks'] }}">
                            <input type="hidden" name="unit2[account_id]" value="{{ $pairedItem['pair2']['trade_credential']['account_id'] }}">
                            <input type="hidden" name="unit2[asset_type]" value="{{ $pairedItem['pair2']['trade_credential']['funder']['asset_type'] }}">

                            <button type="submit" class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="w-[24px] h-[24px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 18V6l8 6-8 6Z"/>
                                </svg>
                                {{ __('Initiate Trade') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function() {

            const selects = document.querySelectorAll('select.purchase-type');

            selects.forEach(function(select) {
                select.addEventListener('change', function() {
                    const pairId = this.getAttribute('data-pair');
                    const pair = document.getElementById(pairId);

                    pair.value = (this.value === 'sell')? 'buy' : 'sell';
                });
            });
        });

    </script>
@else
<p>No paired items.</p>
@endif
