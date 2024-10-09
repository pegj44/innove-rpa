<h1 class="mb-4">User Accounts</h1>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            @php
                $headers = [
                    __('Type'),
                    __('First Name'),
                    __('Middle Name'),
                    __('Last Name'),
                    __('Email'),
                    __('Address'),
                    __('City'),
                    __('Province'),
                    __('Zip Code'),
                    __('Contact Number 1'),
                    __('Contact Number 2'),
                    __('Birth Year'),
                    __('Birth Month'),
                    __('Birth Day'),
                    __('ID Type'),
                    __('Billing'),
                    __('Remarks'),
                ];
            @endphp

            @foreach($headers as $header)
                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                    {{ $header }}
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)

            @php

                $item['metadata']['first_name'] = $item['first_name'];
                $item['metadata']['last_name'] = $item['last_name'];
                $item['metadata']['middle_name'] = $item['middle_name'];
                $item['metadata']['email'] = $item['email'];

                $metadata = [
                    'type',
                    'first_name',
                    'middle_name',
                    'last_name',
                    'email',
                    'address',
                    'city',
                    'province',
                    'zip_code',
                    'contact_number1',
                    'contact_number2',
                    'birth_year',
                    'birth_month',
                    'birth_day',
                    'id_type',
                    'billing',
                    'remarks'
                ];
            @endphp
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                @foreach($metadata as $meta_key)
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if(isset($item['metadata'][$meta_key]))
                            {{ $item['metadata'][$meta_key] }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
