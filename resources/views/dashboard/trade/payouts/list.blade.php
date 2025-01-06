<div class="relative">
    <table id="recent-payouts-table" x-data="" class="mt-4 overflow-hidden sm:rounded-lg w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            @if(!empty($controls))
                <th scope="col" class="px-6 py-3">
                </th>
            @endif
            <th scope="col" class="px-6 py-3">
                {{ __('Account') }}
            </th>
            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                {{ __('Balance') }}
            </th>
{{--            <th scope="col" class="px-6 py-3 whitespace-nowrap">--}}
{{--                {{ __('Total Profit') }}--}}
{{--            </th>--}}
            <th scope="col" class="px-6 py-3">
                {{ __('Amount Requested') }}
            </th>
            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                {{ __('Status') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Date') }}
            </th>
        </tr>
        </thead>
        <tbody>
        @if(empty($items))
            <tr class="border-b border-gray-700 bg-gray-800 hover:bg-gray-600">
                <td colspan="5" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">No trades yet</td>
            </tr>
        @else
            @foreach($items as $item)
                @php
                    $startingBalance = (isset($item['trading_account_credential']['package']['starting_balance']))? $item['trading_account_credential']['package']['starting_balance'] : $item['trading_account_credential']['starting_balance'];
                    $totalProfit1 = (float) $item['trading_account_credential']['trade_reports']['latest_equity'] - (float) $startingBalance;
                    $totalProfit1 = ($totalProfit1 > 0)? $totalProfit1 : 0;

                    $date = \Carbon\Carbon::parse($item['created_at']);
                    $formattedDate = $date->format('M j, Y');

                    $funder = (isset($item['trading_account_credential']['package']['funder']))? $item['trading_account_credential']['package']['funder'] : $item['trading_account_credential']['funder'];
                    $funderAlias = (isset($item['trading_account_credential']['package']['funder']['alias']))? $item['trading_account_credential']['package']['funder']['alias'] : $item['trading_account_credential']['funder']['alias'];
                @endphp
                <tr class="border-b border-gray-700 bg-gray-800 hover:bg-gray-600">
                    @if(!empty($controls))
                        <td class="px-6 py-4 text-right border-r border-gray-600">
                            <a href="{{ route('trade.payout.edit', $item['id']) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                <svg class="w-[20px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                </svg>
                            </a>
                        </td>
                    @endif
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <span class="bg-gray-900 border border-gray-700 px-2 py-1 rounded funder-alias" {!! renderFunderAliasAttr($funder) !!}>{{ $funderAlias }}</span> {{ $item['trading_account_credential']['funder_account_id'] }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ number_format($item['trading_account_credential']['trade_reports']['starting_daily_equity'], 2) }}
                    </td>
{{--                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">--}}
{{--                        @if($totalProfit1 > 0)--}}
{{--                            <span class="text-green-500 font-bold">{{ number_format($totalProfit1, 2) }}</span>--}}
{{--                        @else--}}
{{--                            {{ number_format($totalProfit1, 2) }}--}}
{{--                        @endif--}}
{{--                    </td>--}}
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <span class="text-green-500 font-bold">{{ number_format($item['amount_requested'], 2) }}</span>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ \App\Forms\PayoutForm::$payoutStatus[$item['status']] }}
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


@if(!empty($items))
    <script>

        jQuery.fn.dataTable.ext.type.order['custom-date-pre'] = function(d) {
            const date = new Date(d);
            return date.getTime();
        };

        jQuery('#recent-payouts-table').DataTable( {
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
                    targets: 4,
                    type: "custom-date"
                }
            ],
            order: [[4, 'desc']]
        });

    </script>
@endif
