
{{--<div class="flex items-center">--}}
{{--    <form method="POST" id="pair-accounts" action="{{ route('trade.pair') }}" class="mr-5">--}}
{{--        @csrf--}}
{{--        <button type="submit" class="px-5 py-3 text-base font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">--}}
{{--            <svg class="w-[28px] h-[28px] mr-1 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">--}}
{{--                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 10 3-3m0 0-3-3m3 3H5v3m3 4-3 3m0 0 3 3m-3-3h14v-3"/>--}}
{{--            </svg>--}}
{{--            Pair Accounts--}}
{{--        </button>--}}
{{--        <div class="mt-2 text-sm text-red-600 pairing-error"></div>--}}
{{--    </form>--}}
{{--    @if(!empty($pairedItems))--}}
{{--        <form method="POST" action="{{ route('trade.pair.clear') }}">--}}
{{--            @csrf--}}
{{--            @method('DELETE')--}}
{{--            <button type="submit" class="text-blue-500">Clear</button>--}}
{{--        </form>--}}
{{--    @endif--}}
{{--</div>--}}

<div class="">

    @if(!empty($pairedItems))
        @php
            $waitingPairedItems = [];
            $tradedItems = [];
        @endphp
        @foreach($pairedItems as $index => $item)
            @php
                if (empty($item['trade_report_pair1']) || empty($item['trade_report_pair2'])) {
                    continue;
                }

                $pair1 = $item['trade_report_pair1'];
                $pair2 = $item['trade_report_pair2'];

                $reportInfo = [
                    'pair1' => getTradeReportCalculations($pair1),
                    'pair2' => getTradeReportCalculations($pair2)
                ];

                $pair1FunderMetadata = [];
                foreach($pair1['trading_account_credential']['funder']['metadata'] as $funderMeta1) {
                    $pair1FunderMetadata[$funderMeta1['key']] = $funderMeta1['value'];
                }

                $pair2FunderMetadata = [];
                foreach($pair2['trading_account_credential']['funder']['metadata'] as $funderMeta2) {
                    $pair2FunderMetadata[$funderMeta2['key']] = $funderMeta2['value'];
                }

                if ($item['status'] === 'pairing') {
                    $waitingPairedItems[$item['id']] = [
                        'pair1' => $pair1,
                        'pair2' => $pair2,
                        'pair1FunderMetadata' => $pair1FunderMetadata,
                        'pair2FunderMetadata' => $pair2FunderMetadata
                    ];
                }

                if ($item['status'] === 'trading') {
                    $tradedItems[$item['id']] = [
                        'pair1' => $pair1,
                        'pair2' => $pair2,
                        'pair1FunderMetadata' => $pair1FunderMetadata,
                        'pair2FunderMetadata' => $pair2FunderMetadata
                    ];
                }
            @endphp
        @endforeach
    @endif

    <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
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
                    @if(!empty($tradedItems))
                        <span class="bg-red-600 inline-block ml-2 rounded-full text-sm text-white" style="min-width: 20px;font-size: 11px;">
                            {{ count($tradedItems) }}
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
                    @if(!empty($waitingPairedItems))
                        <span class="bg-red-600 inline-block ml-2 rounded-full text-sm text-white" style="min-width: 20px;font-size: 11px;">
                            {{ count($waitingPairedItems) }}
                        </span>
                    @endif
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
            @include('dashboard.trade.report.list')
        </div>
        <div class="hidden"
             id="traded-accounts-tab-content"
             role="tabpanel"
             aria-labelledby="traded-accounts-tab"
        >
            @include('dashboard.trade.play.trading-items')
        </div>

        <div class="hidden"
             id="pairing-accounts-tab-content"
             role="tabpanel"
             aria-labelledby="pairing-accounts-tab"

            @include('dashboard.trade.play.paired-items')
        </div>
    </div>
</div>


<script>

    {{--const form = document.getElementById('pair-accounts');--}}
    {{--const submitButton = form.querySelector('button[type="submit"]');--}}

    {{--form.addEventListener('submit', function(event) {--}}
    {{--    event.preventDefault();--}}

    {{--    // Disable the submit button and add the class--}}
    {{--    submitButton.disabled = true;--}}
    {{--    submitButton.classList.add('dark:bg-gray-700', 'bg-gray-700');--}}

    {{--    const formData = new FormData(form);--}}

    {{--    fetch('{{ route('trade.pair') }}', {--}}
    {{--        method: 'POST',--}}
    {{--        body: formData--}}
    {{--    })--}}
    {{--        .then(response => {--}}
    {{--            if (response.ok) {--}}
    {{--                return response.json();--}}
    {{--            } else {--}}
    {{--                throw new Error('Request failed with status code ' + response.status);--}}
    {{--            }--}}
    {{--        })--}}
    {{--        .then(data => {--}}
    {{--            if (!data.success) {--}}
    {{--                form.querySelector('.pairing-error').textContent = data.error;--}}
    {{--            }--}}
    {{--            if (data.accounts.data.length > 0) {--}}
    {{--                location.reload();--}}
    {{--            } else {--}}
    {{--                form.querySelector('.pairing-error').textContent = data.accounts.message;--}}
    {{--            }--}}
    {{--        })--}}
    {{--        .catch(error => {--}}
    {{--            console.error(error);--}}
    {{--            submitButton.disabled = false;--}}
    {{--            submitButton.classList.remove('dark:bg-gray-700', 'bg-gray-700');--}}
    {{--        });--}}
    {{--});--}}

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


    // document.addEventListener('pusherNotificationEvent', function(event) {
    //     console.log('event triggered: ', event.detail);
    //
    //     if(event.detail.action === 'no-pairable-accounts') {
    //         form.querySelector('.pairing-error').textContent = 'No pairs found.';
    //         submitButton.disabled = false;
    //         submitButton.classList.remove('dark:bg-gray-700', 'bg-gray-700');
    //     }
    //
    //     if(event.detail.action === 'pair_accounts-success') {
    //         location.reload();
    //     }
    // });

    //
    // document.addEventListener('DOMContentLoaded', function() {
    //     // Select all .update-trade-report-settings forms
    //     const forms = document.querySelectorAll('.update-trade-report-settings');
    //
    //     forms.forEach(form => {
    //         // Select the purchase-type select element within each form
    //         const select = form.querySelector('.purchase-type');
    //
    //         // Add change event listener to the select element
    //         select.addEventListener('change', function() {
    //             form.submit();
    //         });
    //     });
    // });

</script>
