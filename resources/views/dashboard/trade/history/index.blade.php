<x-app-layout>

    <div class="p-6 mt-14">

        <div class="shadow-sm">
            <div class="text-gray-900 dark:text-gray-100 mb-4">
                @php
                    $userData = session('api_user_data');
                @endphp
                @include('components.dashboard-notification')
                @include('dashboard.trade.history.list', ['controls' => ($userData['isOwner'] || in_array('manage all', $userData['permissions']))])
            </div>
        </div>
    </div>

</x-app-layout>
