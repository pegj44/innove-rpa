<x-app-layout>

    <div class="p-6 mt-14">

        <div class="shadow-sm">
            <div class="text-gray-900 dark:text-gray-100 mb-4">

                <h3 class="mb-5">{{ __("Add New Funder") }}</h3>

                @include('components.dashboard-notification')

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mt-4 max-w-[640px]">
                    <div class="max-w-xl">
                        <section>
                            {!! form($form) !!}
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const webAutomations = '{{ json_encode(array_keys(\App\Http\Controllers\FunderController::$webPlatforms)) }}';

        function togglePlatformUrl() {
            const selectedValue = document.getElementById('automation').value;
            const platformUrlElement = document.querySelector('.platform-url');

            if (webAutomations.includes(selectedValue)) {
                platformUrlElement.style.display = 'block';
            } else {
                platformUrlElement.style.display = 'none';
            }
        }

        document.getElementById('automation').addEventListener('change', togglePlatformUrl);
        window.addEventListener('DOMContentLoaded', togglePlatformUrl);
    </script>
</x-app-layout>
