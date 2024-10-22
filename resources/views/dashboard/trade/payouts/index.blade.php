<x-app-layout>

    <div class="p-6 mt-14">

        <div class="shadow-sm">
            <div class="text-gray-900 dark:text-gray-100 mb-4">

                @if(empty($items))
                    <div class="text-gray-900 dark:text-gray-100 mb-4">
                        <h3 class="mb-5">{{ __("You have no requested payouts yet. Click ") }} <a href="{{ route('trade.payouts.create') }}" class="text-blue-500">{{ __('HERE') }}</a> {{ __('to add a one.') }}</h3>
                    </div>
                @else

                    @include('components.dashboard-notification')

                    <a href="{{ route('trade.payouts.create') }}" class="mb-1 mt-2 px-3 py-2 text-sm font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-[18px] h-[18px] text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"></path>
                        </svg>

                        {{ __('Add Item') }}
                    </a>

                    @include('dashboard.trade.payouts.list', ['controls' => true])

                @endif
            </div>
        </div>
    </div>

</x-app-layout>
