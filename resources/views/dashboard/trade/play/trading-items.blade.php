@if(!empty($tradedItems))

    <div id="accordion-traded-items" data-accordion="collapse">

        @foreach($tradedItems as $index => $tradedItem)
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
                                        {{ $tradedItem['pair1']['trading_account_credential']['funder']['alias'] }} <span class="mb-3 font-normal text-gray-700 dark:text-gray-400">| {{ $tradedItem['pair1']['trading_account_credential']['funder_account_id'] }}</span>
                                    </h5>
                                    <h5 class="dark:text-white font-bold text-gray-900 text-lg tracking-tight">
                                        {{ $tradedItem['pair1']['trading_account_credential']['user_account']['trading_unit']['name'] }}
                                    </h5>
                                </div>
                            </div>
                            <div class="w-1/2 p-5 bg-gray-800">
                                <div class="dark:border-gray-600 flex justify-between">
                                    <h5 class="dark:text-white font-bold text-gray-900 text-lg tracking-tight">
                                        {{ $tradedItem['pair2']['trading_account_credential']['funder']['alias'] }} <span class="mb-3 font-normal text-gray-700 dark:text-gray-400">| {{ $tradedItem['pair2']['trading_account_credential']['funder_account_id'] }}</span>
                                    </h5>
                                    <h5 class="dark:text-white font-bold text-gray-900 text-lg tracking-tight">
                                        {{ $tradedItem['pair2']['trading_account_credential']['user_account']['trading_unit']['name'] }}
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
                            <input type="hidden" name="pair1" value="{{ $tradedItem['pair1']['id'] }}">
                            <input type="hidden" name="pair2" value="{{ $tradedItem['pair2']['id'] }}">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </h2>

            <div id="accordion-paired-collapse-body-{{$index}}" class="hidden" aria-labelledby="accordion-paired-collapse-heading-{{$index}}">
                <div class="border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    <div class="mb-5 flex bg-white border border-b-0 border-gray-200 shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="grid grid-cols-2 flex-1">
                            <div class="p-6 dark:bg-gray-900 p-6" style="padding-bottom: 0 !important;">
                                <div class="relative overflow-x-auto shadow-md">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tbody>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Starting Balance') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ number_format($tradedItem['pair1']['trading_account_credential']['starting_balance'], 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Starting Daily Equity') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ number_format($tradedItem['pair1']['starting_daily_equity'], 2) }}
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
                                                {!! getPnLHtml($tradedItem['pair1']) !!}
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
                                                Order Amount
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
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ ucfirst($tradedItem['pair1']['purchase_type']) }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="p-6" style="padding-bottom: 0 !important;">
                                <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tbody>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Starting Balance') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ number_format($tradedItem['pair2']['trading_account_credential']['starting_balance'], 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Starting Daily Equity') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ number_format($tradedItem['pair2']['starting_daily_equity'], 2) }}
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
                                                {!! getPnLHtml($tradedItem['pair2']) !!}
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
                                                Order Amount
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
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ ucfirst($tradedItem['pair2']['purchase_type']) }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>No ongoing trades.</p>
@endif
