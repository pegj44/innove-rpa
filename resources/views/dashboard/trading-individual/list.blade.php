
<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3"></th>

            @php
                $headers = [
                    __('Unit'),
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

            <th scope="col" class="px-6 py-3"></th>
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
                <td class="px-6 py-4 text-right border-r border-gray-600">
                    <a href="{{ route('trading-account.individual.edit', $item['id']) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                        <svg class="w-[20px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                        </svg>
                    </a>
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item['trading_unit']['name'] }}
                </td>

                @foreach($metadata as $meta_key)
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if(isset($item['metadata'][$meta_key]))
                            {{ $item['metadata'][$meta_key] }}
                        @endif
                    </td>
                @endforeach

                <td class="px-6 py-4 text-right border-l border-gray-600">
                    <form id="delete-item-{{ $item['id'] }}" method="POST" action="{{ route('trading-account.individual.delete', $item['id']) }}" class="flex flex-col justify-center" x-data="">
                        @csrf
                        @method('DELETE')
                        <a href="#" x-on:click.prevent="requestDeleteItem({{$item['id']}}, event)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            <svg class="w-[20px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                            </svg>
                        </a>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<button id="delete-item-modal-btn" data-modal-target="delete-item-modal" data-modal-toggle="delete-item-modal" class="hidden" type="button"></button>

<div id="delete-item-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-item-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-red-600 w-12 h-12 dark:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 text-center">
                    <p class="mb-0 me-auto ms-auto w-3/4">Are you sure you want to remove this Item?</p>
                </h3>
                <button id="confirm-delete-item-modal-btn" data-modal-hide="delete-item-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                    Confirm
                </button>
                <button id="cancel-delete-item-modal-btn" data-modal-hide="delete-item-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                <input type="hidden" id="delete-item-id" name="delete-item-id" value="">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmDeleteModalBtn = document.getElementById('confirm-delete-item-modal-btn');

        confirmDeleteModalBtn.addEventListener('click', function() {
            const deleteItemId = document.getElementById('delete-item-id');

            deleteItem(deleteItemId.value);
        });
    });

    function requestDeleteItem(itemId, event)
    {
        const deleteItemModalBtn = document.getElementById('delete-item-modal-btn');
        const deleteItemId = document.getElementById('delete-item-id');

        deleteItemId.value = itemId;
        deleteItemModalBtn.click();
    }

    function deleteItem(itemId)
    {
        let form = document.getElementById('delete-item-'+ itemId);
        form.submit();
    }
</script>

