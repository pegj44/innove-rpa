@php
    extract($field);
@endphp

<div class="{{ $wrapperClasses }} mb-6">
    @if(!empty($label))
        <label for="time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
    @endif
    <div class="flex">
        <input type="time" id="{{ $name }}" name="{{ $name }}" class="flex-shrink-0 rounded-none rounded-s-lg bg-gray-50 border text-gray-900 leading-none focus:ring-blue-500 focus:border-blue-500 block text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $value }}">
        <select id="timezones" name="timezone" class="bg-gray-50 border border-s-0 border-gray-300 text-gray-900 text-sm rounded-e-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value=""> -- Select Timezone -- </option>
            @foreach(getTimezonesWithOffsets() as $timezone => $offset)
                <option value="{{ $timezone }}">{{ $offset }}</option>
            @endforeach
        </select>
    </div>
</div>
