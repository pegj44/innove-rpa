<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <a href="/" class="flex ms-2 md:me-24">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200 mr-1" />
                </a>
            </div>
            <div class="flex items-center">
                @php
                    $userData = Session::get('api_user_data');
                @endphp
                <div class="flex items-center">
                    <div class="pr-5 text-right text-white text-xs hidden sm:flex">
                        @if(!empty($userData['profile']['first_name']))
                            <span style=" line-height: 26px; font-size: 16px;" class="font-black mr-1">
                                {{ $userData['profile']['first_name'] }}
                                @if(!empty($userData['profile']['middle_name']))
                                    {{ ucfirst($userData['profile']['middle_name'][0]) }}.
                                @endif
                                {{ $userData['profile']['last_name'] }}
                            </span>
                        @endif
                        @if(!empty($userData['profile']['company']))
                            <span class="bg-gray-900 border px-2 py-1 rounded text-gray-300" style="font-size: 14px;border-color: #101010;"> {{ $userData['profile']['company'] }}</span>
                        @endif
                    </div>
                    @if(!empty($userData['profile']['country']))
                        <div class="flag mr-1" style="width: 38px;">
                            <img src="/images/{{ getCountryImage($userData['profile']['country']) }}">
                        </div>
                    @endif
                </div>
                <div class="flex items-center ms-3">
                    @php
                        $userData = session('api_user_data');
                    @endphp
                    <div>
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>

                            @if(!empty($userData['profile']['profile_image']))
{{--                                <img class="border border-2 border-white nav-profile-image rounded-full" style="width: 38px; height:38px;" src="{{ getProfileIcon($userData['profile']['profile_image']) }}">--}}
                                <img class="border border-2 border-white nav-profile-image rounded-full" style="width: 38px; height:38px;" src="{{ url('profile-images/' . $userData['profile']['profile_image']) }}">
                            @else
                                <svg class="w-[28px] h-[28px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 dark:text-white" role="none">
                                Welcome {{$userData['name']}}
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                {{$userData['email']}}
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <form method="POST" action="{{route('logout')}}">
                                    @csrf
                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" href="#" onclick="event.preventDefault();
                                                this.closest('form').submit();">Log Out</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
