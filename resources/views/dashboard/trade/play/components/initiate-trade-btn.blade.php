<input type="hidden" name="queue_id" value="{{ $pairedItemData['queue_db_id'] }}">

<button type="submit" class="initiate-trade-btn px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white rounded-lg focus:ring-4 focus:outline-none bg-blue-700 hover:bg-blue-800 dark:hover:bg-blue-700 dark:focus:ring-blue-800 dark:bg-blue-600 focus:ring-blue-300">
    <svg class="w-[24px] h-[24px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 18V6l8 6-8 6Z"/>
    </svg>
    {{ __('Start Trade') }}
</button>
