@php
    switch ($item['status']) {
        case 'pairing':
            $trHtmlClass = '-purple-500';
            break;
        case 'trading':
            $trHtmlClass = '-blue-500';
            break;
        case 'abstained':
            $trHtmlClass = '-yellow';
            break;
        case 'breached':
            $trHtmlClass = '-red-500';
        break;
        case 'breachedcheck':
            $trHtmlClass = '-status-breachedcheck';
        break;
        case 'waiting':
            $trHtmlClass = '-green-500 status-waiting';
        break;
        case 'onhold':
            $trHtmlClass = '-orange-400';
        break;
        case 'kyc':
            $trHtmlClass = '-status-kyc';
        break;
        default:
            $trHtmlClass = '-white';
            break;
    }

    $itemFunder = str_replace(' ', '_', $item['trading_account_credential']['package']['funder']['alias']);
    $itemPairHandler = strtolower($itemFunder) .'_'. $item['trading_account_credential']['user_account']['trading_unit']['unit_id'];
    $remainingNTrades = 10 - $item['n_trades'];
    $workingItemsHandler = (!empty($workingItemsHandler))? $workingItemsHandler : [];
@endphp

@if(!empty($controls))
    <td class="pl-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" style="z-index: 10">


        @if($item['status'] === 'payout')
            <div style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; overflow: hidden;">
            </div>
        @endif

        @if(!hasFunderAccountCredential($item['trading_account_credential']['user_account']['funder_account_credential'], $item['trading_account_credential']['package']['funder']['id']))
            <svg class="w-6 h-6 text-orange-400" data-tooltip-target="tooltip-right-{{ $item['id'] }}" data-tooltip-placement="right" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>

            <div id="tooltip-right-{{ $item['id'] }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                No platform credentials detected.
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        @else
            @if($item['status'] === 'idle' && !in_array($itemPairHandler, $workingItemsHandler) && $remainingNTrades > 0 && !in_array($item['trading_account_credential']['user_account']['trading_unit']['unit_id'], $pairingUnitsHandler))
                <a href="#" x-on:click="requestPair({{$item['id']}}, event, $event.target)" class="flex flex-row gap-1 pair-item-btn font-medium text-blue-600 dark:text-blue-50">
                    <svg class="w-[20px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 10 3-3m0 0-3-3m3 3H5v3m3 4-3 3m0 0 3 3m-3-3h14v-3"/>
                    </svg>
                    @if($remainingNTrades > 1)
                        <span class="text-green-500">{{ $remainingNTrades }}</span>
                    @else
                        <span class="text-red-500">{{ $remainingNTrades }}</span>
                    @endif
                </a>
                <a href="#" x-on:click="requestCancelPair({{$item['id']}}, event, $event.target)" class="cancel-pair-item-btn font-medium text-blue-600 dark:text-blue-50">
                    <svg class="w-[20px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                    </svg>
                </a>
            @endif

            @if(in_array($item['trading_account_credential']['user_account']['trading_unit']['unit_id'], $pairingUnitsHandler))
                <svg class="w-6 h-6 text-yellow-400" data-tooltip-target="tooltip-right-{{ $item['id'] }}" data-tooltip-placement="right" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <div id="tooltip-right-{{ $item['id'] }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Waiting for another platform to complete the initialization.
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            @endif
        @endif
    </td>
@endif
<td class="relative px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
<span class="flex flex-row items-center gap-2">
    <span class="px-2 hidden user-acc-id" style="text-shadow: 1px 1px 1px #000;">{{ $item['trading_account_credential']['user_account']['id'] }}</span>
    <span class="flex flex-row trade-list-account">
        <span class="bg-gray-700 flex flex-row items-center justify-center">{{ str_replace('UNIT', '', $item['trading_account_credential']['user_account']['trading_unit']['name']) }}</span>
        <span class="flex flex-col">
            <span class="bg-gray-900 font-black funder-alias" {!! renderFunderAliasAttr($item['trading_account_credential']['package']['funder']) !!}> {{ $item['trading_account_credential']['package']['funder']['alias'] }}</span>
            <span class="acc-status {{$item['trading_account_credential']['package']['current_phase']}}">
                {{ getPhaseName($item['trading_account_credential']['package']['current_phase']) }}
            </span>
        </span>
    </span>
    <span class="flex flex-col">
        <span class="flex flex-row gap-1">
            @if(!empty($item['trading_account_credential']['priority']))
                <div class="flex flex-row">
                    @php
                        $counter = 0;
                    @endphp
                    @while($counter < (int) $item['trading_account_credential']['priority'])
                        <svg class="w-[10px] h-[10px] dark:text-yellow-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/>
                        </svg>
                        @php
                            $counter++;
                        @endphp
                    @endwhile
                </div>
            @endif
            @if(!empty($item['trading_account_credential']['payouts']))
                <span class="has-payout">
                    <svg class="w-[10px] h-[10px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2"/>
                    </svg>

                </span>
            @endif
        </span>
        <span>{{ getFunderAccountShortName($item['trading_account_credential']['funder_account_id']) }}</span>
        <span class="package-tag {{ strtolower($item['trading_account_credential']['package']['funder']['alias']) .'-'. strtolower(str_replace(' ', '-', $item['trading_account_credential']['package']['name'])) }}">{{ $item['trading_account_credential']['package']['name'] }}</span>
    </span>
</span>

</td>
{{--                        <td class="relative px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">--}}
{{--                            <span class="dot {{$item['trading_account_credential']['package']['current_phase']}}"></span> {{ getPhaseName($item['trading_account_credential']['package']['current_phase']) }}--}}
{{--                        </td>--}}
<td class="relative px-3 py-4 font-medium dark:text{{ $trHtmlClass }} whitespace-nowrap">
    @if($item['status'] !== 'payout')
        <span class="bg{{ $trHtmlClass }} dot"></span>
    @endif
    {{ \App\Http\Controllers\TradeReportController::$statuses[$item['status']] }}
</td>
<td class="relative px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
    {{ number_format($item['latest_equity'], 2) }}
</td>
<td class="relative px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
    {!! getPnLHtml($item) !!}
</td>
<td class="relative px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
    @php
        $rdd = getCalculatedRdd($item);
        $rdd = (is_numeric($rdd))? round($rdd, 0) : $rdd;
    @endphp
    @if($rdd < 100)
        <span class="text-red-500">{{ $rdd }}</span>
    @else
        {{ $rdd }}
    @endif
</td>
<td class="relative px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
    {{ getHighestProfit($item) }}
</td>
<td class="relative px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
    {{ getCalculatedConsistency($item) }}
</td>
<td class="relative px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
    @php
        $rtd = getRemainingTradingDays($item);
    @endphp
    @if($rtd <= 0)
        <span class="text-green-500">{{ $rtd }}</span>
    @else
        {{ $rtd }}
    @endif
</td>
<td class="relative px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
    @php
        $rtp = getRemainingTargetProfit($item);
    @endphp
    @if($rtp <= 0)
        <span class="text-green-500">{{ $rtp }}</span>
    @else
        {{ $rtp }}
    @endif
</td>
@if(!empty($controls))
    <td class="pr-3 py-4 text-right border-gray-600">
        <a href="{{ route('trade.report.edit', $item['id']) }}" class="invisible table-row-edit font-medium text-blue-600 dark:text-blue-500 hover:underline">
            <svg class="w-[20px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
            </svg>
        </a>
    </td>
@endif
