@if(!empty($tradingAccounts))


    <label class="inline-flex items-center cursor-pointer" x-data="">
        <input id="toggle-pairables" type="checkbox" value="" class="sr-only peer">
        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Show only pairable items</span>
    </label>

    <div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table id="trading-accounts" x-data="" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3"></th>
                <th scope="col" class="px-6 py-3">
                    {{ __('Account') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('Phase') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('Status') }}
                </th>
                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                    {{ __('Latest Equity') }}
                </th>
{{--                <th scope="col" class="px-6 py-3">--}}
{{--                    {{ __('RDD') }}--}}
{{--                </th>--}}
{{--                <th scope="col" class="px-6 py-3">--}}
{{--                    {{ __('Consistency') }}--}}
{{--                </th>--}}
                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                    {{ __('Daily P&L') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('Unit') }}
                </th>
                <th scope="col" class="px-6 py-3"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($tradingAccounts as $item)
                @php
                    //$reportInfo = getTradeReportCalculations($item);

                    switch ($item['status']) {
                        case 'pairing':
                            $trHtmlClass = 'bg-purple-700';
                            break;
                        case 'trading':
                            $trHtmlClass = 'bg-blue-500';
                            break;
                        case 'abstained':
                            $trHtmlClass = 'bg-gray-700';
                            break;
                        case 'breached':
                            $trHtmlClass = 'bg-red-500';
                        break;
                        case 'onhold':
                            $trHtmlClass = 'bg-orange-400';
                        break;
                        default:
                            $trHtmlClass = '';
                            break;
                    }
                @endphp

                <tr class="account-item border-b border-gray-700 bg-gray-800 hover:bg-gray-600 {{ ($item['status'] === 'idle')? 'item-pairable' : 'item-not-pairable' }}" data-phase="{{ $item['trading_account_credential']['current_phase'] }}" data-user="{{ $item['trading_account_credential']['funder']['alias'] }}{{ $item['trading_account_credential']['user_account']['id'] }}" data-unit="{{ $item['trading_account_credential']['funder']['alias'] }}{{ $item['trading_account_credential']['user_account']['trading_unit']['id'] }}">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if($item['status'] === 'idle')
                            <a href="#" x-on:click="requestPair({{$item['id']}}, event, $event.target)" class="pair-item-btn font-medium text-blue-600 dark:text-blue-50">
                                <svg class="w-[20px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 10 3-3m0 0-3-3m3 3H5v3m3 4-3 3m0 0 3 3m-3-3h14v-3"/>
                                </svg>
                            </a>
                            <a href="#" x-on:click="requestCancelPair({{$item['id']}}, event, $event.target)" class="cancel-pair-item-btn font-medium text-blue-600 dark:text-blue-50">
                                <svg class="w-[20px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                                </svg>
                            </a>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <span class="bg-gray-500 border-blue-400 px-2 py-1 rounded">{{ $item['trading_account_credential']['user_account']['id'] }}</span>
                        <span class="bg-gray-900 border border-gray-700 px-2 py-1 rounded"> {{ $item['trading_account_credential']['funder']['alias'] }}</span> {{ $item['trading_account_credential']['funder_account_id'] }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ getPhaseName($item['trading_account_credential']['current_phase']) }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <span class="{{ $trHtmlClass }} px-2 py-1 rounded">{{ \App\Http\Controllers\TradeReportController::$statuses[$item['status']] }}</span>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ number_format($item['latest_equity'], 2) }}
                    </td>
{{--                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">--}}

{{--                    </td>--}}
{{--                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">--}}

{{--                    </td>--}}
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {!! getPnLHtml($item) !!}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $item['trading_account_credential']['user_account']['trading_unit']['name'] }}
                    </td>
                    <td class="px-6 py-4 text-right border-r border-gray-600">
                        <a href="{{ route('trade.report.edit', $item['id']) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            <svg class="w-[20px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>

        <div id="pair-accounts-btn-wrapper" class="hidden do-pair-btn flex rounded items-center shadow-lg">
            <form id="do-pair-accounts" method="post" action="{{ route('trade.pair-manual') }}">
                @csrf
                <button class="font-medium inline-flex items-center px-3 py-3 rounded-md text-center text-sm text-white" type="submit">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M14.516 6.743c-.41-.368-.443-1-.077-1.41a.99.99 0 0 1 1.405-.078l5.487 4.948.007.006A2.047 2.047 0 0 1 22 11.721a2.06 2.06 0 0 1-.662 1.51l-5.584 5.09a.99.99 0 0 1-1.404-.07 1.003 1.003 0 0 1 .068-1.412l5.578-5.082a.05.05 0 0 0 .015-.036.051.051 0 0 0-.015-.036l-5.48-4.942Zm-6.543 9.199v-.42a4.168 4.168 0 0 0-2.715 2.415c-.154.382-.44.695-.806.88a1.683 1.683 0 0 1-2.167-.571 1.705 1.705 0 0 1-.279-1.092V15.88c0-3.77 2.526-7.039 5.967-7.573V7.57a1.957 1.957 0 0 1 .993-1.838 1.931 1.931 0 0 1 2.153.184l5.08 4.248a.646.646 0 0 1 .012.011l.011.01a2.098 2.098 0 0 1 .703 1.57 2.108 2.108 0 0 1-.726 1.59l-5.08 4.25a1.933 1.933 0 0 1-2.929-.614 1.957 1.957 0 0 1-.217-1.04Z" clip-rule="evenodd"/>
                    </svg>
                    Pair Accounts
                </button>
                <input type="hidden" name="paired-ids" id="paired-ids" value="">
            </form>
            <a href="#" id="cancel-pair-accounts-btn" class="border-gray-900 border-l px-1">
                <svg class="w-5 h-5 text-gray-800 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
            </a>
        </div>
    </div>

<script>

    jQuery('#trading-accounts').DataTable( {
        paging: false,
        info: false,
        searching: false,
        columnDefs: [
            {
                orderable: false,
                targets: [0, 1, 2, 3, 6, 7]
            }
        ]
    });

    let pairedItemsCount = 0;
    let pairedItemsId = [];
    let pairedUsersId = [];
    let pairedUnitId = [];

    document.addEventListener('DOMContentLoaded', function() {
        const pairablesCheckbox = document.getElementById('toggle-pairables');
        const userAccountsTable = document.getElementById('trading-accounts');
        const cancelPairingBtn = document.getElementById('cancel-pair-accounts-btn');
        const pairAccountsBtn = document.getElementById('pair-accounts-btn-wrapper');

        pairablesCheckbox.addEventListener('change', function() {
            if (pairablesCheckbox.checked) {
                userAccountsTable.classList.add('show-pairables-only');
            } else {
                userAccountsTable.classList.remove('show-pairables-only');
            }
        });

        cancelPairingBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const pairedItems = document.querySelectorAll('.pair-select');
            const pairedIdsField = document.getElementById('paired-ids');

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
            userAccountsTable.removeAttribute('data-phase');
            userAccountsTable.removeAttribute('data-user');
            userAccountsTable.removeAttribute('data-unit');
            hideSameUserId();
        });
    });

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

        if (!userAccountsTable.classList.contains('filter-phase')) {
            userAccountsTable.setAttribute('data-user', userId);
            userAccountsTable.setAttribute('data-unit', unitId);
            hideSameUserId();
        }

        userAccountsTable.classList.add('filter-phase');
        userAccountsTable.setAttribute('data-phase', closestTr.getAttribute('data-phase'));

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

        userAccountsTable.setAttribute('data-user', pairedUsersId[0]);
        userAccountsTable.setAttribute('data-unit', pairedUnitId[0]);
        userAccountsTable.classList.remove('pair-full');
        pairAccountsBtn.classList.add('hidden');

        hideSameUserId();

        if (pairedItemsCount < 1) {
            userAccountsTable.classList.remove('filter-phase');
            userAccountsTable.removeAttribute('data-phase');
            userAccountsTable.removeAttribute('data-user');
            userAccountsTable.removeAttribute('data-unit');
        }
    }

</script>
@else
    No trading accounts available.
@endif
