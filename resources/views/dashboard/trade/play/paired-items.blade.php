@if(!empty($waitingPairedItems))

    <div id="accordion-pairing-items" data-accordion="collapse">
        @foreach($waitingPairedItems as $index => $pairedItem)
            <h2 id="accordion-paired-collapse-heading-{{$index}}" class="flex">
                <button type="button" class="flex items-center justify-between w-full p-0 font-medium rtl:text-right text-white border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 text-white hover:bg-gray-{{$index}}00 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-paired-collapse-body-{{$index}}" aria-expanded="false" aria-controls="accordion-paired-collapse-body-{{$index}}">
                    <div class="flex items-center w-full" style="padding-left: 17px;">
                        <svg data-accordion-icon class="mr-5 w-3 h-3 rotate-{{$index}}80 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                        <div class="border-gray-700 border-l flex items-center justify-between w-full">
                            <div class="w-1/2 p-5 bg-gray-900">
                                <div class="dark:border-gray-600 flex justify-between">
                                    <h5 class="dark:text-white font-bold text-gray-900 text-lg tracking-tight">
                                        {{ $pairedItem['pair1']['trading_account_credential']['funder']['alias'] }} <span class="mb-3 font-normal text-gray-700 dark:text-gray-400">| {{ $pairedItem['pair1']['trading_account_credential']['funder_account_id'] }}</span>
                                    </h5>
                                    <h5 class="dark:text-white font-bold text-gray-900 text-lg tracking-tight">
                                        {{ $pairedItem['pair1']['trading_account_credential']['user_account']['trading_unit']['name'] }}
                                    </h5>
                                </div>
                            </div>
                            <div class="w-1/2 p-5 bg-gray-800">
                                <div class="dark:border-gray-600 flex justify-between">
                                    <h5 class="dark:text-white font-bold text-gray-900 text-lg tracking-tight">
                                        {{ $pairedItem['pair2']['trading_account_credential']['funder']['alias'] }} <span class="mb-3 font-normal text-gray-700 dark:text-gray-400">| {{ $pairedItem['pair2']['trading_account_credential']['funder_account_id'] }}</span>
                                    </h5>
                                    <h5 class="dark:text-white font-bold text-gray-900 text-lg tracking-tight">
                                        {{ $pairedItem['pair2']['trading_account_credential']['user_account']['trading_unit']['name'] }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </button>
                <div class="border border-gray-700 border-l-0 flex items-center p-3 remove-pair">
                    <form method="post" action="{{ route('trade.remove-pair', $index) }}" style="height: 24px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="">
                            <input type="hidden" name="pair1" value="{{ $pairedItem['pair1']['id'] }}">
                            <input type="hidden" name="pair2" value="{{ $pairedItem['pair2']['id'] }}">
                            <input type="hidden" name="updateStatus" value="1">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </h2>

            @php
                $symbols = getTradingSymbols();
            @endphp

            <div id="accordion-paired-collapse-body-{{$index}}" class="hidden" aria-labelledby="accordion-paired-collapse-heading-{{$index}}">
                <div class="border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    <div class="mb-5 flex bg-white border border-b-0 border-gray-200 shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="grid grid-cols-2 flex-1">
                            <div class="p-6 dark:bg-gray-900 p-6" style="padding-bottom: 0 !important;">
                                <div class="relative overflow-x-auto shadow-md">
                                    <table data-item="{{ $pairedItem['pair1']['id'] }}" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tbody>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Starting Balance') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($pairedItem['pair1']['trading_account_credential']['starting_balance'], 2) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Starting Daily Equity') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($pairedItem['pair1']['starting_daily_equity'], 2) }}
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
                                                    {!! getPnLHtml($pairedItem['pair1']) !!}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('RDD') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($reportInfo['pair1']['daily_pl_percent'], 2) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    Symbol
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <select id="symbol-{{ $pairedItem['pair1']['id'] }}" name="symbol" class="purchase-type bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                        @foreach($symbols as $symbol)
                                                            <option value="{{ $symbol }}" {{ ($symbol === $pairedItem['pair1']['trading_account_credential']['symbol'])? 'selected' : '' }}>{{ $symbol }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    Order Amount
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <input type="number" id="order_amount-{{ $pairedItem['pair1']['id'] }}" name="order_amount" step="0.01" value="{{ getCalculatedOrderAmount($pairedItem['pair1'], $pairedItem['pair1']['trading_account_credential']['asset_type']) }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Take Profit (Ticks)') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <input type="number" id="take_profit_ticks-{{ $pairedItem['pair1']['id'] }}" name="take_profit_ticks" value="{{ getTakeProfitTicks($pairedItem['pair1']) }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Stop Loss (Ticks)') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <input type="number" id="stop_loss_ticks-{{ $pairedItem['pair1']['id'] }}" name="stop_loss_ticks" value="{{ getStopLossTicks($pairedItem['pair1']) }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Purchase Type') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <select name="purchase_type" id="purchase-type-{{ $pairedItem['pair1']['id'] }}" data-pair="purchase-type-{{ $pairedItem['pair2']['id'] }}" class="purchase-type bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                        <option value="buy" class="buy" selected>Buy</option>
                                                        <option value="sell" class="sell">Sell</option>
                                                        <option value="buy-cross-phase" class="buy-cross-phase">Buy (Cross-phase)</option>
                                                        <option value="sell-cross-phase" class="sell-cross-phase">Sell (Cross-phase)</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="p-6" style="padding-bottom: 0 !important;">
                                <div class="relative overflow-x-auto">
                                    <table data-item="{{ $pairedItem['pair2']['id'] }}" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tbody>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Starting Balance') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($pairedItem['pair2']['trading_account_credential']['starting_balance'], 2) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Starting Daily Equity') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($pairedItem['pair2']['starting_daily_equity'], 2) }}
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
                                                    {!! getPnLHtml($pairedItem['pair2']) !!}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('RDD') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($reportInfo['pair2']['daily_pl_percent'], 2) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    Symbol
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <select id="symbol-{{ $pairedItem['pair2']['id'] }}" name="symbol" class="purchase-type bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                        @foreach($symbols as $symbol)
                                                            <option value="{{ $symbol }}" {{ ($symbol === $pairedItem['pair2']['trading_account_credential']['symbol'])? 'selected' : '' }}>{{ $symbol }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    Order Amount
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <input type="number" id="order_amount-{{ $pairedItem['pair2']['id'] }}" name="order_amount" step="0.01" value="{{ getCalculatedOrderAmount($pairedItem['pair2'], $pairedItem['pair2']['trading_account_credential']['asset_type']) }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Take Profit (Ticks)') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <input type="number" id="take_profit_ticks-{{ $pairedItem['pair2']['id'] }}" name="take_profit_ticks" value="{{ getTakeProfitTicks($pairedItem['pair2']) }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Stop Loss (Ticks)') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <input type="number" id="stop_loss_ticks-{{ $pairedItem['pair2']['id'] }}" name="stop_loss_ticks" value="{{ getStopLossTicks($pairedItem['pair2']) }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full">
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Purchase Type') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    <select name="purchase_type" id="purchase-type-{{ $pairedItem['pair2']['id'] }}" data-pair="purchase-type-{{ $pairedItem['pair1']['id'] }}" class="purchase-type bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                        <option value="buy" class="buy">Buy</option>
                                                        <option value="sell" class="sell" selected>Sell</option>
                                                        <option value="buy-cross-phase" class="buy-cross-phase">Buy (Cross-phase)</option>
                                                        <option value="sell-cross-phase" class="sell-cross-phase">Sell (Cross-phase)</option>
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
                        <form method="POST" action="{{ route('trade.initiate') }}" class="form-trade">
                            @csrf
                            <input type="hidden" name="paired_id" value="{{ $index }}">

                            <input type="hidden" name="unit1[id]" value="{{ $pairedItem['pair1']['id'] }}">
                            <input type="hidden" name="unit1[unit]" value="{{ $pairedItem['pair1']['trading_account_credential']['user_account']['trading_unit']['unit_id'] }}">
                            <input type="hidden" name="unit1[machine]" value="{{ $pairedItem['pair1']['trading_account_credential']['platform_type'] }}">
                            <input type="hidden" name="unit1[latest_equity]" value="{{ $pairedItem['pair1']['latest_equity'] }}">
                            <input type="hidden" name="unit1[purchase_type]" class="adaptval" data-key="purchase-type-{{ $pairedItem['pair1']['id'] }}" value="">
                            <input type="hidden" name="unit1[order_amount]" class="adaptval" data-key="order_amount-{{ $pairedItem['pair1']['id'] }}" value="">
                            <input type="hidden" name="unit1[take_profit_ticks]" class="adaptval" data-key="take_profit_ticks-{{ $pairedItem['pair1']['id'] }}" value="">
                            <input type="hidden" name="unit1[stop_loss_ticks]" class="adaptval" data-key="stop_loss_ticks-{{ $pairedItem['pair1']['id'] }}" value="">
                            <input type="hidden" name="unit1[account_id]" value="{{ $pairedItem['pair1']['trading_account_credential']['funder_account_id'] }}">
                            <input type="hidden" name="unit1[symbol]" class="adaptval" data-key="symbol-{{ $pairedItem['pair1']['id'] }}" value="{{ $pairedItem['pair1']['trading_account_credential']['symbol'] }}">

                            <input type="hidden" name="unit2[id]" value="{{ $pairedItem['pair2']['id'] }}">
                            <input type="hidden" name="unit2[unit]" value="{{ $pairedItem['pair2']['trading_account_credential']['user_account']['trading_unit']['unit_id'] }}">
                            <input type="hidden" name="unit2[machine]" value="{{ $pairedItem['pair2']['trading_account_credential']['platform_type'] }}">
                            <input type="hidden" name="unit2[latest_equity]" value="{{ $pairedItem['pair2']['latest_equity'] }}">
                            <input type="hidden" name="unit2[purchase_type]" class="adaptval" data-key="purchase-type-{{ $pairedItem['pair2']['id'] }}" value="">
                            <input type="hidden" name="unit2[order_amount]" class="adaptval" data-key="order_amount-{{ $pairedItem['pair2']['id'] }}" value="">
                            <input type="hidden" name="unit2[take_profit_ticks]" class="adaptval" data-key="take_profit_ticks-{{ $pairedItem['pair2']['id'] }}" value="">
                            <input type="hidden" name="unit2[stop_loss_ticks]" class="adaptval" data-key="stop_loss_ticks-{{ $pairedItem['pair2']['id'] }}" value="">
                            <input type="hidden" name="unit2[account_id]" value="{{ $pairedItem['pair2']['trading_account_credential']['funder_account_id'] }}">
                            <input type="hidden" name="unit2[symbol]" class="adaptval" data-key="symbol-{{ $pairedItem['pair2']['id'] }}" value="{{ $pairedItem['pair2']['trading_account_credential']['symbol'] }}">

                            @php
                                $pair1InstanceKey = $pairedItem['pair1']['trading_account_credential']['funder']['alias'] .'_'. $pairedItem['pair1']['trading_account_credential']['user_account']['trading_unit']['unit_id'];
                                $pair2InstanceKey = $pairedItem['pair2']['trading_account_credential']['funder']['alias'] .'_'. $pairedItem['pair2']['trading_account_credential']['user_account']['trading_unit']['unit_id'];
                            @endphp

                            @if(in_array($pair1InstanceKey, $tradesHandler) || in_array($pair2InstanceKey, $tradesHandler))
                                <p class="text-red-500">Unable to initiate trade.</p>
                            @else
                                <button type="submit" class="initiate-trade-btn hidden px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="w-[24px] h-[24px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 18V6l8 6-8 6Z"/>
                                    </svg>
                                    {{ __('Initiate Trade') }}
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const tradeBtn = document.querySelectorAll('.initiate-trade-btn');

            tradeBtn.forEach(function(btn) {
                btn.classList.remove('hidden');
            });


            const selects = document.querySelectorAll('select.purchase-type');

            selects.forEach(function(select) {
                select.addEventListener('change', function() {
                    const pairId = this.getAttribute('data-pair');
                    const pair = document.getElementById(pairId);

                    if(this.value === 'sell') {
                        pair.value = 'buy';
                    }
                    if(this.value === 'buy') {
                        pair.value = 'sell';
                    }
                });
            });

            const tradeForms = document.querySelectorAll('.form-trade');

            tradeForms.forEach(function(form) {
               form.addEventListener('submit', function(e) {
                   e.preventDefault();

                   form.querySelectorAll('.adaptval').forEach(function(field) {
                       const key = field.getAttribute('data-key');
                       const handler = document.getElementById(key);

                       field.value = handler.value;
                   });

                   form.submit();
               });
            });
        });

    </script>
@else
<p>No paired items.</p>
@endif
