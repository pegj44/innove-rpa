@if(!empty($tradedItems))

    <div id="accordion-paired-items" data-accordion="collapse">

        @foreach($tradedItems as $index => $tradedItem)
            <h2 id="accordion-collapse-heading-{{$index}}">
                <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-white border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 text-white hover:bg-gray-{{$index}}00 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-{{$index}}" aria-expanded="true" aria-controls="accordion-collapse-body-{{$index}}">
                    <span>
                        <span class="px-2 py-1 text-white rounded {{ (($tradedItem['pair1']['purchase_type'] === 'sell')? 'bg-red-500' : 'bg-blue-500') }}">{{ $tradedItem['pair1']['trade_credential']['account_id'] }}</span>
                        <span class="px-2 py-1 text-white rounded {{ (($tradedItem['pair2']['purchase_type'] === 'sell')? 'bg-red-500' : 'bg-blue-500') }}">{{ $tradedItem['pair2']['trade_credential']['account_id'] }}</span>
                    </span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-{{$index}}80 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-{{$index}}" class="hidden" aria-labelledby="accordion-collapse-heading-{{$index}}">
                <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    <div class="mb-2 flex bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="grid grid-cols-2 flex-1">
                            <div class="p-6 dark:bg-gray-900 p-6">
                                <div class="border-b dark:border-gray-600 flex justify-between">
                                    <h5 class="dark:text-white font-bold mb-2 text-gray-900 text-lg tracking-tight">
                                        {{ $tradedItem['pair1']['trade_credential']['trading_individual']['trading_unit']['name'] }} <span class="mb-3 font-normal text-gray-700 dark:text-gray-400">| {{ $tradedItem['pair1']['trade_credential']['account_id'] }}</span>
                                    </h5>
                                    <h5 class="dark:text-white font-bold mb-2 text-gray-900 text-lg tracking-tight">
                                        {{ $tradedItem['pair1']['trade_credential']['funder']['alias'] }}
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
                                                    {{ number_format($tradedItem['pair1']['starting_balance'], 2) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Starting Daily Equity') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($tradedItem['pair1']['starting_equity'], 2) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Latest Equity') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($tradedItem['pair1']['latest_equity'], 2) }}
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
                                                    @if($tradedItem['pair1']['order_type'] === 'quantity')
                                                        Quantity/Contract
                                                    @endif
                                                    @if($tradedItem['pair1']['order_type'] === 'lot')
                                                        Lot/Volume
                                                    @endif
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ $tradedItem['pair1']['order_amount'] }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Take Profit (Ticks)') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ $tradedItem['pair1']['take_profit_ticks'] }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Stop Loss (Ticks)') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ $tradedItem['pair1']['stop_loss_ticks'] }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Purchase Type') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900 font-bold {{ (isset($tradedItem['pair1']['purchase_type']) && $tradedItem['pair1']['purchase_type'] === 'buy')? 'text-blue-500' : 'text-red-500' }}">
                                                    {{ (isset($tradedItem['pair1']['purchase_type']) && $tradedItem['pair1']['purchase_type'] === 'buy')? 'Buy' : 'Sell' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="border-b dark:border-gray-600 flex justify-between">
                                    <h5 class="dark:text-white font-bold mb-2 text-gray-900 text-lg tracking-tight">
                                        {{ $tradedItem['pair2']['trade_credential']['trading_individual']['trading_unit']['name'] }} <span class="mb-3 font-normal text-gray-700 dark:text-gray-400">| {{ $tradedItem['pair2']['trade_credential']['account_id'] }}</span>
                                    </h5>
                                    <h5 class="dark:text-white font-bold mb-2 text-gray-900 text-lg tracking-tight">
                                        {{ $tradedItem['pair2']['trade_credential']['funder']['alias'] }}
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
                                                    {{ number_format($tradedItem['pair2']['starting_balance'], 2) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Starting Daily Equity') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($tradedItem['pair2']['starting_equity'], 2) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Latest Equity') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ number_format($tradedItem['pair2']['latest_equity'], 2) }}
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
                                                    @if($tradedItem['pair2']['order_type'] === 'quantity')
                                                        Quantity/Contract
                                                    @endif
                                                    @if($tradedItem['pair2']['order_type'] === 'lot')
                                                        Lot/Volume
                                                    @endif
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ $tradedItem['pair2']['order_amount'] }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Take Profit (Ticks)') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ $tradedItem['pair2']['take_profit_ticks'] }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Stop Loss (Ticks)') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                    {{ $tradedItem['pair2']['stop_loss_ticks'] }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                                <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    {{ __('Purchase Type') }}
                                                </th>
                                                <td class="px-6 py-4 w-1/2 dark:bg-gray-900 font-bold {{ (isset($tradedItem['pair2']['purchase_type']) && $tradedItem['pair2']['purchase_type'] === 'buy')? 'text-blue-500' : 'text-red-500' }}">
                                                    {{ (isset($tradedItem['pair2']['purchase_type']) && $tradedItem['pair2']['purchase_type'] === 'buy')? 'Buy' : 'Sell' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-12 text-center">
                    <form method="POST" action="">
                        <button type="submit" class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            <svg class="w-6 h-6 text-white mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            {{ __('Close Positions') }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>No ongoing trades.</p>
@endif
