<x-app-layout>

{{--    <div>--}}
{{--        <div class="shining-gold-bg1" style="width: 500px; height: 100px; margin-top: 100px;">--}}
{{--            <div class="shining-bg-text">--}}
{{--                $25,000.00--}}
{{--            </div>--}}
{{--            @include('layouts.smoke')--}}
{{--            @include('layouts.smoke')--}}
{{--            @include('layouts.smoke')--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="mt-14 overflow-hidden">
        <div class="gap-5 dark:text-gray-100 grid grid-cols-1 lg:grid lg:grid-cols-3 md:grid-cols-2 p-6 text-gray-900 xl:grid-cols-4">
            <div class="text-center block max-w-sm p-6 border border-gray-200 rounded-lg shadow dark:border-gray-700">
                <img src="/images/daily-profit.png" class="mb-5 w-14 inline-block">
                @if($totalDailyProfit > 0)
                    <h2 class="font-bold text-3xl text-green-500 mb-3">+$<span class="number" data-end="{{ $totalDailyProfit }}" data-decimals="2">0</span></h2>
                @else
                    <h2 class="font-bold text-3xl text-white mb-3">0.00</h2>
                @endif

                <h5 class="dark:text-white mb-2 text-gray-900">
                    <span>Daily Profit</span>
{{--                    <span class="text-green-500">--}}
{{--                        4%--}}
{{--                        <svg class="w-5 h-5 text-green-500 inline-block" style="margin-top: -4px;margin-left: -5px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">--}}
{{--                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4"/>--}}
{{--                        </svg>--}}
{{--                    </span>--}}
                </h5>
            </div>
            <div class="text-center block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700">
                <img src="/images/weekly-profit.png" class="mb-5 w-14 inline-block">
                @if($totalWeeklyProfit > 0)
                    <h2 class="font-bold text-3xl text-green-500 mb-3">+$<span class="number" data-end="{{ $totalWeeklyProfit }}" data-decimals="2">0</span></h2>
                @else
                    <h2 class="font-bold text-3xl text-white mb-3">0.00</h2>
                @endif
                <h5 class="dark:text-white mb-2 text-gray-900">
                    <span>Weekly Profit</span>
{{--                    <span class="text-green-500">--}}
{{--                        4%--}}
{{--                        <svg class="w-5 h-5 text-green-500 inline-block" style="margin-top: -4px;margin-left: -5px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">--}}
{{--                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4"/>--}}
{{--                        </svg>--}}
{{--                    </span>--}}
                </h5>
            </div>
            <div class="text-center block max-w-sm p-6 shining-gold-bg border border-gray-200 rounded-lg shadow dark:border-gray-700">
                <img src="/images/investment.png" class="mb-5 w-14 inline-block">
                @if($finalTotalProfit > 0)
                    <h2 class="font-bold text-3xl text-green-500 mb-3">+$<span class="number" data-end="{{ $finalTotalProfit }}" data-decimals="2">0</span></h2>
                @else
                    <h2 class="font-bold text-3xl text-white mb-3">0.00</h2>
                @endif
                <h5 class="dark:text-white mb-2 text-gray-900">
                    <span>Total Profit</span>
{{--                    <span class="text-green-500">--}}
{{--                        4%--}}
{{--                        <svg class="w-5 h-5 text-green-500 inline-block" style="margin-top: -4px;margin-left: -5px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">--}}
{{--                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4"/>--}}
{{--                        </svg>--}}
{{--                    </span>--}}
                </h5>
            </div>
            <div class="text-center block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <img src="/images/trades.png" class="mb-5 w-14 inline-block">
                @if($tradeCount > 0)
                    <h2 class="font-bold text-3xl text-green-500 mb-3">{{ $tradeCount }}</h2>
                @else
                    <h2 class="font-bold text-3xl text-white mb-3">0.00</h2>
                @endif
                <h5 class="dark:text-white mb-2 text-gray-900">
                    <span>Weekly Number of Trades</span>
                </h5>
            </div>
        </div>

        <div class="overflow-hidden">
            <div class="dark:text-gray-100 p-6 text-gray-900">
                <h5>Ongoing Trades</h5>

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
            </div>
        </div>
    </div>

    <script>
        function animateNumber(element, start, end, duration, decimals) {
            let startTime = null;

            function animationStep(timestamp) {
                if (!startTime) startTime = timestamp;
                const elapsedTime = timestamp - startTime;

                const progress = Math.min(elapsedTime / duration, 1); // Cap the progress at 1 (100%)
                const currentNumber = (progress * (end - start) + start).toFixed(decimals);

                element.textContent = parseFloat(currentNumber).toLocaleString(undefined, {
                    minimumFractionDigits: decimals,
                    maximumFractionDigits: decimals
                }); // Adds commas and maintains decimal places

                if (progress < 1) {
                    requestAnimationFrame(animationStep); // Continue the animation
                } else {
                    element.style.opacity = 1; // Show the element at the end of the animation
                }
            }

            requestAnimationFrame(animationStep); // Start the animation
        }

        // Select all elements with the class "number"
        const numberElements = document.querySelectorAll('.number');

        // Iterate over each element and animate the number
        numberElements.forEach(element => {
            const endValue = parseFloat(element.getAttribute('data-end')); // Get the end number from the data attribute
            const decimals = parseInt(element.getAttribute('data-decimals')) || 0; // Get decimal places from attribute or default to 0
            animateNumber(element, 0, endValue, 1500, decimals); // Animate from 0 to the end value with decimals
        });
    </script>

</x-app-layout>
