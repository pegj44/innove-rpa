

<form method="POST" action="{{ route('trade.pair') }}">
    @csrf
    <button type="submit" class="px-5 py-3 text-base font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="w-[28px] h-[28px] mr-1 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 10 3-3m0 0-3-3m3 3H5v3m3 4-3 3m0 0 3 3m-3-3h14v-3"/>
        </svg>
        Pair Accounts
    </button>
</form>

@if(!empty($pairedItems))
    <div class="mt-10">
        <h3 class="mb-5">{{ __('Paired Accounts') }}</h3>
        @foreach($pairedItems as $item)
            @php
                $pair1 = $item['trade_report_pair1'];
                $pair2 = $item['trade_report_pair2'];

                $reportInfo = [
                    'pair1' => getTradeReportCalculations($pair1),
                    'pair2' => getTradeReportCalculations($pair2)
                ];
            @endphp
            <div class="mb-10 flex bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-1 flex-col max-w-[300px] p-6">
                    @if($item['status'] === 'paired')
                        <div class="flex flex-1 justify-center items-center">
                            <h4 class="text-green-500">{{ __('Ready to Trade') }}</h4>
                        </div>
                        <div class="h-12 text-center">
                            <form method="POST" action="">
                                @csrf
                                <button type="button" class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
