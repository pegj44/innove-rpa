<h3 class="mb-4 text-center font-bold" style="font-size: 16px;">TOTAL PROFIT</h3>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
    <table id="trading-accounts" x-data="" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">
                {{ __('Daily Profit') }}
            </th>
            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                {{ __('Weekly Profit') }}
            </th>
            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                {{ __('Monthly Profit') }}
            </th>
            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                {{ __('Profit') }}
            </th>
        </tr>
        </thead>
        <tbody>
            <tr class="border-b border-gray-700 bg-gray-800">
                <td class="px-6 py-4 font-medium whitespace-nowrap" style="font-size:16px;">
                    <span id="total-daily-profit-amount">0</span>
                </td>
                <td class="px-6 py-4 font-medium whitespace-nowrap" style="font-size:16px;">
                    <span id="total-weekly-profit-amount">0</span>
                </td>
                <td class="px-6 py-4 font-medium whitespace-nowrap" style="font-size:16px;">
                    <span id="total-monthly-profit-amount">0</span>
                </td>
                <td class="px-6 py-4 font-medium whitespace-nowrap" style="font-size:16px;">
                    <span id="final-total-profit-amount">0</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>


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
            <th scope="col" class="px-6 py-3">
                {{ __('Date') }}
            </th>
        </tr>
        </thead>
        <tbody>
            @if(empty($tradeHistory))
                <tr class="border-b border-gray-700 bg-gray-800 hover:bg-gray-600">
                    <td colspan="5" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">There are no trades yet.</td>
                </tr>
            @else

                @php
                    $totalWeeklyProfit = [];
                    $totalDailyProfit = [];
                    $totalMonthlyProfit = [];
                    $finalTotalProfit = [];
                @endphp

                @foreach($tradeHistory as $item)

                    @php
                        $date = \Carbon\Carbon::parse($item['created_at']);
                        $dailyProfit = (float) $item['latest_equity'] - (float) $item['starting_daily_equity'];
                        $totalProfitHandler = (float) $item['latest_equity'] - (float) $item['trading_account_credential']['starting_balance'];
                        $totalProfitHandler = ($totalProfitHandler > 0)? $totalProfitHandler : 0;

                        $finalTotalProfit[] = $totalProfitHandler;

                        if ($dailyProfit > 0 && $date->isToday()) {
                            $totalDailyProfit[] = $dailyProfit;
                        }

                        if ($dailyProfit > 0 && $date->isCurrentWeek()) {
                            $totalWeeklyProfit[] = $dailyProfit;
                        }

                        if ($dailyProfit > 0 && $date->isCurrentMonth()) {
                            $totalMonthlyProfit[] = $dailyProfit;
                        }


                        $dailyPnL = (float) $item['latest_equity'] - (float) $item['starting_daily_equity'];
                        $totalProfit = (float) $item['latest_equity'] - (float) $item['trading_account_credential']['starting_balance'];
                        $totalProfit = ($totalProfit > 0)? $totalProfit : 0;

                        $formattedDate = $date->format('M j, Y');
                    @endphp

                    <tr class="border-b border-gray-700 bg-gray-800 hover:bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <span class="bg-gray-900 border border-gray-700 px-2 py-1 rounded">{{ $item['trading_account_credential']['funder']['alias'] }}</span> {{ $item['trading_account_credential']['funder_account_id'] }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item['starting_daily_equity'] }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item['latest_equity'] }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            @if($dailyPnL > 0)
                                <span class="text-green-500 font-bold">{{ number_format($dailyPnL, 2) }}</span>
                            @else
                                {{ number_format($dailyPnL, 2) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            @if($totalProfit > 0)
                                <span class="text-green-500 font-bold">{{ number_format($totalProfit, 2) }}</span>
                            @else
                                {{ number_format($totalProfit, 2) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $formattedDate }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<div class="hidden">
    <div id="total-daily-profit">
        @if(array_sum($totalDailyProfit) > 0)
            <span class="text-green-500">+${{ number_format(array_sum($totalDailyProfit), 2) }}</span>
        @else
            0.00
        @endif
    </div>
    <div id="total-weekly-profit">
        @if(array_sum($totalWeeklyProfit) > 0)
            <span class="text-green-500">+${{ number_format(array_sum($totalWeeklyProfit), 2) }}</span>
        @else
            0.00
        @endif
    </div>
    <div id="total-monthly-profit">
        @if(array_sum($totalMonthlyProfit) > 0)
            <span class="text-green-500">+${{ number_format(array_sum($totalMonthlyProfit), 2) }}</span>
        @else
            0.00
        @endif
    </div>
    <div id="final-total-profit">
        @if(array_sum($finalTotalProfit) > 0)
            <span class="text-green-500">+${{ number_format(array_sum($finalTotalProfit), 2) }}</span>
        @else
            0.00
        @endif
    </div>
</div>

<script>
    const total_daily_profit = document.getElementById('total-daily-profit');
    const total_weekly_profit = document.getElementById('total-weekly-profit');
    const total_monthly_profit = document.getElementById('total-monthly-profit');
    const final_total_profit = document.getElementById('final-total-profit');

    const total_daily_profit_amount = document.getElementById('total-daily-profit-amount');
    const total_weekly_profit_amount = document.getElementById('total-weekly-profit-amount');
    const total_monthly_profit_amount = document.getElementById('total-monthly-profit-amount');
    const final_total_profit_amount = document.getElementById('final-total-profit-amount');

    total_daily_profit_amount.innerHTML = total_daily_profit.innerHTML;
    total_weekly_profit_amount.innerHTML = total_weekly_profit.innerHTML;
    total_monthly_profit_amount.innerHTML = total_monthly_profit.innerHTML;
    final_total_profit_amount.innerHTML = final_total_profit.innerHTML;
</script>
