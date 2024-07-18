
<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3">
                {{ __('Funder Name') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Funder Alias') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Type of Evaluation') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Daily Threshold') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Max Drawdown') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Phase 1 Target Profit') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Phase 2 Target Profit') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Consistency Rule') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Reset Time') }}
            </th>
            <th scope="col" class="px-6 py-3"></th>
        </tr>
        </thead>
        <tbody>
            @foreach($funders as $funder)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 text-right border-r border-gray-600">
                        <a href="{{ route('funder.edit', $funder['id']) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            <svg class="w-[20px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                            </svg>
                        </a>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ ucfirst($funder['metadata']['name']) }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ strtoupper($funder['metadata']['alias']) }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ getFunderStepName($funder['metadata']['evaluation_type']) }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ getFunderAmountsType($funder['metadata']['daily_threshold'], $funder['metadata']['daily_threshold_type']) }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ getFunderAmountsType($funder['metadata']['max_drawdown'], $funder['metadata']['max_drawdown_type']) }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ getFunderAmountsType($funder['metadata']['phase_one_target_profit'], $funder['metadata']['phase_one_target_profit_type']) }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ getFunderAmountsType($funder['metadata']['phase_two_target_profit'], $funder['metadata']['phase_two_target_profit_type']) }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if(isset($funder['metadata']['consistency_rule']))
                            {{ getFunderAmountsType($funder['metadata']['consistency_rule'], $funder['metadata']['consistency_rule_type']) }}
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if(isset($funder['metadata']['reset_time']))
                            {{ $funder['metadata']['reset_time'] }}
                        @endif
                        @if(isset($funder['metadata']['reset_time_zone']))
                            <p class="text-xs">{{ getTimeZoneOffset($funder['metadata']['reset_time_zone']) }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right border-l border-gray-600">
                        <form id="delete-funder-{{ $funder['id'] }}" method="POST" action="{{ route('funder.delete', $funder['id']) }}" class="flex flex-col justify-center" x-data="">
                            @csrf
                            @method('DELETE')
                            <a href="#" x-on:click.prevent="requestDeleteFunder({{$funder['id']}}, event)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
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

<button id="delete-funder-modal-btn" data-modal-target="delete-funder-modal" data-modal-toggle="delete-funder-modal" class="hidden" type="button"></button>

<div id="delete-funder-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-funder-modal">
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
                    <p class="mb-0 me-auto ms-auto w-3/4">Are you sure you want to remove this Funder?</p>
                </h3>
                <button id="confirm-delete-funder-modal-btn" data-modal-hide="delete-funder-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                    Confirm
                </button>
                <button id="cancel-delete-funder-modal-btn" data-modal-hide="delete-funder-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                <input type="hidden" id="delete-funder-id" name="delete-funder-id" value="">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmDeleteModalBtn = document.getElementById('confirm-delete-funder-modal-btn');

        confirmDeleteModalBtn.addEventListener('click', function() {
            const deleteFunderId = document.getElementById('delete-funder-id');

            deleteFunder(deleteFunderId.value);
        });
    });

    function requestDeleteFunder(funderId, event)
    {
        const deleteFunderModalBtn = document.getElementById('delete-funder-modal-btn');
        const deleteFunderId = document.getElementById('delete-funder-id');

        deleteFunderId.value = funderId;
        deleteFunderModalBtn.click();
    }

    function deleteFunder(funderId)
    {
        let form = document.getElementById('delete-funder-'+ funderId);
        form.submit();
    }
</script>

