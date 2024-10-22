<x-app-layout>

    <div class="mt-14 overflow-hidden">

        <div class="p-6">
            <ul role="tablist" class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                @php
                    $defaultTabHtmlClass = 'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group';
                    $activeTabHtmlClass = 'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg group text-blue-500 hover:text-blue-500 dark:text-blue-500 dark:hover:text-blue-500 border-blue-500 dark:border-blue-500 bg-gray-900/80'
                @endphp
                <li class="me-2">
                    <a href="{{ route('dashboard.live-accounts') }}" id="live-accounts-tab" aria-controls="live-accounts-tab-content" aria-selected="false" class="{{ (getCurrentRoutName() === 'dashboard.live-accounts')? $activeTabHtmlClass : $defaultTabHtmlClass }}">
                        <svg class="w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 15a6 6 0 1 1 12 0 6 6 0 0 1-12 0Zm3.845-1.855a2.4 2.4 0 0 1 1.2-1.226 1 1 0 0 1 1.992-.026c.426.15.809.408 1.111.749a1 1 0 1 1-1.496 1.327.682.682 0 0 0-.36-.213.997.997 0 0 1-.113-.032.4.4 0 0 0-.394.074.93.93 0 0 0 .455.254 2.914 2.914 0 0 1 1.504.9c.373.433.669 1.092.464 1.823a.996.996 0 0 1-.046.129c-.226.519-.627.94-1.132 1.192a1 1 0 0 1-1.956.093 2.68 2.68 0 0 1-1.227-.798 1 1 0 1 1 1.506-1.315.682.682 0 0 0 .363.216c.038.009.075.02.111.032a.4.4 0 0 0 .395-.074.93.93 0 0 0-.455-.254 2.91 2.91 0 0 1-1.503-.9c-.375-.433-.666-1.089-.466-1.817a.994.994 0 0 1 .047-.134Zm1.884.573.003.008c-.003-.005-.003-.008-.003-.008Zm.55 2.613s-.002-.002-.003-.007a.032.032 0 0 1 .003.007ZM4 14a1 1 0 0 1 1 1v4a1 1 0 1 1-2 0v-4a1 1 0 0 1 1-1Zm3-2a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1Zm6.5-8a1 1 0 0 1 1-1H18a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-.796l-2.341 2.049a1 1 0 0 1-1.24.06l-2.894-2.066L6.614 9.29a1 1 0 1 1-1.228-1.578l4.5-3.5a1 1 0 0 1 1.195-.025l2.856 2.04L15.34 5h-.84a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('Live Trading Accounts') }}
                    </a>
                </li>
                <li class="me-2">
                    <a href="{{ route('dashboard.audition-accounts') }}" id="audition-accounts-tab" aria-controls="audition-accounts-tab-content" aria-selected="false" class="{{ (getCurrentRoutName() === 'dashboard.audition-accounts')? $activeTabHtmlClass : $defaultTabHtmlClass }}">
                        <svg class="w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v15a1 1 0 0 0 1 1h15M8 16l2.5-5.5 3 3L17.273 7 20 9.667"/>
                        </svg>

                        {{ __('Trading Auditions') }}
                    </a>
                </li>
            </ul>
        </div>


        <div class="gap-5 dark:text-gray-100 grid grid-cols-1 lg:grid lg:grid-cols-3 md:grid-cols-2 p-6 pt-0 text-gray-900 xl:grid-cols-4">
            <div class="flex items-center text-center block max-w-sm p-6 border border-gray-200 rounded-lg shadow dark:border-gray-700 dark:bg-gray-900/30">
                <img src="/images/daily-profit.png" class="w-14 inline-block" style="width: 40px; height: 40px;">
                <div class="pl-3 text-left w-full">
                    @if($totalDailyProfit > 0)
                        <h2 class="font-bold text-2xl text-green-500">+$<span class="number" data-end="{{ $totalDailyProfit }}" data-decimals="2">0</span></h2>
                    @else
                        <h2 class="font-bold text-2xl text-white">0.00</h2>
                    @endif

                    <h5 class="dark:text-white mb-2 text-gray-900 text-left text-sm">
                        <span>Daily Profit</span>
    {{--                    <span class="text-green-500">--}}
    {{--                        4%--}}
    {{--                        <svg class="w-5 h-5 text-green-500 inline-block" style="margin-top: -4px;margin-left: -5px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">--}}
    {{--                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4"/>--}}
    {{--                        </svg>--}}
    {{--                    </span>--}}
                    </h5>
                </div>
            </div>
            <div class="flex items-center text-center block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-900/60 dark:border-gray-700">
                <img src="/images/weekly-profit.png" class="w-14 inline-block" style="width: 40px; height: 40px;">
                <div class="pl-3 text-left w-full">
                    @if($totalWeeklyProfit > 0)
                        <h2 class="font-bold text-2xl text-green-500">+$<span class="number" data-end="{{ $totalWeeklyProfit }}" data-decimals="2">0</span></h2>
                    @else
                        <h2 class="font-bold text-2xl text-white">0.00</h2>
                    @endif
                    <h5 class="dark:text-white mb-2 text-gray-900 text-left text-sm">
                        <span>Weekly Profit</span>
    {{--                    <span class="text-green-500">--}}
    {{--                        4%--}}
    {{--                        <svg class="w-5 h-5 text-green-500 inline-block" style="margin-top: -4px;margin-left: -5px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">--}}
    {{--                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4"/>--}}
    {{--                        </svg>--}}
    {{--                    </span>--}}
                    </h5>
                </div>
            </div>
            <div class="flex items-center block max-w-sm p-6 shining-gold-bg border border-gray-200 rounded-lg shadow dark:border-gray-700 dark:bg-gray-900/30">
                <img src="/images/investment.png" class="w-14 inline-block" style="width: 40px; height: 40px;">
                <div class="pl-3 text-left w-full">
                    @if($finalTotalProfit > 0)
                        <h2 class="font-bold text-3xl text-green-500">+$<span class="number" data-end="{{ $finalTotalProfit }}" data-decimals="2">0</span></h2>
                    @else
                        <h2 class="font-bold text-3xl text-white">0.00</h2>
                    @endif
                    <h5 class="dark:text-white mb-2 text-gray-900 text-left text-sm">
                        <span>Monthly Profit</span>
    {{--                    <span class="text-green-500">--}}
    {{--                        4%--}}
    {{--                        <svg class="w-5 h-5 text-green-500 inline-block" style="margin-top: -4px;margin-left: -5px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">--}}
    {{--                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4"/>--}}
    {{--                        </svg>--}}
    {{--                    </span>--}}
                    </h5>
                </div>
            </div>
            <div class="flex items-center block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:bg-gray-900/60">
                <img src="/images/trades.png" class="w-14 inline-block" style="width: 40px; height: 40px;">
                <div class="pl-3 text-left w-full">
                    @if($tradeCount > 0)
                        <h2 class="font-bold text-3xl text-green-500">{{ $tradeCount }}</h2>
                    @else
                        <h2 class="font-bold text-3xl text-white">0.00</h2>
                    @endif
                    <h5 class="dark:text-white mb-2 text-gray-900 text-left text-sm"">
                        <span>Monthly Number of Trades</span>
                    </h5>
                </div>
            </div>
        </div>


        <div class="p-6">
            <ul role="tablist" class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                <li class="me-2">
                    <a href="#" id="ongoing-trades-tab" aria-controls="ongoing-trades-tab-content" aria-selected="true" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                        <svg class="w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207"/>
                        </svg>
                        {{ __('Ongoing Trades') }}
                    </a>
                </li>
                <li class="me-2">
                    <a href="#" id="recent-trades-tab" aria-controls="recent-trades-tab-content" aria-selected="false" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                        <svg class="w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>

                        {{ __('Recent Trade History') }}
                    </a>
                </li>
                <li class="me-2 {{ (getCurrentRoutName() !== 'dashboard.live-accounts')? 'hidden' : '' }}">
                    <a href="#" id="recent-payout-tab" aria-controls="recent-payout-tab-content" aria-selected="false" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                        <svg class="w-w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 12A2.5 2.5 0 0 1 21 9.5V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v2.5a2.5 2.5 0 0 1 0 5V17a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                        </svg>

                        {{ __('Recent Payout Requests') }}
                    </a>
                </li>
            </ul>
        </div>



        <div id="accountsPairingTabContent">
            <div class="hidden"
                 id="ongoing-trades-tab-content"
                 role="tabpanel"
                 aria-labelledby="ongoing-trades-tab"
            >
                <div class="overflow-hidden">
                    <div class="dark:text-gray-100 p-6 pt-0 text-gray-900">
                        @include('dashboard.trade.history.ongoing-trades')
                    </div>
                </div>
            </div>
            <div class="hidden"
                 id="recent-trades-tab-content"
                 role="tabpanel"
                 aria-labelledby="recent-trades-tab"
            >
                <div class="overflow-hidden">
                    <div class="dark:text-gray-100 p-6 pt-0 text-gray-900">
                        @include('dashboard.trade.history.recent-trades')
                    </div>
                </div>
            </div>
            <div class="hidden"
                 id="recent-payout-tab-content"
                 role="tabpanel"
                 aria-labelledby="recent-payout-tab"
             >
                @if(getCurrentRoutName() === 'dashboard.live-accounts')
                    <div class="overflow-hidden">
                        <div class="dark:text-gray-100 p-6 pt-0 text-gray-900">
                            @include('dashboard.trade.history.recent-payout-requests', ['items' => $forPayouts])
                        </div>
                    </div>
                @endif
            </div>
        </div>




    </div>

    <script>
        function animateNumber(element, start, end, duration, decimals) {
            let startTime = null;

            function animationStep(timestamp) {
                if (!startTime) startTime = timestamp;
                const elapsedTime = timestamp - startTime;

                const progress = Math.min(elapsedTime / duration, 1); // Cap the progress at 1 (100%)
                const currentNumber = (progress * (end - start) + start).toFixed(decimals);

                element.textContent = parseFloat(currentNumber).toLocaleString(undefined, {
                    minimumFractionDigits: decimals,
                    maximumFractionDigits: decimals
                }); // Adds commas and maintains decimal places

                if (progress < 1) {
                    requestAnimationFrame(animationStep); // Continue the animation
                } else {
                    element.style.opacity = 1; // Show the element at the end of the animation
                }
            }

            requestAnimationFrame(animationStep); // Start the animation
        }

        // Select all elements with the class "number"
        const numberElements = document.querySelectorAll('.number');

        // Iterate over each element and animate the number
        numberElements.forEach(element => {
            const endValue = parseFloat(element.getAttribute('data-end')); // Get the end number from the data attribute
            const decimals = parseInt(element.getAttribute('data-decimals')) || 0; // Get decimal places from attribute or default to 0
            animateNumber(element, 0, endValue, 1500, decimals); // Animate from 0 to the end value with decimals
        });

        document.addEventListener('DOMContentLoaded', function() {
            const tabsElement = document.getElementById('pairing-tabs');

            const tabElements = [
                {
                    id: 'ongoing-trades',
                    triggerEl: document.querySelector('#ongoing-trades-tab'),
                    targetEl: document.querySelector('#ongoing-trades-tab-content'),
                },
                {
                    id: 'recent-trades',
                    triggerEl: document.querySelector('#recent-trades-tab'),
                    targetEl: document.querySelector('#recent-trades-tab-content'),
                },
                {
                    id: 'recent-payout',
                    triggerEl: document.querySelector('#recent-payout-tab'),
                    targetEl: document.querySelector('#recent-payout-tab-content'),
                }
            ];

            const options = {
                defaultTabId: 'ongoing-trades',
                activeClasses:
                    'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-400 border-blue-600 dark:border-blue-500 bg-gray-900/80',
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
    </script>

</x-app-layout>
