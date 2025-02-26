@if(!empty($tradingAccounts))

@php
    $symbols = getTradingSymbols();
@endphp
    <div class="flex filters">
        @if(!empty($controls))
            <div class="flex flex-col pr-5">
                <div>
                    <div class="border-b border-gray-700 mb-3 pb-2">
                        <label class="inline-flex items-center cursor-pointer" x-data="">
                            <input id="toggle-pairables" type="checkbox" value="" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-900 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all border dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Pairables</span>
                        </label>
                    </div>

                    <div class="border-b border-gray-700 mb-3 pb-2">
                        <p class="mb-2 text-sm">Funders</p>
                        @foreach($funders as $funder)
                            <div class="mb-1">
                                <label class="inline-flex items-center cursor-pointer" x-data="">
                                    <input id="filter-funder-{{ $funder['id'] }}" type="checkbox" {!! isChecked('filter-funder-'. $funder['id'], $filterSettings, 1) !!} value="{{ $funder['id'] }}" class="filter-toggle sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-900 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all border dark:border-gray-600 peer-checked:bg-gray-700"></div>
                                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300 funder-alias rounded-sm" {!! renderFunderAliasAttr($funder) !!}>{{ $funder['alias'] }}</span>
                                </label>
                            </div>
                            <style>
                                #trading-accounts:not(.show-filter-funder-{{ $funder['id'] }}) [data-funder="{{ $funder['id'] }}"]  {
                                    display: none !important;
                                }
                            </style>
                        @endforeach
                    </div>

                    <div class="border-b border-gray-700 mb-3 pb-2">
                        <p class="mb-2 text-sm">Phase</p>
                        @php
                            $phases = [
                                'phase-3' => 'Live',
                                'phase-1' => 'Phase 1',
                                'phase-2' => 'Phase 2'
                            ];
                        @endphp
                        @foreach($phases as $phaseKey => $phase)
                            <div class="mb-1">
                                <label class="inline-flex items-center cursor-pointer" x-data="">
                                    <input id="filter-phase-{{ $phaseKey }}" type="checkbox" value="{{ $phaseKey }}" {!! isChecked('filter-phase-'. $phaseKey, $filterSettings, 1) !!} class="filter-toggle sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-900 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all border dark:border-gray-600 peer-checked:bg-gray-700"></div>
                                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        <span class="dot {{ $phaseKey }}"></span>
                                        {{ $phase }}
                                    </span>
                                </label>
                            </div>
                            <style>
                                #trading-accounts:not(.show-filter-phase-{{ $phaseKey }}) [data-phase="{{ $phaseKey }}"]  {
                                    display: none !important;
                                }
                            </style>
                        @endforeach
                    </div>

                    <div class="mb-3 pb-2">
                        <p class="mb-2 text-sm">Status</p>
                        @foreach(\App\Http\Controllers\TradeReportController::$statuses as $statusKey => $status)
                            <div class="mb-1">
                                <label class="inline-flex items-center cursor-pointer" x-data="">
                                    <input id="filter-status-{{ $statusKey }}" type="checkbox" {!! isChecked('filter-status-'. $statusKey, $filterSettings, 1) !!} value="{{ $statusKey }}" class="filter-toggle sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-900 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all border dark:border-gray-600 peer-checked:bg-gray-700"></div>
                                    <span class="ms-3 status-{{ $statusKey }} text-sm font-medium text-gray-900 dark:text-gray-300">
                                        <span class="dot"></span>
                                        {{ $status }}
                                    </span>
                                </label>
                            </div>
                            <style>
                                #trading-accounts:not(.show-filter-status-{{ $statusKey }}) [data-status="{{ $statusKey }}"]  {
                                    display: none !important;
                                }
                            </style>
                        @endforeach
                    </div>
                </div>
            </div>

            <script>


                let controller = null;

                function updateFilterSettings(data)
                {
                    if (controller) {
                        controller.abort();
                    }

                    controller = new AbortController();
                    const signal = controller.signal;

                    fetch(apiUrl, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify({
                            key: "trading_filters",
                            value: data
                        }),
                        signal: signal
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("Network response was not ok " + response.statusText);
                            }
                            return response.json();
                        })
                        .then(responseData => {
                            console.log(responseData);
                        })
                        .catch(error => {
                            console.error("There was a problem with the fetch operation:", error);
                        });
                }

                document.addEventListener('DOMContentLoaded', function() {

                    const filterToggles = document.querySelectorAll('.filter-toggle');
                    const recordTable = document.getElementById('trading-accounts');
                    let enabledFilters = [];

                    filterToggles.forEach(input => {
                        const val = input.getAttribute('id');

                        if (input.checked) {
                            recordTable.classList.add('show-'+ val);
                            enabledFilters.push(val);
                        }

                        input.addEventListener('change', function(event) {

                            if (input.checked) {
                                recordTable.classList.add('show-'+ val);
                                enabledFilters.push(val);
                            } else {
                                recordTable.classList.remove('show-'+ val);
                                const index = enabledFilters.indexOf(val);
                                if (index !== -1) {
                                    enabledFilters.splice(index, 1);
                                }
                            }

                            updateFilterSettings(enabledFilters);
                        });
                    });
                });
            </script>
        @endif

        <div class="">
            <div class="relative overflow-x-auto sm:rounded-lg
  [&::-webkit-scrollbar]:w-2
  [&::-webkit-scrollbar-track]:bg-gray-100
  [&::-webkit-scrollbar-thumb]:bg-gray-300
  dark:[&::-webkit-scrollbar-track]:bg-neutral-700
  dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500" style="overflow-x: scroll; width: 65vw;">
                <table id="trading-accounts" x-data="" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    @if(!empty($controls))
                        <th scope="col" class="py-3"></th>
                    @endif
                    <th scope="col" class="px-6 py-3">
                        {{ __('Account') }}
                    </th>
{{--                    <th scope="col" class="px-6 py-3">--}}
{{--                        {{ __('Phase') }}--}}
{{--                    </th>--}}
                    <th scope="col" class="px-6 py-3">
                        {{ __('Status') }}
                    </th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        {{ __('L-EQUITY') }}
                    </th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        {{ __('Daily P&L') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('RDD') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Highest Profit') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Consis') }}
                    </th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        {{ __('R.T-days') }}
                    </th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        {{ __('R.T-Profit') }}
                    </th>
                    @if(!empty($controls))
                        <th scope="col" class="py-3"></th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($tradingAccounts as $item)
                    @php
                        $isShining = ($item['status'] === 'payout')? 'shining-gold-bg1' : '';
                    @endphp

                    <tr class="account-item border-b border-gray-700 bg-gray-800 hover:bg-gray-600 {{ $isShining }} {{ ($item['status'] === 'idle')? 'item-pairable' : 'item-not-pairable' }}"
                        data-id="{{ $item['id'] }}"
                        data-phase="{{ $item['trading_account_credential']['package']['current_phase'] }}"
                        data-user="{{ $item['trading_account_credential']['package']['funder']['alias'] }}{{ $item['trading_account_credential']['user_account']['id'] }}"
                        data-unit="{{ $item['trading_account_credential']['package']['funder']['alias'] }}{{ $item['trading_account_credential']['user_account']['trading_unit']['id'] }}"
                        data-funder="{{ $item['trading_account_credential']['package']['funder']['id'] }}"
                        data-funder-alias="{{ $item['trading_account_credential']['package']['funder']['alias'] }}"
                        data-status="{{ $item['status'] }}"
                    >
                        @include('dashboard.trade.report.item')
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>

            <div id="pair-unit-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 overflow-hidden">

                        <form id="initiate_trade" action="{{ route('trade.initiate-v2') }}" method="POST">
                            @csrf
                            <!-- Modal body -->

                            <div class="relative">
                                <div class="flex flex-row">
                                    <div id="item-pair-1-header" class="buy-wrap flex flex-row justify-between p-3 w-1/2">
                                        <div>
                                            <span class="bg-gray-900 rounded font-black funder-alias font-normal text-md" data-pair_val="funder"></span>
                                            <span class="mb-3 font-normal text-gray-700 dark:text-white" data-pair_val="funder_account_id_short"></span>
                                            <span class="package-tag pair-tag" data-pair_val="package_tag"></span>
                                        </div>
                                        <h5 class="dark:text-white font-bold text-gray-900 text-md tracking-tight" data-pair_val="unit_name"></h5>
                                    </div>
                                    <div id="item-pair-2-header" class="sell-wrap bg-red-700 flex flex-row justify-between p-3 w-1/2">
                                        <div>
                                            <span class="bg-gray-900 rounded font-black funder-alias font-normal text-md" data-pair_val="funder"></span>
                                            <span class="mb-3 font-normal text-gray-700 dark:text-white" data-pair_val="funder_account_id_short"></span>
                                            <span class="package-tag pair-tag" data-pair_val="package_tag"></span>
                                        </div>
                                        <h5 class="dark:text-white font-bold text-gray-900 text-md tracking-tight" data-pair_val="unit_name"></h5>
                                    </div>
                                </div>
                                <div class="flex flex-row">
                                    <div id="item-pair-1-body" class="buy-wrap-handle w-1/2">
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Starting Balance</div>
                                            <div class="bg-gray-700 px-3 py-2 w-1/2" data-pair_val="starting_balance"></div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Starting Equity</div>
                                            <div class="bg-gray-700 px-3 py-2 w-1/2" data-pair_val="starting_equity"></div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Latest Equity</div>
                                            <div class="bg-gray-700 px-3 py-2 w-1/2" data-pair_val="latest_equity"></div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Daily P&L</div>
                                            <div class="bg-gray-700 px-3 py-2 w-1/2" data-pair_val="pnl"></div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">RDD</div>
                                            <div class="bg-gray-700 px-3 py-2 w-1/2" data-pair_val="rdd"></div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Symbol</div>
                                            <div class="bg-gray-700 w-1/2">
                                                <select data-pair_val="symbol" class="border-2 border-gray-600 bg-gray-900 text-gray-300 text-sm block w-full p-2.5">
                                                    @foreach($symbols as $symbol)
                                                        <option value="{{ $symbol }}">{{ $symbol }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Order Amount</div>
                                            <div class="bg-gray-700 w-1/2">
                                                <input type="number" data-pair_val="order_amount" step="0.01" class="border-2 border-gray-600 block dark:bg-gray-900 dark:text-gray-300 w-full">
                                            </div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2 relative">
                                                Take Profit (Ticks)
                                                <span class="remaining-tp"></span>
                                            </div>
                                            <div class="bg-gray-700 w-1/2 relative">
                                                <input type="number" data-pair_val="tp" step="1" class="border-2 border-gray-600 block dark:bg-gray-900 dark:text-gray-300 w-full">
                                                <span class="converted-tp"></span>
                                            </div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2 relative">
                                                Stop Loss (Ticks)
                                                <span class="remaining-sl"></span>
                                            </div>
                                            <div class="bg-gray-700 w-1/2 relative">
                                                <input type="number" step="1" data-pair_val="sl" class="border-2 border-gray-600 block dark:bg-gray-900 dark:text-gray-300 w-full">
                                                <span class="converted-sl"></span>
                                            </div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Purchase Type</div>
                                            <div class="bg-gray-700 w-1/2">
                                                <select data-pair_val="purchase_type" class="border-2 border-gray-600 purchase-type bg-gray-900 text-gray-300 text-sm block w-full p-2.5">
                                                    <option value="buy" selected>Buy</option>
                                                    <option value="sell">Sell</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" data-pair_val="unit_id">
                                        <input type="hidden" data-pair_val="platform_type">
                                        <input type="hidden" data-pair_val="login_username">
                                        <input type="hidden" data-pair_val="login_password">
                                        <input type="hidden" data-pair_val="funder_account_id_long">
                                        <input type="hidden" data-pair_val="funder_account_id_short">
                                        <input type="hidden" data-pair_val="package_tag">
                                        <input type="hidden" data-pair_val="funder">
                                        <input type="hidden" data-pair_val="funder_theme">
                                        <input type="hidden" data-pair_val="unit_name">
                                        <input type="hidden" data-pair_val="starting_balance">
                                        <input type="hidden" data-pair_val="starting_equity">
                                        <input type="hidden" data-pair_val="latest_equity">
                                        <input type="hidden" data-pair_val="rdd">
                                        <input type="hidden" data-pair_val="phase">
                                    </div>
                                    <div id="item-pair-2-body" class="sell-wrap-handle w-1/2">
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Starting Balance</div>
                                            <div class="bg-gray-700 px-3 py-2 w-1/2" data-pair_val="starting_balance"></div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Starting Equity</div>
                                            <div class="bg-gray-700 px-3 py-2 w-1/2" data-pair_val="starting_equity"></div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Latest Equity</div>
                                            <div class="bg-gray-700 px-3 py-2 w-1/2" data-pair_val="latest_equity"></div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Daily P&L</div>
                                            <div class="bg-gray-700 px-3 py-2 w-1/2" data-pair_val="pnl"></div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">RDD</div>
                                            <div class="bg-gray-700 px-3 py-2 w-1/2" data-pair_val="rdd"></div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Symbol</div>
                                            <div class="bg-gray-700 w-1/2">
                                                <select data-pair_val="symbol" class="border-2 border-gray-600 bg-gray-900 text-gray-300 text-sm block w-full p-2.5">
                                                    @foreach($symbols as $symbol)
                                                        <option value="{{ $symbol }}">{{ $symbol }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Order Amount</div>
                                            <div class="bg-gray-700 w-1/2">
                                                <input type="number" data-pair_val="order_amount" step="0.01" class="border-2 border-gray-600 block dark:bg-gray-900 dark:text-gray-300 w-full">
                                            </div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2 relative">
                                                Take Profit (Ticks)
                                                <span class="remaining-tp"></span>
                                            </div>
                                            <div class="bg-gray-700 w-1/2 relative">
                                                <input type="number" data-pair_val="tp" step="1" class="border-2 border-gray-600 block dark:bg-gray-900 dark:text-gray-300 w-full">
                                                <span class="converted-tp"></span>
                                            </div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2 relative">
                                                Stop Loss (Ticks)
                                                <span class="remaining-sl"></span>
                                            </div>
                                            <div class="bg-gray-700 w-1/2 relative">
                                                <input type="number" step="1" data-pair_val="sl" class="border-2 border-gray-600 block dark:bg-gray-900 dark:text-gray-300 w-full">
                                                <span class="converted-sl"></span>
                                            </div>
                                        </div>
                                        <div class="border-b border-gray-900 flex flex-row">
                                            <div class="label px-3 py-2 w-1/2">Purchase Type</div>
                                            <div class="bg-gray-700 w-1/2">
                                                <select data-pair_val="purchase_type" class="border-2 border-gray-600 purchase-type bg-gray-900 text-gray-300 text-sm block w-full p-2.5">
                                                    <option value="buy">Buy</option>
                                                    <option value="sell" selected>Sell</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" data-pair_val="unit_id">
                                        <input type="hidden" data-pair_val="platform_type">
                                        <input type="hidden" data-pair_val="login_username">
                                        <input type="hidden" data-pair_val="login_password">
                                        <input type="hidden" data-pair_val="funder_account_id_long">
                                        <input type="hidden" data-pair_val="funder_account_id_short">
                                        <input type="hidden" data-pair_val="package_tag">
                                        <input type="hidden" data-pair_val="funder">
                                        <input type="hidden" data-pair_val="funder_theme">
                                        <input type="hidden" data-pair_val="unit_name">
                                        <input type="hidden" data-pair_val="starting_balance">
                                        <input type="hidden" data-pair_val="starting_equity">
                                        <input type="hidden" data-pair_val="latest_equity">
                                        <input type="hidden" data-pair_val="rdd">
                                        <input type="hidden" data-pair_val="phase">
                                    </div>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="flex justify-between items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                <button type="submit" data-modal-hide="pair-unit-modal" class="px-3 py-2 text-sm font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="w-[18px] h-[18px] text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M8.6 5.2A1 1 0 0 0 7 6v12a1 1 0 0 0 1.6.8l8-6a1 1 0 0 0 0-1.6l-8-6Z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __("Initiate Pairing") }}
                                </button>
                                <button data-modal-hide="pair-unit-modal" type="button" class="cancel-pair-accounts-btn py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <button id="pair-modal-handler" class="hidden" data-modal-target="pair-unit-modal" data-modal-toggle="pair-unit-modal"></button>

            <button id="auto-pair-btn" onclick="doAutoPair(this)" type="button" class="rounded items-center shadow-lg">
                <svg class="w-6 h-6 text-gray-800 dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M17.44 3a1 1 0 0 1 .707.293l2.56 2.56a1 1 0 0 1 0 1.414L18.194 9.78 14.22 5.806l2.513-2.513A1 1 0 0 1 17.44 3Zm-4.634 4.22-9.513 9.513a1 1 0 0 0 0 1.414l2.56 2.56a1 1 0 0 0 1.414 0l9.513-9.513-3.974-3.974ZM6 6a1 1 0 0 1 1 1v1h1a1 1 0 0 1 0 2H7v1a1 1 0 1 1-2 0v-1H4a1 1 0 0 1 0-2h1V7a1 1 0 0 1 1-1Zm9 9a1 1 0 0 1 1 1v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 1 1 0-2h1v-1a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                    <path d="M19 13h-2v2h2v-2ZM13 3h-2v2h2V3Zm-2 2H9v2h2V5ZM9 3H7v2h2V3Zm12 8h-2v2h2v-2Zm0 4h-2v2h2v-2Z"/>
                </svg>
                <span>{{ __('Auto Pair') }}</span>
            </button>

            <div id="pair-accounts-btn-wrapper" class="hidden do-pair-btn flex rounded items-center shadow-lg">
{{--                <form id="do-pair-accounts" method="post" action="{{ route('trade.pair-manual') }}">--}}
{{--                    @csrf--}}
                    <button id="request-pair-data" class="font-medium inline-flex items-center px-3 py-3 rounded-md text-center text-sm text-white" type="button">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M14.516 6.743c-.41-.368-.443-1-.077-1.41a.99.99 0 0 1 1.405-.078l5.487 4.948.007.006A2.047 2.047 0 0 1 22 11.721a2.06 2.06 0 0 1-.662 1.51l-5.584 5.09a.99.99 0 0 1-1.404-.07 1.003 1.003 0 0 1 .068-1.412l5.578-5.082a.05.05 0 0 0 .015-.036.051.051 0 0 0-.015-.036l-5.48-4.942Zm-6.543 9.199v-.42a4.168 4.168 0 0 0-2.715 2.415c-.154.382-.44.695-.806.88a1.683 1.683 0 0 1-2.167-.571 1.705 1.705 0 0 1-.279-1.092V15.88c0-3.77 2.526-7.039 5.967-7.573V7.57a1.957 1.957 0 0 1 .993-1.838 1.931 1.931 0 0 1 2.153.184l5.08 4.248a.646.646 0 0 1 .012.011l.011.01a2.098 2.098 0 0 1 .703 1.57 2.108 2.108 0 0 1-.726 1.59l-5.08 4.25a1.933 1.933 0 0 1-2.929-.614 1.957 1.957 0 0 1-.217-1.04Z" clip-rule="evenodd"/>
                        </svg>
                        Pair Accounts
                    </button>
                    <input type="hidden" name="paired-ids" id="paired-ids" value="">
{{--                </form>--}}
                <a href="#" class="cancel-pair-accounts-btn cancel-pair-floating border-gray-900 border-l px-1">
                    <svg class="w-5 h-5 text-gray-800 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                    </svg>
                </a>
            </div>

            <script>

                @if(!empty($controls))
                jQuery('#trading-accounts').DataTable( {
                    paging: false,
                    info: false,
                    searching: false,
                    columnDefs: [
                        {
                            orderable: false,
                            targets: [0, 9]
                        }
                    ]
                });
                @else
                jQuery('#trading-accounts').DataTable( {
                    paging: false,
                    info: false,
                    searching: false,
                    fixedHeader: true,
                    columnDefs: [
                        {
                            orderable: false,
                            targets: [0, 7]
                        },
                        {
                            targets: 2,
                            orderDataType: "custom-payout-sort"
                        }
                    ],
                    order: []
                });

                $.fn.dataTable.ext.order['custom-payout-sort'] = function(settings, colIdx) {
                    return this.api().column(colIdx, { order: 'index' }).nodes().map(function(td, i) {
                        return $(td).text().trim() === 'PAYOUT' ? -1 : i;
                    });
                };
                @endif

                @if(!empty($controls))
                let pairedItemsCount = 0;
                let pairedItemsId = [];
                let pairedUsersId = [];
                let pairedUnitId = [];

                function reducePairedItemsId(id) {
                    const index = pairedItemsId.indexOf(id);
                    const pairedIdsField = document.getElementById('paired-ids');

                    if (index !== -1) {
                        pairedItemsId.splice(index, 1);
                    }

                    pairedIdsField.value = pairedItemsId.join(',');
                }

                function reducePairedUserId(id) {
                    const index = pairedUsersId.indexOf(id);
                    if (index !== -1) {
                        pairedUsersId.splice(index, 1);
                    }
                }

                function reducePairedUnitId(id) {
                    const index = pairedUnitId.indexOf(id);
                    if (index !== -1) {
                        pairedUnitId.splice(index, 1);
                    }
                }

                let selectedPair = {};

                function setMainPairItem() {
                    const userAccountsTable = document.getElementById('trading-accounts');

                    Object.entries(selectedPair).forEach(([id, data]) => {
                        Object.entries(data).forEach(([key, value]) => {
                            userAccountsTable.setAttribute(key, value);
                        });
                    });
                }

                function requestPair(itemId, event, el) {
                    event.preventDefault();
                    const closestTr = el.closest('tr');
                    const userAccountsTable = document.getElementById('trading-accounts');
                    const pairAccountsBtn = document.getElementById('pair-accounts-btn-wrapper');
                    const pairedIdsField = document.getElementById('paired-ids');
                    const userId = closestTr.getAttribute('data-user');
                    const unitId = closestTr.getAttribute('data-unit');

                    closestTr.classList.add('pair-select');
                    pairedItemsCount += 1;

                    const funderAlias = closestTr.getAttribute('data-funder-alias');

                    selectedPair[itemId] = {
                        'data-user': userId,
                        'data-unit': unitId,
                        'data-phase': closestTr.getAttribute('data-phase'),
                        'data-funder-alias': funderAlias
                    };

                    if (!userAccountsTable.classList.contains('filter-phase')) {
                        setMainPairItem();
                        hideSameUserId();
                    }

                    userAccountsTable.classList.add('filter-phase');
                    userAccountsTable.classList.add('table-pairing');

                    if (pairedItemsCount >= 2) {
                        userAccountsTable.classList.add('pair-full');
                        pairAccountsBtn.classList.remove('hidden');
                    } else {
                        userAccountsTable.classList.remove('pair-full');
                        pairAccountsBtn.classList.add('hidden');
                    }

                    pairedItemsId.push(itemId);
                    pairedUsersId.push(userId);
                    pairedUnitId.push(unitId);
                    pairedIdsField.value = pairedItemsId.join(',');
                }

                function populatePairModalField(wrapper, item, key, contentType = 'text') {
                    if (contentType === 'text') {
                        let element = wrapper.querySelector('[data-pair_val="'+ key +'"]');
                        element.textContent = item[key];
                    }

                    if (contentType === 'value') {
                        let element = wrapper.querySelector('select[data-pair_val="'+ key +'"], input[data-pair_val="'+ key +'"]');
                        element.value = item[key];
                        element.setAttribute('name', 'data['+ [item.id] +']['+ key +']');
                    }

                    if (contentType === 'class') {
                        let element = wrapper.querySelector('[data-pair_val="'+ key +'"]');
                        let packageTag = item.funder.toLowerCase() +'-'+ item[key].toLowerCase().replace(' ', '-');
                        element.setAttribute('data-package_tag', packageTag);
                        // element.classList.add(packageTag);
                    }
                }

                function populateMarketFields(wrapper, item, key, value) {
                    let orderAmountEl = wrapper.querySelector('select[data-pair_val="'+ key +'"], input[data-pair_val="'+ key +'"]');
                    orderAmountEl.value = value;
                    orderAmountEl.setAttribute('name', 'data['+ [item.id] +']['+ key +']');
                }

                function populatePairModalData(data) {
                    Object.entries(data).forEach(([itemId, item]) => {

                        const pairHeader = document.querySelector('[data-pair_item_header="'+ itemId +'"]');
                        const pairBody = document.querySelector('[data-pair_item_body="'+ itemId +'"]');

                        const funderTheme = item.funder_theme.split('|');
                        const funder = pairHeader.querySelector('[data-pair_val="funder"]');

                        funder.textContent = item.funder;
                        funder.style.cssText = 'background: '+ funderTheme[0] +'; color:'+ funderTheme[1] +';';

                        populatePairModalField(pairHeader, item, 'funder_account_id_short');
                        populatePairModalField(pairHeader, item, 'package_tag');
                        populatePairModalField(pairHeader, item, 'package_tag', 'class');
                        populatePairModalField(pairHeader, item, 'unit_name');

                        populatePairModalField(pairBody, item, 'starting_balance');
                        populatePairModalField(pairBody, item, 'starting_equity');
                        populatePairModalField(pairBody, item, 'latest_equity');
                        populatePairModalField(pairBody, item, 'pnl');
                        populatePairModalField(pairBody, item, 'rdd');
                        populatePairModalField(pairBody, item, 'symbol', 'value');
                        populatePairModalField(pairBody, item, 'unit_id', 'value');
                        populatePairModalField(pairBody, item, 'platform_type', 'value');
                        populatePairModalField(pairBody, item, 'login_username', 'value');
                        populatePairModalField(pairBody, item, 'login_password', 'value');
                        populatePairModalField(pairBody, item, 'funder_account_id_long', 'value');
                        populatePairModalField(pairBody, item, 'funder_account_id_short', 'value');
                        populatePairModalField(pairBody, item, 'funder', 'value');
                        populatePairModalField(pairBody, item, 'funder_theme', 'value');
                        populatePairModalField(pairBody, item, 'unit_name', 'value');
                        populatePairModalField(pairBody, item, 'starting_balance', 'value');
                        populatePairModalField(pairBody, item, 'starting_equity', 'value');
                        populatePairModalField(pairBody, item, 'latest_equity', 'value');
                        populatePairModalField(pairBody, item, 'rdd', 'value');
                        populatePairModalField(pairBody, item, 'phase', 'value');

                        pairBody.querySelector('[data-pair_val="purchase_type"]').setAttribute('name', 'data['+ [itemId] +'][purchase_type]');
                    });

                    Object.entries(data).forEach(([itemId, item]) => {
                        const pairBody = document.querySelector('[data-pair_item_body="'+ itemId +'"]');
                        const remainingTpHtml = pairBody.querySelector('.remaining-tp');
                        remainingTpHtml.textContent = '$'+ item.daily_target_profit.toFixed(0);

                        const remainingSlHtml = pairBody.querySelector('.remaining-sl');
                        remainingSlHtml.textContent = '$'+ item.daily_draw_down.toFixed(0);

                        let convertedTp = item.tp * item.order_amount;
                        let convertedSl = item.sl * item.order_amount;

                        const convertedTpHtml = pairBody.querySelector('.converted-tp');
                        convertedTpHtml.textContent = '$'+ convertedTp.toFixed(0);

                        const convertedSlHtml = pairBody.querySelector('.converted-sl');
                        convertedSlHtml.textContent = '$'+ convertedSl.toFixed(0);

                        populateMarketFields(pairBody, item, 'order_amount', item.order_amount);
                        populateMarketFields(pairBody, item, 'tp', item.tp);
                        populateMarketFields(pairBody, item, 'sl', item.sl);
                    });
                }

                function requestPairData(data) {
                    const loader = document.querySelector('.global-loader-wrap');
                    const pairModalBtn = document.getElementById('pair-modal-handler');

                    const pairItem1Header = document.getElementById('item-pair-1-header');
                    const pairItem1Body = document.getElementById('item-pair-1-body');
                    pairItem1Header.setAttribute('data-pair_item_header', data[0]);
                    pairItem1Body.setAttribute('data-pair_item_body', data[0]);

                    const pairItem2Header = document.getElementById('item-pair-2-header');
                    const pairItem2Body = document.getElementById('item-pair-2-body');
                    pairItem2Header.setAttribute('data-pair_item_header', data[1]);
                    pairItem2Body.setAttribute('data-pair_item_body', data[1]);

                    loader.classList.remove('hidden');
                    $.ajax({
                        url: "{{ route('trade.pair-units') }}",
                        type: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        data: JSON.stringify(data),
                        success: function(response) {
                            populatePairModalData(response);

                            pairModalBtn.click();
                            loader.classList.add('hidden');
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                        }
                    });
                }

                function hideSameUserId()
                {
                    const userAccountsTable = document.getElementById('trading-accounts');
                    const userId = userAccountsTable.getAttribute('data-user');
                    const unitId = userAccountsTable.getAttribute('data-unit');

                    userAccountsTable.querySelectorAll('tr.account-item').forEach(function(row) {
                        if (!row.classList.contains('pair-select')) {
                            const rowUserId = row.getAttribute('data-user');
                            const rowUnitId = row.getAttribute('data-unit');
                            if (rowUserId === userId || rowUnitId === unitId) {
                                row.style.display = 'none';
                            } else {
                                row.style.display = '';
                            }
                        }
                    });
                }

                function requestCancelPair(itemId, event, el) {
                    event.preventDefault();
                    const closestTr = el.closest('tr');
                    const userAccountsTable = document.getElementById('trading-accounts');
                    const pairAccountsBtn = document.getElementById('pair-accounts-btn-wrapper');
                    const userId = closestTr.getAttribute('data-user');
                    const unitId = closestTr.getAttribute('data-unit');

                    closestTr.classList.remove('pair-select');

                    pairedItemsCount -= 1;
                    reducePairedItemsId(itemId);
                    reducePairedUserId(userId);
                    reducePairedUnitId(unitId);

                    delete selectedPair[itemId];

                    setMainPairItem();

                    // userAccountsTable.setAttribute('data-user', pairedUsersId[0]);
                    // userAccountsTable.setAttribute('data-unit', pairedUnitId[0]);
                    userAccountsTable.classList.remove('pair-full');
                    pairAccountsBtn.classList.add('hidden');

                    if (pairedItemsCount < 1) {
                        userAccountsTable.classList.remove('filter-phase');
                        userAccountsTable.classList.remove('table-pairing');
                        userAccountsTable.removeAttribute('data-phase');
                        userAccountsTable.removeAttribute('data-user');
                        userAccountsTable.removeAttribute('data-unit');
                        userAccountsTable.removeAttribute('data-funder-alias');
                    } else {
                        hideSameUserId();
                    }
                }

                function resetPair()
                {
                    const pairedItems = document.querySelectorAll('.pair-select');
                    const pairedIdsField = document.getElementById('paired-ids');
                    const userAccountsTable = document.getElementById('trading-accounts');
                    const pairAccountsBtn = document.getElementById('pair-accounts-btn-wrapper');

                    selectedPair = {};

                    pairedItemsCount = 0;

                    pairedItems.forEach(function(item) {
                        item.classList.remove('pair-select');
                    });

                    userAccountsTable.classList.remove('pair-full');
                    pairAccountsBtn.classList.add('hidden');
                    pairedItemsId = [];
                    pairedUsersId = [];
                    pairedUnitId = [];
                    pairedIdsField.value = '';

                    userAccountsTable.classList.remove('filter-phase');
                    userAccountsTable.classList.remove('table-pairing');
                    userAccountsTable.removeAttribute('data-phase');
                    userAccountsTable.removeAttribute('data-user');
                    userAccountsTable.removeAttribute('data-unit');
                    userAccountsTable.removeAttribute('data-funder-alias');
                    hideSameUserId();
                }

                document.addEventListener('DOMContentLoaded', function() {

                    const form = document.getElementById('initiate_trade');

                    form.addEventListener("submit", function (event) {
                        event.preventDefault();

                        const formData = new FormData(form);
                        const loader = document.querySelector('.global-loader-wrap');

                        loader.classList.remove('hidden');

                        $.ajax({
                            url: "{{ route('trade.initiate-v2') }}",
                            type: "POST",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken,
                            },
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if(response.hasOwnProperty('error')) {
                                    loader.classList.add('hidden');
                                    const ajaxNotif = document.querySelector('.ajax-notification');
                                    ajaxNotif.innerHTML = response.message;
                                    resetPair();
                                }
                                // const items = response.html;

                                // Object.entries(items).forEach(([key, value]) => {
                                //     const itemTd = document.querySelector('tr[data-id="'+ key +'"]');
                                //     itemTd.classList.remove('pair-select');
                                //     itemTd.innerHTML = value;
                                //     resetPair();
                                //     loader.classList.add('hidden');
                                // });
                            },
                            error: function(xhr, status, error) {
                                console.error("Error:", error);
                            }
                        });
                    });
                });

                document.addEventListener('DOMContentLoaded', function() {

                    const selects = document.querySelectorAll('select.purchase-type');


                    const purchaseTypeSelects = [];

                    selects.forEach(function(select, index) {
                        purchaseTypeSelects.push(select);
                        select.addEventListener('change', function() {
                            const buyWrap = document.querySelector('.buy-wrap');
                            const sellWrap = document.querySelector('.sell-wrap');
                            let pairIndex = (index === 0)? 1 : 0;

                            if(this.value === 'sell') {
                                purchaseTypeSelects[pairIndex].value = 'buy';
                            }
                            if(this.value === 'buy') {
                                purchaseTypeSelects[pairIndex].value = 'sell';
                            }

                            buyWrap.classList.remove('buy-wrap');
                            buyWrap.classList.add('sell-wrap');
                            buyWrap.classList.add('bg-red-700');

                            sellWrap.classList.remove('sell-wrap');
                            sellWrap.classList.remove('bg-red-700');
                            sellWrap.classList.add('buy-wrap');
                        });
                    });

                    const pairablesCheckbox = document.getElementById('toggle-pairables');
                    const userAccountsTable = document.getElementById('trading-accounts');
                    const cancelPairingBtn = document.querySelectorAll('.cancel-pair-accounts-btn');
                    // const pairAccountsBtn = document.getElementById('pair-accounts-btn-wrapper');

                    pairablesCheckbox.addEventListener('change', function() {
                        if (pairablesCheckbox.checked) {
                            userAccountsTable.classList.add('show-pairables-only');
                        } else {
                            userAccountsTable.classList.remove('show-pairables-only');
                        }
                    });

                    cancelPairingBtn.forEach(element => {
                        element.addEventListener('click', function(e) {
                            e.preventDefault();
                            resetPair();
                        });
                    });
                });

                function doAutoPair(el)
                {
                    const loader = document.querySelector('.global-loader-wrap');

                    el.querySelector('span').textContent = 'Auto Pairing...';
                    el.setAttribute('disabled', 'disabled');

                    loader.classList.remove('hidden');

                    $.ajax({
                        url: "{{ route('trade.magic-pair') }}",
                        type: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        // data: JSON.stringify({'testdata': 33}),
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                        }
                    });
                }

                document.addEventListener('DOMContentLoaded', function() {
                    const requestPairBtn = document.getElementById('request-pair-data');
                    const requestPairBtnWrap = document.getElementById('pair-accounts-btn-wrapper');

                    requestPairBtn.addEventListener('click', function(e) {
                        let pairIds = document.getElementById('paired-ids');
                        pairIds = pairIds.value.split(',');
                        requestPairData(pairIds);
                        requestPairBtnWrap.classList.add('hidden');
                    });
                });
                @endif
            </script>

        </div>
    </div>
@else
    No trading accounts available.
@endif
