<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $sessionToken = \Illuminate\Support\Facades\Session::get('innove_auth_api');
            $userData = \Illuminate\Support\Facades\Session::get('api_user_data');
        @endphp
        <meta name="user-token" content="{{ $sessionToken }}">
        <meta name="user-id" content="{{ $userData['userId'] }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="//cdnjs.cloudflare.com/ajax/libs/flowbite/2.1.1/flowbite.min.css" rel="stylesheet" />
{{--        <link href="//cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css" rel="stylesheet">--}}

        <script src="//code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="//cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>

{{--        <script src="//js.pusher.com/8.2.0/pusher.min.js"></script>--}}
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

{{--        <script>--}}

{{--            // Enable pusher logging - don't include this in production--}}
{{--            Pusher.logToConsole = true;--}}

{{--            var pusher = new Pusher('cb8324f95fcedd6059f7', {--}}
{{--                cluster: 'ap1'--}}
{{--            });--}}

{{--            var channel = pusher.subscribe('my-channel');--}}
{{--            channel.bind('my-event', function(data) {--}}
{{--                alert(JSON.stringify(data));--}}
{{--            });--}}
{{--        </script>--}}
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')
            @include('layouts.sidebar')

            <!-- Page Content -->
            <main>
                <div class="p-4 sm:ml-64">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <script src="//cdnjs.cloudflare.com/ajax/libs/flowbite/2.1.1/flowbite.min.js"></script>
    </body>
</html>
