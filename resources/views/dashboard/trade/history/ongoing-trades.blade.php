<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
    <table id="trading-accounts" x-data="" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">
                {{ __('Account') }}
            </th>
            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                {{ __('Balance') }}
            </th>
            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                {{ __('Latest Equity') }}
            </th>
            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                {{ __('Daily P&L') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Total Profit') }}
            </th>
        </tr>
        </thead>
        <tbody>
        @if(empty($ongoingTrades))
            <tr class="border-b border-gray-700 bg-gray-800 hover:bg-gray-600">
                <td colspan="5" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">No ongoing trades</td>
            </tr>
        @else
            @foreach($ongoingTrades as $item)
                @php
                    $dailyPnL1 = (float) $item['trade_report_pair1']['latest_equity'] - (float) $item['trade_report_pair1']['starting_daily_equity'];
                    $totalProfit1 = (float) $item['trade_report_pair1']['latest_equity'] - (float) $item['trade_report_pair1']['trading_account_credential']['starting_balance'];
                    $totalProfit1 = ($totalProfit1 > 0)? $totalProfit1 : 0;

                    $dailyPnL2 = (float) $item['trade_report_pair2']['latest_equity'] - (float) $item['trade_report_pair2']['starting_daily_equity'];
                    $totalProfit2 = (float) $item['trade_report_pair2']['latest_equity'] - (float) $item['trade_report_pair2']['trading_account_credential']['starting_balance'];
                    $totalProfit2 = ($totalProfit2 > 0)? $totalProfit2 : 0;
                @endphp
                <tr class="border-b border-gray-700 bg-gray-800 hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <span class="bg-gray-900 border border-gray-700 px-2 py-1 rounded">{{ $item['trade_report_pair1']['trading_account_credential']['funder']['alias'] }}</span> {{ $item['trade_report_pair1']['trading_account_credential']['funder_account_id'] }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $item['trade_report_pair1']['starting_daily_equity'] }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $item['trade_report_pair1']['latest_equity'] }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if($dailyPnL1 > 0)
                            <span class="text-green-500 font-bold">{{ number_format($dailyPnL1, 2) }}</span>
                        @else
                            {{ number_format($dailyPnL1, 2) }}
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if($totalProfit1 > 0)
                            <span class="text-green-500 font-bold">{{ number_format($totalProfit1, 2) }}</span>
                        @else
                            {{ number_format($totalProfit1, 2) }}
                        @endif
                    </td>
                </tr>

                <tr class="border-b border-gray-700 bg-gray-800 hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <span class="bg-gray-900 border border-gray-700 px-2 py-1 rounded">{{ $item['trade_report_pair2']['trading_account_credential']['funder']['alias'] }}</span> {{ $item['trade_report_pair2']['trading_account_credential']['funder_account_id'] }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $item['trade_report_pair2']['starting_daily_equity'] }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $item['trade_report_pair2']['latest_equity'] }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if($dailyPnL2 > 0)
                            <span class="text-green-500 font-bold">{{ number_format($dailyPnL2, 2) }}</span>
                        @else
                            {{ number_format($dailyPnL2, 2) }}
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if($totalProfit2 > 0)
                            <span class="text-green-500 font-bold">{{ number_format($totalProfit2, 2) }}</span>
                        @else
                            {{ number_format($totalProfit2, 2) }}
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
