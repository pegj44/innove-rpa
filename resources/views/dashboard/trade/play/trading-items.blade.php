@if(!empty($tradingItems))

    <div id="accordion-traded-items" data-accordion="collapse">

        @foreach($tradingItems as $index => $tradedItem)
            @php
                $pairedItemKeys = array_keys($tradedItem['data']);
                $pairItem1 = $tradedItem['data'][$pairedItemKeys[0]];
                $pairItem2 = $tradedItem['data'][$pairedItemKeys[1]];

                $unitReady = (!empty($tradedItem['unit_ready']))? $tradedItem['unit_ready'] : [];
                $keysIntersect = array_intersect($unitReady, $pairedItemKeys);
            @endphp
            <h2 id="accordion-trading-collapse-heading-{{$index}}" class="flex">
                <button type="button" class="flex items-center justify-between w-full p-0 font-medium rtl:text-right text-white border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 text-white hover:bg-gray-{{$index}}00 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-trading-collapse-body-{{$index}}" aria-expanded="false" aria-controls="accordion-trading-collapse-body-{{$index}}">
                    <div class="flex items-center w-full" style="padding-left: 17px;">
                        <svg data-accordion-icon class="mr-5 w-3 h-3 rotate-{{$index}}80 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                        <div class="border-gray-700 border-l flex items-center justify-between w-full">
                            <div class="w-1/2 p-5 bg-gray-900">
                                <div class="dark:border-gray-600 flex justify-between">
                                    <h5 class="dark:text-white font-bold text-gray-900 text-lg tracking-tight">
                                        <span class="flex flex-row gap-3 items-center">
                                            <span class="flex flex-col">
                                                <span class="bg-gray-900 font-black font-bold funder-alias text-sm" {!! renderFunderAliasAttr(['theme' => $pairItem1['funder_theme']]) !!}>
                                                    {{ $pairItem1['funder'] }}
                                                </span>
                                                <span class="acc-status {{$pairItem1['phase']}}" style="font-size: 12px !important; border-bottom-left-radius: 3px;">
                                                    {{ getPhaseName($pairItem1['phase']) }}
                                                </span>
                                            </span>
                                            <span class="font-normal text-gray-700 dark:text-white"> {{ getFunderAccountShortName($pairItem1['funder_account_id_long']) }}</span>
                                        </span>
                                    </h5>
                                    <h5 class="dark:text-white font-bold text-gray-900 text-lg tracking-tight">
                                        {{ $pairItem1['unit_name'] }}
                                    </h5>
                                </div>
                            </div>
                            <div class="w-1/2 p-5 bg-gray-800">
                                <div class="dark:border-gray-600 flex justify-between">
                                    <h5 class="dark:text-white font-bold text-gray-900 text-lg tracking-tight">
                                        <span class="flex flex-row gap-3 items-center">
                                            <span class="flex flex-col">
                                                <span class="bg-gray-900 font-black font-bold funder-alias text-sm" {!! renderFunderAliasAttr(['theme' => $pairItem2['funder_theme']]) !!}>
                                                    {{ $pairItem2['funder'] }}
                                                </span>
                                                <span class="acc-status {{$pairItem2['phase']}}" style="font-size: 12px !important; border-bottom-left-radius: 3px;">
                                                    {{ getPhaseName($pairItem2['phase']) }}
                                                </span>
                                            </span>
                                            <span class="font-normal text-gray-700 dark:text-white"> {{ getFunderAccountShortName($pairItem2['funder_account_id_long']) }}</span>
                                        </span>
                                    </h5>
                                    <h5 class="dark:text-white font-bold text-gray-900 text-lg tracking-tight">
                                        {{ $pairItem2['unit_name'] }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </button>
                <div class="border border-gray-700 border-l-0 flex items-center p-3 remove-pair">
                    <form method="post" action="{{ route('trade.remove-pair', $tradedItem['queue_db_id']) }}" style="height: 24px;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="type" value="close">
                        <button type="submit" class="">
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

            <div id="accordion-trading-collapse-body-{{$index}}" class="hidden" aria-labelledby="accordion-trading-collapse-heading-{{$index}}">
                <div class="border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    <div class="mb-5 flex bg-white border border-b-0 border-gray-200 shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="grid grid-cols-2 flex-1">
                            <div class="p-6 dark:bg-gray-900 p-6" style="padding-bottom: 0 !important;">
                                <div class="relative overflow-x-auto shadow-md">
                                    <table data-item="{{ $index }}" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tbody>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Starting Balance') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ number_format($pairItem1['starting_balance'], 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Starting Daily Equity') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ number_format($pairItem1['starting_equity'], 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Latest Equity') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ number_format($pairItem1['latest_equity'], 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Daily P&L') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                @php
                                                    $pairItem1Pnl = (float) $pairItem1['latest_equity'] - (float) $pairItem1['starting_equity'];
                                                @endphp
                                                {{ number_format($pairItem1Pnl, 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('RDD') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ number_format($pairItem1['rdd'], 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                Symbol
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ $symbols[$pairItem1['symbol']] }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                Order Amount
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ $pairItem1['order_amount'] }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Take Profit (Ticks)') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ $pairItem1['tp'] }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Stop Loss (Ticks)') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ $pairItem1['sl'] }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Purchase Type') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ ucfirst($pairItem1['purchase_type']) }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="p-6" style="padding-bottom: 0 !important;">
                                <div class="relative overflow-x-auto">
                                    <table data-item="{{ $index }}" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tbody>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Starting Balance') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ number_format($pairItem2['starting_balance'], 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Starting Daily Equity') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ number_format($pairItem2['starting_equity'], 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Latest Equity') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ number_format($pairItem2['latest_equity'], 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Daily P&L') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                @php
                                                    $pairItem2Pnl = (float) $pairItem2['latest_equity'] - (float) $pairItem2['starting_equity'];
                                                @endphp
                                                {{ number_format($pairItem2Pnl, 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('RDD') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ number_format($pairItem2['rdd'], 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                Symbol
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ $symbols[$pairItem2['symbol']] }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                Order Amount
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ $pairItem2['order_amount'] }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Take Profit (Ticks)') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ $pairItem2['tp'] }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Stop Loss (Ticks)') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ $pairItem2['sl'] }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th scope="row" class="bg-gray-50 dark:bg-gray-800 dark:text-white font-medium px-6 py-4 text-gray-900 whitespace-nowrap">
                                                {{ __('Purchase Type') }}
                                            </th>
                                            <td class="px-6 py-4 w-1/2 dark:bg-gray-900">
                                                {{ ucfirst($pairItem2['purchase_type']) }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="h-12 text-center mb-2">
                        <form method="POST" id="trade-item-status-{{ $tradedItem['queue_db_id'] }}" action="{{ route('trade.recover') }}" class="form-trade">
                            @csrf
                            <div class="start-trade-wrap">
                                <input type="hidden" name="queue_id" value="{{ $tradedItem['queue_db_id'] }}">
                                <button type="submit" class="initiate-trade-btn px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="w-[24px] h-[24px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"/>
                                    </svg>
                                    {{ __('Recover') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>No ongoing trades.</p>
@endif
