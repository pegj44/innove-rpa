@if(!empty($pairedItems))

    <div id="accordion-pairing-items" data-accordion="collapse">
        @foreach($pairedItems as $index => $pairedItemData)
            @php
                $pairedItemKeys = array_keys($pairedItemData['data']);
                $pair1ItemId = $pairedItemKeys[0];
                $pair2ItemId = $pairedItemKeys[1];

                $pairItem1 = $pairedItemData['data'][$pair1ItemId];
                $pairItem2 = $pairedItemData['data'][$pair2ItemId];

                $unitReady = (!empty($pairedItemData['unit_ready']))? $pairedItemData['unit_ready'] : [];
                $keysIntersect = array_intersect($unitReady, $pairedItemKeys);

                $canStartTrade = false;

                if (count($keysIntersect) === 2) {
                    $canStartTrade = true;
                }

                $canCloseTrade = false;

                if ($canStartTrade || $pairedItemData['status'] === 'error') {
                    $canCloseTrade = true;
                }
            @endphp
            <h2 id="accordion-paired-collapse-heading-{{$index}}" data-queueItemId="{{ $pairedItemData['queue_db_id'] }}" class="flex">
                <button type="button" class="flex items-center justify-between w-full p-0 font-medium rtl:text-right text-white border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 text-white hover:bg-gray-{{$index}}00 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-paired-collapse-body-{{$index}}" aria-expanded="false" aria-controls="accordion-paired-collapse-body-{{$index}}">
                    <div class="flex items-center w-full" style="padding-left: 17px;">
                        <svg data-accordion-icon class="mr-5 w-3 h-3 rotate-{{$index}}80 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                        <div class="border-gray-700 border-l flex items-center justify-between w-full">
                            <div class="w-1/2 p-5 bg-gray-900">
                                <div class="dark:border-gray-600 flex justify-between">
                                    <h5 class="dark:text-white font-bold text-gray-900 text-lg tracking-tight flex flex-row">
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
                                        <span class="status-handler flex flex-row gap-1 items-center" data-itemId="{{ $pair1ItemId }}">
                                            @if($pairedItemData['status'] === 'error' && !in_array($pair1ItemId, $unitReady))
                                                <span class="bg-red-600 font-normal ml-2 px-2 py-1 rounded text-sm">{{ __('Failed to initialize') }}</span>
                                            @endif
                                            @if($pairedItemData['status'] === 'reinitializing' && !in_array($pair1ItemId, $unitReady))
                                                <span class="bg-orange-600 font-normal ml-2 px-2 py-1 rounded text-sm">{{ __('Reinitializing...') }}</span>
                                            @endif
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
                                        <span class="status-handler" data-itemId="{{ $pair2ItemId }}">
                                            @if($pairedItemData['status'] === 'error' && !in_array($pair2ItemId, $unitReady))
                                                <span class="bg-red-600 font-normal ml-2 px-2 py-1 rounded text-sm">{{ __('Failed to initialize') }}</span>
                                            @endif

                                            @if($pairedItemData['status'] === 'reinitializing' && !in_array($pair2ItemId, $unitReady))
                                                <span class="bg-orange-600 font-normal ml-2 px-2 py-1 rounded text-sm">{{ __('Reinitializing...') }}</span>
                                            @endif
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
                <div class="border border-gray-700 border-l-0 flex items-center p-3 remove-pair {{ (!$canCloseTrade)? 'hidden' : '' }}">
                    <form method="post" action="{{ route('trade.remove-pair', $pairedItemData['queue_db_id']) }}" style="height: 24px;">
                        @csrf
                        @method('DELETE')
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

            <div id="accordion-paired-collapse-body-{{$index}}" class="hidden pair-item-accordion" aria-labelledby="accordion-paired-collapse-heading-{{$index}}">
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
                                                    <select id="pair1_purchase_type" class="border-2 border-gray-600 bg-gray-900 text-gray-300 text-sm block w-full p-2.5">
                                                        <option value="buy" {{ ($pairItem1['purchase_type'] === 'buy')? 'selected' : '' }}>Buy</option>
                                                        <option value="sell" {{ ($pairItem1['purchase_type'] === 'sell')? 'selected' : '' }}>Sell</option>
                                                    </select>
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
                                                <select id="pair2_purchase_type" class="border-2 border-gray-600 bg-gray-900 text-gray-300 text-sm block w-full p-2.5">
                                                    <option value="buy" {{ ($pairItem2['purchase_type'] === 'buy')? 'selected' : '' }}>Buy</option>
                                                    <option value="sell" {{ ($pairItem2['purchase_type'] === 'sell')? 'selected' : '' }}>Sell</option>
                                                </select>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="pair-footer-wrap-{{ $pairedItemData['queue_db_id'] }}" class="h-12 text-center">
                        <form method="POST" id="trade-item-status-{{ $pairedItemData['queue_db_id'] }}" action="{{ route('trade.start') }}" class="form-trade">
                            @csrf
                            <input type="hidden" id="pair1_purchase_type" name="purchase_type[{{ $pair1ItemId }}]" value="">
                            <input type="hidden" id="pair2_purchase_type" name="purchase_type[{{ $pair2ItemId }}]" value="">

                            <div class="pair-form-wrap">
                                @if((!$canStartTrade && $pairedItemData['status'] !== 'error') || $pairedItemData['status'] === 'reinitializing')
                                    @include('dashboard.trade.play.components.initializing-notif')
                                @else
                                    @if($pairedItemData['status'] === 'error')
{{--                                        @include('dashboard.trade.play.components.re-initiate-trade-btn')--}}
                                    @else
                                        @include('dashboard.trade.play.components.initiate-trade-btn')
                                    @endif
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const tradeBtn = document.querySelectorAll('.initiate-trade-btn');

            tradeBtn.forEach(function(btn) {
                btn.classList.remove('hidden');
            });

            const tradeForms = document.querySelectorAll('.form-trade');

            tradeForms.forEach(function(form) {
               form.addEventListener('submit', function(e) {
                   e.preventDefault();

                   form.querySelectorAll('.adaptval').forEach(function(field) {
                       const key = field.getAttribute('data-key');
                       const handler = document.getElementById(key);

                       field.value = handler.value;
                   });

                   form.submit();
               });
            });

            const pairItemAccordion = document.querySelectorAll('.pair-item-accordion');

            pairItemAccordion.forEach(function(item) {

                const pair1PurchaseType = item.querySelector('#pair1_purchase_type');
                const pair2PurchaseType = item.querySelector('#pair2_purchase_type');

                const pair1PurchaseTypeOverride = item.querySelector('input#pair1_purchase_type');
                const pair2PurchaseTypeOverride = item.querySelector('input#pair2_purchase_type');

                pair1PurchaseType.addEventListener('change', function(e) {
                    if (pair1PurchaseType.value === 'buy') {
                        pair2PurchaseType.value = 'sell';
                    } else {
                        pair2PurchaseType.value = 'buy';
                    }

                    pair1PurchaseTypeOverride.value = pair1PurchaseType.value;
                    pair2PurchaseTypeOverride.value = pair2PurchaseType.value;
                });

                pair2PurchaseType.addEventListener('change', function(e) {
                    if (pair2PurchaseType.value === 'buy') {
                        pair1PurchaseType.value = 'sell';
                    } else {
                        pair1PurchaseType.value = 'buy';
                    }
                    pair1PurchaseTypeOverride.value = pair1PurchaseType.value;
                    pair2PurchaseTypeOverride.value = pair2PurchaseType.value;
                });
            });
        });

    </script>
@else
<p>No paired items.</p>
@endif
