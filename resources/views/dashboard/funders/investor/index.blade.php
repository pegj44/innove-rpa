<x-app-layout>

    <div class="p-6 mt-14">

        <div class="shadow-sm">
            <div class="text-gray-900 dark:text-gray-100 mb-4">

                @if(empty($funders))
                    <div class="text-gray-900 dark:text-gray-100 mb-4">
                        <h3 class="mb-5">No funders added yet.</h3>
                    </div>
                @else

                    <h3 class="mb-5">{{ __('Your Funders') }}</h3>

                    @include('components.dashboard-notification')
                    @include('dashboard.funders.investor.list', ['funders' => $funders])

                @endif
            </div>
        </div>
    </div>

</x-app-layout>
