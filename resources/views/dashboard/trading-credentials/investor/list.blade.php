
<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">
                {{ __('Name') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Funder') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Account ID') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Phase') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Asset Type') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Symbol') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Status') }}
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            @php
                $personName = implode(' ', [
                    trim($item['user_account']['first_name']),
                    trim($item['user_account']['middle_name']),
                    trim($item['user_account']['last_name']),
                ]);
            @endphp
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $personName }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item['funder']['name'] }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item['funder_account_id'] }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ getPhaseName($item['current_phase']) }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ ucfirst($item['asset_type']) }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item['symbol'] }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ ucfirst($item['status']) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
