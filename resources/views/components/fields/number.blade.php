@php
    extract($field);
@endphp

<div class="{{ $wrapperClasses }} mb-6">
    @if(!empty($label))
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="{{ $name }}">
            {{ $label }}
        </label>
    @endif
<input class="{{ $classes }} border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}" type="number" {{ $attributes }}>
</div>
