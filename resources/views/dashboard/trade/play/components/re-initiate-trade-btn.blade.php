<input type="hidden" name="queue_id" value="{{ $pairedItemData['queue_db_id'] }}">

<button type="submit" class="initiate-trade-btn px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white rounded-lg focus:ring-4 focus:outline-none bg-orange-700 hover:bg-orange-800 dark:hover:bg-orange-700 dark:focus:ring-orange-800 dark:bg-orange-600 focus:ring-orange-300">
    <svg class="w-[24px] h-[24px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 18V6l8 6-8 6Z"/>
    </svg>
    {{ __('Re-Initiate') }}
</button>
