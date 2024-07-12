<x-app-layout>

    <div class="p-6 mt-14">

        <div class="shadow-sm">
            <div class="text-gray-900 dark:text-gray-100">
                {{ __('Unit Settings') }}
            </div>

            @include('components.dashboard-notification')

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mt-4">
                <div class="max-w-xl">

                    @include('dashboard.trading-units.settings.unit-login', $settings)

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
