<x-app-layout>

    <div class="p-6 mt-14">

        <div class="shadow-sm">
            <div class="text-gray-900 dark:text-gray-100 mb-4">

{{--                <h3 class="mb-3">{{ __('Make Money') }}</h3>--}}

                @include('components.dashboard-notification')

                @include('dashboard.trade.play.pairing')

            </div>
        </div>
    </div>

</x-app-layout>
