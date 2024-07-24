
<div class="max-w-[360px] mt-5" x-data="">

    <a href="#" x-on:click.prevent="" class="text-blue-500 text-sm text-blue-500" aria-controls="add-bulk-individuals" data-collapse-toggle="add-bulk-individuals">
        <div class="flex items-center">
            <svg class="w-[18px] h-[18px] dark:text-blue-500 text-blue-500 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01"/>
            </svg>
            Bulk add items
        </div>
    </a>

    <form id="add-bulk-individuals" class="hidden mt-5" method="post" action="{{ route('trading-account.individuals.store') }}" enctype="multipart/form-data">
        @csrf
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="individuals_record">Upload file</label>
        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="individuals_record_help" id="individuals_record" name="individuals_record" type="file" accept="text/csv">
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="individuals_record_help">CSV only</p>

        <button type="submit" class="mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            {{ __('Upload Data') }}
        </button>
    </form>
</div>
