<x-app-layout>

    <div class="p-6 mt-14">

        <div class="shadow-sm">
            <div class="text-gray-900 dark:text-gray-100 mb-4">

                @if(empty($items))
                    <div class="text-gray-900 dark:text-gray-100 mb-4">
                        <h3 class="mb-5">No user accounts added yet.</h3>
                    </div>
                @else
                    @include('dashboard.trading-individual.investor.list', ['items' => $items])
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
