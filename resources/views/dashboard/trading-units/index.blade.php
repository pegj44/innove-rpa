<x-app-layout>

    <div class="p-6 mt-14">
        @include('dashboard.trading-units.register-unit')

        @include('components.dashboard-notification')

        <div class="shadow-sm mt-8">
            <div class="text-gray-900 dark:text-gray-100 mb-4">

                @if(!empty($tradingUnits))
                    <h3 class="mb-5">{{ __("Your trading units") }}</h3>
                @else
                    <h3 class="mb-5">{{ __("You have no trading units yet.") }}</h3>
                @endif

                <div class="grid grid-cols-1 xl:grid-cols-6 lg:grid-cols-5 md:grid-cols-3 sm:grid-cols-2 gap-4">
                    @foreach($tradingUnits as $unit)

                        @php
                            $isConnected = true;
                            $isEnabled = ($unit['status'])? 'checked' : ''
                        @endphp
                        <div class="block max-w-full min-w-[145px] p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

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

                            <h5 class="mb-2 text-xl text-center font-bold tracking-tight text-gray-900 dark:text-white mt-3">{{ $unit['name'] }}</h5>
                            <p class="font-normal text-center text-gray-700 dark:text-gray-400">{{ $unit['ip_address'] }}</p>

                            <div class="flex justify-center mt-4">
                                <button type="button" class="px-3 py-2 text-sm font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="w-[18px] h-[18px] text-gray-800 dark:text-white mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 4v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2m6-16v2m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v10m6-16v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2"/>
                                    </svg>
                                    {{ __("Initialize") }}
                                </button>
                            </div>

                            <div class="mt-5 pt-5 flex justify-between border-t border-gray-600">
                                <form id="update-status-{{ $unit['id'] }}" method="POST" action="{{ route('trading-unit.update', $unit['id']) }}" x-data="">
                                    @csrf
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input id="disable-unit-{{ $unit['id'] }}" type="hidden" name="status" value="">
                                        <input id="checkbox-{{ $unit['id'] }}" {{$isEnabled}} type="checkbox" value="1" class="sr-only peer">
                                        <div x-on:click="requestUpdateUnitStatus({{$unit['id']}}, event)" class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-900 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    </label>
                                </form>

                                <div class="flex justify-end gap-2">
                                    <button onClick="requestUpdateUnit({{ $unit['id'] }})" type="button" data-modal-target="update-unit-modal" data-modal-toggle="update-unit-modal">
                                        <svg class="w-[22px] h-[22px] text-gray-800 dark:hover:text-gray-100 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                        </svg>
                                    </button>
                                    <form id="delete-unit-{{ $unit['id'] }}" method="POST" action="{{ route('trading-unit.delete', $unit['id']) }}" class="flex flex-col justify-center" x-data="">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#" x-on:click.prevent="requestDeleteUnit({{$unit['id']}}, event)" class="block">
                                            <svg class="w-[22px] h-[22px] text-gray-800 dark:hover:text-gray-100 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                            </svg>
                                        </a>
                                    </form>
                                </div>

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
                    <button id="confirm-disable-unit-modal-btn" data-modal-hide="disable-unit-modal" type="button" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                        Confirm
                    </button>
                    <button id="cancel-disable-unit-modal-btn" data-modal-hide="disable-unit-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                    <input type="hidden" id="disable-unit-id" name="disable-unit-id" value="">
                </div>
            </div>
        </div>
    </div>

    <button id="delete-unit-modal-btn" data-modal-target="delete-unit-modal" data-modal-toggle="delete-unit-modal" class="hidden" type="button"></button>

    <div id="delete-unit-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-unit-modal">
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
                        <p class="mb-0 me-auto ms-auto w-3/4">Are you sure you want to delete this unit?</p>
                    </h3>
                    <button id="confirm-delete-unit-modal-btn" data-modal-hide="delete-unit-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                        Confirm
                    </button>
                    <button id="cancel-delete-unit-modal-btn" data-modal-hide="delete-unit-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                    <input type="hidden" id="delete-unit-id" name="delete-unit-id" value="">
                </div>
            </div>
        </div>
    </div>

    <div id="update-unit-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                <form id="update-unit-form" action="{{ route('trading-unit.update', 0) }}" method="POST">
                    @csrf
                <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ __("Update unit: ") }} <span id="update-unit-name"></span>
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="update-unit-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <div class="mb-6">
                            <label for="update_unit_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit Name</label>
                            <input type="text" id="update_unit_name" name="name" aria-required="true" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required />
                        </div>

                        <div class="mb-6">
                            <label for="update_ip_address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IP Address</label>
                            <input type="text" id="update_ip_address" name="ip_address" pattern="^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$" title="Enter a valid IP address (e.g., 192.168.1.1)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>

                        <div class="mb-6">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="update_unit_status" checked name="status" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-900 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300 relative">
                                Enable unit
                            </span>
                            </label>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex justify-between items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" class="px-3 py-2 text-sm font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg data-modal-hide="update-unit-modal" class="w-[18px] h-[18px] text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M11 16h2m6.707-9.293-2.414-2.414A1 1 0 0 0 16.586 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7.414a1 1 0 0 0-.293-.707ZM16 20v-6a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v6h8ZM9 4h6v3a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V4Z"/>
                            </svg>
                            {{ __("Update") }}
                        </button>
                        <button data-modal-hide="update-unit-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>

        const tradingUnits = @json($tradingUnits);

        document.addEventListener('DOMContentLoaded', function() {
            const confirmDisableModalBtn = document.getElementById('confirm-disable-unit-modal-btn');

            confirmDisableModalBtn.addEventListener('click', function() {
                const disableUnitId = document.getElementById('disable-unit-id');
                const disableUnitToggle = document.getElementById('checkbox-'+ disableUnitId.value);

                disableUnitToggle.checked = false;
                updateUnitStatus(disableUnitId.value, 0);
            });

            const confirmDeleteModalBtn = document.getElementById('confirm-delete-unit-modal-btn');

            confirmDeleteModalBtn.addEventListener('click', function() {
                const deleteUnitId = document.getElementById('delete-unit-id');

                deleteUnit(deleteUnitId.value);
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
                updateUnitStatus(unitId, 1);
            }
        }

        function requestDeleteUnit(unitId, event)
        {
            const deleteUnitModalBtn = document.getElementById('delete-unit-modal-btn');
            const deleteUnitId = document.getElementById('delete-unit-id');

            deleteUnitId.value = unitId;
            deleteUnitModalBtn.click();
        }

        function updateUnitStatus(id, status) {

            let disableInput = document.getElementById('disable-unit-'+ id);
            let form = document.getElementById('update-status-'+ id);

            disableInput.value = status;

            form.submit();
        }

        function deleteUnit(unitId)
        {
            let form = document.getElementById('delete-unit-'+ unitId);
            form.submit();
        }

        function requestUpdateUnit(unitId)
        {
            const unit = tradingUnits[unitId];
            const form = document.getElementById('update-unit-form');
            const name = document.getElementById('update_unit_name');
            const ip_address = document.getElementById('update_ip_address');
            const status = document.getElementById('update_unit_status');

            const action = form.getAttribute('action');

            name.value = unit.name;
            ip_address.value = unit.ip_address;
            status.checked = (unit.status);

            form.setAttribute('action', action.replace(/trading-unit\/\d+/, 'trading-unit/' + unitId));
        }
    </script>


</x-app-layout>
