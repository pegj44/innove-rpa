<x-app-layout>

    <div class="p-6 mt-14">

        <div class="shadow-sm">
            <div class="text-gray-900 dark:text-gray-100 mb-4">
                @php
                    $userData = session('api_user_data');
                @endphp
                @include('components.dashboard-notification')

                <h5 class="mb-3">Trade History</h5>

                <div class="relative overflow-x-auto sm:rounded-lg mt-2">

                    <table id="trading-history" x-data="" class="mt-4 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Account') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('P&L') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Lots') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('TP') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('SL') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($tradeHistory as $itemIndex => $pairItems)
                                @php
                                        $counter = 0;
                                        $date = \Carbon\Carbon::parse($pairItems['updated_at'])->setTimezone('Asia/Manila');
                                        $formattedDate = $date->format('M j, Y h:i a');

                                        $pData = array_values($pairItems['data']);
                                        //$pnl1 = $pData['']
                                @endphp
                                @foreach($pairItems['data'] as $historyId => $item)
                                    @php
                                        $funderTheme = [
                                            'theme' => $item['funder_theme']
                                        ];

                                        $latestEquity = $item['latest_equity'];
                                        $newEquity = (isset($item['new_equity']))? $item['new_equity'] : $latestEquity;
                                        $pnl = (float) $newEquity - (float) $latestEquity;
                                        $counter++;
                                    @endphp
                                    @if($counter === 1)
                                        <tr class="border-b border-gray-700 bg-gray-800">
                                            <td colspan="5">
                                                <span class="flex flex-row justify-between items-center">
                                                    <span>
                                                        @php
                                                            $pnlDiff = '';
                                                        @endphp
                                                        <span></span>
                                                        <span>{{ $formattedDate }}</span>
                                                    </span>
                                                    <span>
                                                        #{{ $pairItems['id'] }}
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr class="border-b border-gray-700 bg-gray-800 hover:bg-gray-600">
                                        <td>
                                            <span class="flex flex-row items-center gap-2">
                                                <span class="flex flex-row trade-list-account">
                                                    <span class="bg-gray-700 flex flex-row items-center justify-center text-white">{{ str_replace('UNIT', '', $item['unit_name']) }}</span>
                                                    <span class="flex flex-col">
                                                        <span class="bg-gray-900 font-black funder-alias" {!! renderFunderAliasAttr($funderTheme) !!}> {{ $item['funder'] }}</span>
                                                        <span class="acc-status {{$item['phase']}} text-white font-bold">
                                                            {{ getPhaseName($item['phase']) }}
                                                        </span>
                                                    </span>
                                                </span>
                                                <span class="flex flex-col">
                                                    <span class="text-white">{{ getFunderAccountShortName($item['funder_account_id_long']) }}</span>
                                                </span>
                                                @if($pnl == 0)
                                                    <span>
                                                        <form action="{{ route('trade.history.update-item', [$pairItems['id'], $historyId]) }}" method="post">
                                                            @csrf
                                                            <button type="submit" class="text-white">
                                                                <svg class="w-[20px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </span>
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <span class="pr-3">{{ ucfirst($item['purchase_type']) }}</span>
                                            <span class="{!! ($pnl > 0)? 'text-green-500' : 'text-red-500' !!}">{{ number_format($pnl, 2) }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item['order_amount'] }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item['tp'] }} | ${{ (float) $item['order_amount'] * (float) $item['tp'] }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item['sl'] }} | ${{ (float) $item['order_amount'] * (float) $item['sl'] }}</span>
                                        </td>
                                    </tr>
                                    <tr class="{{ ($counter !== 2)? 'hidden' : '' }}">
                                        <td colspan="5" class="pt-5"></td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>

</x-app-layout>
