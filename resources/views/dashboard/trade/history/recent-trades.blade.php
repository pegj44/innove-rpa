<div class="relative">
    <table id="recent-trades-table" x-data="" class="overflow-hidden sm:rounded-lg w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
        @if(empty($recentTrades))
            <tr class="border-b border-gray-700 bg-gray-800 hover:bg-gray-600">
                <td colspan="5" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">No trades yet</td>
            </tr>
        @else
            @foreach($recentTrades as $item)
                @php
                    $dailyPnL1 = (float) $item['latest_equity'] - (float) $item['starting_daily_equity'];
                    $startingBalance = (isset($item['trading_account_credential']['package']['starting_balance']))? $item['trading_account_credential']['package']['starting_balance'] : $item['trading_account_credential']['starting_balance'];
                    $totalProfit1 = (float) $item['latest_equity'] - (float) $startingBalance;
                    $totalProfit1 = ($totalProfit1 > 0)? $totalProfit1 : 0;

                    $date = \Carbon\Carbon::parse($item['created_at']);
                    $formattedDate = $date->format('M j, Y');

                    $funder = (isset($item['trading_account_credential']['package']['funder']))? $item['trading_account_credential']['package']['funder'] : $item['trading_account_credential']['funder'];
                    $funderAlias = (isset($item['trading_account_credential']['package']['funder']['alias']))? $item['trading_account_credential']['package']['funder']['alias'] : $item['trading_account_credential']['funder']['alias'];
                @endphp
                <tr class="border-b border-gray-700 bg-gray-800 hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <span class="bg-gray-900 border border-gray-700 px-2 py-1 rounded funder-alias" {!! renderFunderAliasAttr($funder) !!}>{{ $funderAlias }}</span> {{ $item['trading_account_credential']['funder_account_id'] }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ number_format($item['starting_daily_equity'], 2) }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ number_format($item['latest_equity'], 2) }}
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
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $formattedDate }}
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>

@if(!empty($recentTrades))
    <script>

        jQuery.fn.dataTable.ext.type.order['custom-date-pre'] = function(d) {
            const date = new Date(d);
            return date.getTime();
        };

        jQuery('#recent-trades-table').DataTable( {
            paging: true,
            lengthChange: false,
            pageLength: 20,
            searching: false,
            columnDefs: [
                {
                    orderable: false,
                    targets: [0]
                },
                {
                    targets: 5,
                    type: "custom-date"
                }
            ],
            order: [[5, 'desc']]
        });

    </script>
@endif
