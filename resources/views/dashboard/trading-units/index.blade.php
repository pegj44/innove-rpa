<x-app-layout>

    <div class="p-6 mt-14">
        @include('dashboard.trading-units.register-unit')

        @include('components.dashboard-notification')

        <div class="overflow-hidden shadow-sm mt-8">
            <div class="text-gray-900 dark:text-gray-100 mb-4">

                @if(!empty($tradingUnits))
                    <h3 class="mb-5">{{ __("Your trading units") }}</h3>
                @else
                    <h3 class="mb-5">{{ __("You have no trading units yet.") }}</h3>
                @endif

                <div x-data class="flex gap-5 grid grid-cols-6">
                    @foreach($tradingUnits as $unit)

                        @php
                            $isConnected = false;
                            $isEnabled = ($unit['status'])? 'checked' : ''
                        @endphp
                        <div class="block max-w-sm w-64 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                            <div class="flex justify-center gap-1">
                                @if($isEnabled)
                                    @if($isConnected)
                                        <svg class="w-[15px] h-[15px] text-green-400 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                        </svg>
                                        <div class="text-center text-xs text-green-400 dark:text-green-400">Connected</div>
                                    @else
                                        <svg class="w-[15px] h-[15px] text-red-400 dark:text-red-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0V8Zm-1 7a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z" clip-rule="evenodd"/>
                                        </svg>
                                        <div class="text-center text-xs text-red-400 dark:text-red-400">Disconnected</div>
                                    @endif
                                @else
                                    <svg class="w-[15px] h-[15px] text-gray-300 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm5.757-1a1 1 0 1 0 0 2h8.486a1 1 0 1 0 0-2H7.757Z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="text-center text-xs text-gray-300 dark:text-gray-300">Disabled</div>
                                @endif
                            </div>

                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white mt-3">{{ $unit['name'] }}</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">{{ $unit['ip_address'] }}</p>

                            <div class="mt-5 flex justify-between">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input id="checkbox-{{$unit['id']}}" {{$isEnabled}} type="checkbox" name="enable" value="1" class="sr-only peer">
                                    <div x-on:click="requestUpdateUnitStatus({{$unit['id']}}, event)" class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-900 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                </label>

                                <a href="#" class="block">
                                    <svg class="w-[22px] h-[22px] text-gray-800 dark:hover:text-gray-100 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                    </svg>
                                </a>

                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <button id="disable-unit-modal-btn" data-modal-target="disable-unit-modal" data-modal-toggle="disable-unit-modal" class="hidden" type="button"></button>

    <div id="disable-unit-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="disable-unit-modal">
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
                        <p class="mb-0 me-auto ms-auto w-3/4">Are you sure you want to disable this unit?</p>
                    </h3>
                    <button id="confirm-disable-unit-modal-btn" data-modal-hide="disable-unit-modal" type="button" class="text-white bg-orange-600 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                        Confirm
                    </button>
                    <button id="cancel-disable-unit-modal-btn" data-modal-hide="disable-unit-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                    <input type="hidden" id="disable-unit-id" name="disable-unit-id" value="">
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmDisableModalBtn = document.getElementById('confirm-disable-unit-modal-btn');

        confirmDisableModalBtn.addEventListener('click', function() {
            const disableUnitId = document.getElementById('disable-unit-id');
            const disableUnitToggle = document.getElementById('checkbox-'+ disableUnitId.value);

            disableUnitToggle.checked = false;
            updateUnitStatus(disableUnitId.value, false);
        });
    });

    function requestUpdateUnitStatus(unitId, event)
    {
        let checkbox = event.target.previousElementSibling;
        let status = !checkbox.checked;

        if (!status) {

            event.preventDefault();

            const disableUnitModalBtn = document.getElementById('disable-unit-modal-btn');
            const disableUnitId = document.getElementById('disable-unit-id');

            disableUnitId.value = unitId;
            disableUnitModalBtn.click();
        } else {
            updateUnitStatus(unitId, status);
        }
    }

    function updateUnitStatus(unitId, status)
    {
        console.log(unitId, status);
        {{--fetch('{{ route('ajax.form.updateStatus') }}', {--}}
        {{--    method: 'POST',--}}
        {{--    headers: {--}}
        {{--        'Content-Type': 'application/json',--}}
        {{--        'X-Requested-With': 'XMLHttpRequest',--}}
        {{--        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')--}}
        {{--    },--}}
        {{--    body: JSON.stringify({--}}
        {{--        unitId: unitId,--}}
        {{--        status: status--}}
        {{--    })--}}
        {{--})--}}
        {{--    .then(response => response.json())--}}
        {{--    .then(data => {--}}
        {{--        // console.log(data);--}}
        {{--    })--}}
        {{--    .catch(error => console.error('Error:', error));--}}
    }
</script>
