
<div class="">

    @php
        $waitingPairedItems = [];
        $tradedItems = [];
        $tradesHandler = [];
        //$pairedItemsHandler = [];
    @endphp

{{--    @if(!empty($tradingItems))--}}
{{--        @foreach($tradingItems as $index => $item)--}}
{{--            @foreach($item['data'] as $itemId => $itemData)--}}
{{--                @php--}}
{{--                    $itemFunder = str_replace(' ', '_', $itemData['funder']);--}}
{{--                    $pairedItemsHandler[] = strtolower($itemFunder) .'_'. $itemData['unit_id'];--}}
{{--                @endphp--}}
{{--            @endforeach--}}
{{--        @endforeach--}}
{{--    @endif--}}

    <div class="mb-6">
        <ul id="pairing-tabs" role="tablist" class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
            <li class="me-2">
                <a href="#" id="funder-accounts-tab" aria-controls="funder-accounts-tab-content" aria-selected="false" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                    <svg class="w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M7 2a2 2 0 0 0-2 2v1a1 1 0 0 0 0 2v1a1 1 0 0 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H7Zm3 8a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm-1 7a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3 1 1 0 0 1-1 1h-6a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('Trading Accounts') }}
                </a>
            </li>
            <li class="me-2">
                <a href="#" id="traded-accounts-tab" aria-controls="traded-accounts-tab-content" aria-selected="false" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                    <svg class="w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M9 15a6 6 0 1 1 12 0 6 6 0 0 1-12 0Zm3.845-1.855a2.4 2.4 0 0 1 1.2-1.226 1 1 0 0 1 1.992-.026c.426.15.809.408 1.111.749a1 1 0 1 1-1.496 1.327.682.682 0 0 0-.36-.213.997.997 0 0 1-.113-.032.4.4 0 0 0-.394.074.93.93 0 0 0 .455.254 2.914 2.914 0 0 1 1.504.9c.373.433.669 1.092.464 1.823a.996.996 0 0 1-.046.129c-.226.519-.627.94-1.132 1.192a1 1 0 0 1-1.956.093 2.68 2.68 0 0 1-1.227-.798 1 1 0 1 1 1.506-1.315.682.682 0 0 0 .363.216c.038.009.075.02.111.032a.4.4 0 0 0 .395-.074.93.93 0 0 0-.455-.254 2.91 2.91 0 0 1-1.503-.9c-.375-.433-.666-1.089-.466-1.817a.994.994 0 0 1 .047-.134Zm1.884.573.003.008c-.003-.005-.003-.008-.003-.008Zm.55 2.613s-.002-.002-.003-.007a.032.032 0 0 1 .003.007ZM4 14a1 1 0 0 1 1 1v4a1 1 0 1 1-2 0v-4a1 1 0 0 1 1-1Zm3-2a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1Zm6.5-8a1 1 0 0 1 1-1H18a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-.796l-2.341 2.049a1 1 0 0 1-1.24.06l-2.894-2.066L6.614 9.29a1 1 0 1 1-1.228-1.578l4.5-3.5a1 1 0 0 1 1.195-.025l2.856 2.04L15.34 5h-.84a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                    </svg>

                    {{ __('Ongoing Trades') }}
                    @if(!empty($tradingItems))
                        <span class="bg-red-600 inline-block ml-2 rounded-full text-sm text-white" style="min-width: 20px;font-size: 11px;">
                            {{ count($tradingItems) }}
                        </span>
                    @endif
                </a>
            </li>
            <li class="me-2">
                <a href="#" id="pairing-accounts-tab" aria-controls="pairing-accounts-tab-content" aria-selected="false" class="inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group" aria-current="page">
                    <svg class="w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 4v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2m6-16v2m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v10m6-16v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2"/>
                    </svg>
                    {{ __('Paired Accounts') }}
                    <span class="paired-count bg-red-600 inline-block ml-2 rounded-full text-sm text-white {{ ((empty($pairedItems))? 'hidden' : '') }}" style="min-width: 20px;font-size: 11px;">
                        {{ count($pairedItems) }}
                    </span>
                </a>
            </li>
        </ul>
    </div>
    <div id="accountsPairingTabContent">
        <div class="hidden"
             id="funder-accounts-tab-content"
             role="tabpanel"
             aria-labelledby="funder-accounts-tab"
        >
            @include('dashboard.trade.report.list', ['controls' => true])
        </div>
        <div class="hidden"
             id="traded-accounts-tab-content"
             role="tabpanel"
             aria-labelledby="traded-accounts-tab"
        >
            @include('dashboard.trade.play.trading-items', ['controls' => true])
        </div>

        <div class="hidden"
             id="pairing-accounts-tab-content"
             role="tabpanel"
             aria-labelledby="pairing-accounts-tab"
        >
            @include('dashboard.trade.play.paired-items')
        </div>
    </div>
</div>


