
<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">
                {{ __('Funder Name') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Funder Alias') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Trading Reset Time') }}
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($funders as $funder)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ ucfirst(Arr::get($funder, 'name')) }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ strtoupper(Arr::get($funder, 'alias')) }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    @if(!empty(Arr::get($funder, 'reset_time')))
                        {{ Arr::get($funder, 'reset_time') }}
                    @endif
                    @if(!empty(Arr::get($funder, 'reset_time_zone')) && !empty(Arr::get($funder, 'reset_time')))
                        <p class="text-xs">{{ getTimeZoneOffset(Arr::get($funder, 'reset_time_zone')) }}</p>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

