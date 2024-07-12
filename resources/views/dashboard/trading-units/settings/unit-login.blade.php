@php
    $username = (!empty($settings['login']))? $settings['login']['name'] : '';
    $action = route('trading-unit.settings.set-password');

    if($username) {
        $action = route('trading-unit.settings.update-password');
    }
@endphp

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Units Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('This password will be used to login to your units.') }}
        </p>
    </header>

    <form method="post" action="{{ $action }}" class="mt-6 space-y-6" x-data="">
        @csrf
        <div>
            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="username">
                {{ __('Username') }}
            </label>
            <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" id="username" name="username" value="{{ $username }}" type="text" required="required" autofocus="autofocus">
        </div>

        @if(!empty($username))
            <a id="change-pw-btn" href="#" x-on:click.prevent="updatePw()" class="block font-medium text-sm text-blue-500 dark:text-blue-500 underline">
                {{ __('Change Password') }}
            </a>
        @endif

        <div id="update-password-toggle" class="{{ !empty($username)? 'hidden': '' }}">

            <div class="mb-5">
                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="password">
                    {{ __('Password') }}
                </label>
                <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" id="password" name="password" type="password" {{ (!empty($username))? '' : 'required="required"' }}>
            </div>
            <div class="mb-5">
                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="password_confirm">
                    {{ __('Confirm Password') }}
                </label>
                <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" id="password_confirm" name="password_confirm" type="password" {{ (!empty($username))? '' : 'required="required"' }}>
            </div>
        </div>

        <div class="flex justify-between gap-4">
            <button type="submit" class="px-3 py-2 text-sm font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-[18px] h-[18px] text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M11 16h2m6.707-9.293-2.414-2.414A1 1 0 0 0 16.586 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7.414a1 1 0 0 0-.293-.707ZM16 20v-6a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v6h8ZM9 4h6v3a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V4Z"/>
                </svg>
                {{ __("Save") }}
            </button>

            @if(!empty($username))
                <button id="cancel-pw-update" @click="cancelPwUpdate()" type="button" class="hidden py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    {{ __("Cancel") }}
                </button>
            @endif
        </div>
    </form>
</section>

<button id="update-pw-modal-btn" type="button" class="hidden" data-modal-target="update-pw-modal" data-modal-toggle="update-pw-modal"></button>

<div id="update-pw-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full" x-data="">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="update-pw-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-orange-600 w-12 h-12 dark:text-orange-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 text-center">
                    <p class="mb-0 me-auto ms-auto w-3/4">Changing units password will logout all your running units. <br><br>Are you sure you want to update your units password?</p>
                </h3>
                <button x-on:click="confirmPwUpdate()" data-modal-hide="update-pw-modal" type="button" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                    Confirm
                </button>
                <button id="cancel-update-pw-modal-btn" data-modal-hide="update-pw-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                <input type="hidden" id="disable-unit-id" name="disable-unit-id" value="">
            </div>
        </div>
    </div>
</div>

<script>
    const pwModalBtn = document.getElementById('update-pw-modal-btn');
    const cancelBtn = document.getElementById('cancel-pw-update');
    const pwWrap = document.getElementById('update-password-toggle');
    const changePwBtn = document.getElementById('change-pw-btn');

    const pw = document.getElementById('password');
    const pwConfirm = document.getElementById('password_confirm');

    function updatePw()
    {
        pwModalBtn.click();
        cancelBtn.classList.add('hidden');

        pw.setAttribute('required', 'required');
        pwConfirm.setAttribute('required', 'required');
    }

    function cancelPwUpdate()
    {
        changePwBtn.classList.remove('hidden');
        pwWrap.classList.add('hidden');
        cancelBtn.classList.add('hidden');

        pw.removeAttribute('required');
        pwConfirm.removeAttribute('required');
    }

    function confirmPwUpdate()
    {
        changePwBtn.classList.add('hidden');
        pwWrap.classList.remove('hidden');
        cancelBtn.classList.remove('hidden');
    }

</script>