<script>

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

    document.addEventListener('DOMContentLoaded', function() {
        const tabsElement = document.getElementById('pairing-tabs');

        const tabElements = [
            {
                id: 'funder-accounts',
                triggerEl: document.querySelector('#funder-accounts-tab'),
                targetEl: document.querySelector('#funder-accounts-tab-content'),
            },
            {
                id: 'traded-accounts',
                triggerEl: document.querySelector('#traded-accounts-tab'),
                targetEl: document.querySelector('#traded-accounts-tab-content'),
            },
            {
                id: 'pairing-accounts',
                triggerEl: document.querySelector('#pairing-accounts-tab'),
                targetEl: document.querySelector('#pairing-accounts-tab-content'),
            }
        ];

        const options = {
            defaultTabId: 'funder-accounts',
            activeClasses:
                'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-400 border-blue-600 dark:border-blue-500',
            inactiveClasses:
                'text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300',
            onShow: () => {
            },
        };

        const instanceOptions = {
            id: 'pairing-tabs',
            override: true
        };

        const tabs = new Tabs(tabsElement, tabElements, options, instanceOptions);
    });

    function initializePurchaseTypeSwitch()
    {
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
    }

    initializePurchaseTypeSwitch();

    function cancelPairing(event, id)
    {
        event.preventDefault();

        let ajaxUrl = "{{ route('trade.remove-pair', 'pair_item_id') }}";

        const loader = document.querySelector('.global-loader-wrap');
        loader.classList.remove('hidden');

        $.ajax({
            url: ajaxUrl.replace('pair_item_id', id),
            type: "DELETE",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                type: 'cancel'
            },
            success: function(response) {

            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }

    document.addEventListener('pusherWebPush', function(event) {
        if(event.detail.action === 'cancel-pairing') {
            $.ajax({
                url: "{{ route('trade.reports') }}",
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                data: {
                    ids: event.detail.arguments.ids
                },
                success: function(response) {

                    const pairWrap = document.getElementById("pairing-accounts-tab-content");
                    const pairGroup = document.querySelectorAll('[data-queue_group_id="'+ event.detail.arguments.id +'"]');
                    const pairCount = document.querySelector('.paired-count');
                    const loader = document.querySelector('.global-loader-wrap');

                    pairGroup.forEach(function(item) {
                        item.remove();
                    });

                    const queueItems = document.querySelectorAll('h2[data-queueitemid]');

                    if(queueItems.length < 1) {
                        const noPairNotice = document.createElement("p");
                        pairCount.innerHTML = '';
                        noPairNotice.id = 'no-paired-items';
                        noPairNotice.textContent = 'No paired items.';
                        pairWrap.appendChild(noPairNotice);
                    } else {
                        pairCount.innerHTML = queueItems.length;
                    }

                    const htmlList = response.list;

                    Object.entries(htmlList).forEach(([key, value]) => {
                        const itemTd = document.querySelector('tr[data-id="'+ key +'"]');
                        itemTd.classList.remove('pair-select');
                        itemTd.innerHTML = value;
                        resetPair();
                    });

                    loader.classList.add('hidden');
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });

        }
    });

    document.addEventListener('pusherWebPush', function(event) {
        if(event.detail.action === 'pair-units') {

            $.ajax({
                url: "{{ route('trade.reports') }}",
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                data: {
                    ids: event.detail.arguments.ids
                },
                success: function(response) {
                    const loader = document.querySelector('.global-loader-wrap');
                    const pairedItemsCounter = document.querySelector('.paired-count');

                    const htmlList = response.list;

                    Object.entries(htmlList).forEach(([key, value]) => {
                        const itemTd = document.querySelector('tr[data-id="'+ key +'"]');
                        itemTd.classList.remove('pair-select');
                        itemTd.innerHTML = value;
                        resetPair();
                    });

                    pairedItemsCounter.innerHTML = response.pairedItems.length;
                    pairedItemsCounter.classList.remove('hidden');

                    const pairedItemsHtml = response.pairedItems;
                    let paredItemsWrap = document.getElementById('accordion-pairing-items');

                    if(!paredItemsWrap) {
                        paredItemsWrap = document.getElementById("pairing-accounts-tab-content");
                    }

                    paredItemsWrap.innerHTML = '';

                    const accordionItems = [];

                    Object.entries(pairedItemsHtml).forEach(([key, value]) => {
                        paredItemsWrap.insertAdjacentHTML("beforeend", value);

                        accordionItems.push({
                            id: 'accordion-paired-collapse-heading-'+ key,
                            triggerEl: document.querySelector('#accordion-paired-collapse-heading-'+ key),
                            targetEl: document.querySelector('#accordion-paired-collapse-body-'+ key),
                            active: false
                        });
                    });

                    const options = {
                        alwaysOpen: false
                    };

                    const instanceOptions = {
                        id: 'accordion-pairing-items',
                        override: true
                    };

                    const accordion = new Accordion(paredItemsWrap, accordionItems, options, instanceOptions);

                    loader.classList.add('hidden');

                    initializePurchaseTypeSwitch();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });

        }
    });

</script>
