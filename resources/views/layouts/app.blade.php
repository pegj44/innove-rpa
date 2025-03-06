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
        <meta name="account-id" content="{{ $userData['accountId'] }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="//cdnjs.cloudflare.com/ajax/libs/flowbite/2.1.1/flowbite.min.css" rel="stylesheet" />

        <script src="//code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="//cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>

        <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const apiUrl = "{{ route('user.settings.add') }}";
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

            @include('layouts.navigation')
            @include('layouts.sidebar')

            <!-- Page Content -->
            <main>
                <div class="galaxybg fixed">
                    <canvas id="canvas-stars"></canvas>
                    <img src="/images/galaxy5.jpg" style="opacity: 0.2">
                </div>

                <div class="p-4 sm:ml-64">
                    <div style="position: relative;">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>

        <div class="global-loader-wrap hidden">
            <div>
                <span class="loader"></span>
            </div>
        </div>

        <script src="//cdnjs.cloudflare.com/ajax/libs/flowbite/2.1.1/flowbite.min.js"></script>
        <script>
            var Space = {
                init: function(){
                    var self = this;
                    this.config = {
                        perspective: 3,
                        star_color: '255, 255, 255',
                        speed: 1,
                        stars_count: 2
                    };
                    this.canvas = document.getElementById('canvas-stars');
                    this.context = this.canvas.getContext('2d');
                    this.start();
                    window.onresize = function(){
                        self.start();
                    };
                },

                start: function(){
                    var self = this;

                    this.canvas.width  = this.canvas.offsetWidth;
                    this.canvas.height = this.canvas.offsetHeight;
                    this.canvas_center_x = this.canvas.width / 2;
                    this.canvas_center_y = this.canvas.height / 2;

                    this.stars_count = this.canvas.width / this.config.stars_count;
                    this.focal_length = this.canvas.width / this.config.perspective;
                    this.speed = this.config.speed * this.canvas.width / 2000;

                    this.stars = [];

                    for(i = 0; i < this.stars_count; i++){
                        this.stars.push({
                            x: Math.random() * this.canvas.width,
                            y: Math.random() * this.canvas.height,
                            z: Math.random() * this.canvas.width,
                        });
                    }

                    window.cancelAnimationFrame(this.animation_frame);
                    this.canvas.style.opacity = 1;

                    this.cow = new Image();
                    this.cow.src = '/images/stars.png';
                    this.cow.onload = function(){
                        self.render();
                    }
                },

                render: function(){
                    var self = this;
                    this.animation_frame = window.requestAnimationFrame(function(){
                        self.render();
                    });
                    this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
                    for(var i = 0, length = this.stars.length; i < length; i += 1){
                        var star = this.stars[i];
                        star.z -= this.speed;
                        if(star.z <= 0) {
                            this.stars[i] = {
                                x: Math.random() * this.canvas.width,
                                y: Math.random() * this.canvas.height,
                                z: this.canvas.width,
                            };
                        }

                        var star_x = (star.x - this.canvas_center_x) * (this.focal_length / star.z) + this.canvas_center_x;
                        var star_y = (star.y - this.canvas_center_y) * (this.focal_length / star.z) + this.canvas_center_y;
                        var star_radius  = Math.max(0, 1.4 * (this.focal_length / star.z) / 2);
                        var star_opacity = 1.2 - star.z / this.canvas.width;
                        var cow_width = Math.max(0.1, 100 * (this.focal_length / star.z) / 2);

                        if(star.cow){
                            this.context.save();
                            this.context.translate((star_x-cow_width)+(cow_width/2), (star_y-cow_width)+(cow_width/2));
                            this.context.rotate(star.z/star.rotation_speed);
                            this.context.translate(-((star_x-cow_width)+(cow_width/2)), -((star_y-cow_width)+(cow_width/2)));
                            this.context.globalAlpha = star_opacity;
                            this.context.drawImage(this.cow, 0, 0, this.cow.width, this.cow.width, star_x-cow_width, star_y-cow_width, cow_width, cow_width);
                            this.context.restore();
                        } else {
                            this.context.fillStyle = 'rgba(' + this.config.star_color + ',' + star_opacity + ')';
                            this.context.beginPath();
                            this.context.arc(star_x, star_y, star_radius, 0, Math.PI * 2);
                            this.context.fill();
                        }
                    }
                }
            };

            window.onload = function(){
                Space.init();
            };

            function getTemplate(template, data, wrapperHtml = null) {
                $.ajax({
                    url: "{{ route('template') }}",
                    type: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    data: JSON.stringify({
                        template: template,
                        data: data
                    }),
                    success: function(response) {
                        if (wrapperHtml) {
                            wrapperHtml.innerHTML = response.template;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            }

            const numberInputs = document.querySelectorAll('input[type="number"]');

            // Check if there are any number inputs
            if (numberInputs.length > 0) {
                // Disable mouse wheel for each number input
                numberInputs.forEach(input => {
                    input.addEventListener('wheel', function(event) {
                        event.preventDefault();  // Prevent default mousewheel behavior
                    });
                });
            }

            document.addEventListener('pusherNotificationEvent', function(event) {
                if(event.detail.action === 'trade-started') {
                    const audio = new Audio("{{ asset('media/trade-started2.mp3') }}");
                    audio.play().catch(error => {
                        console.error("Playback failed:", error);
                    });

                    console.log('trade-started');

                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            });

            document.addEventListener('pusherNotificationEvent', function(event) {
                if(event.detail.action === 'trade-closed') {
                    const audio = new Audio("{{ asset('media/trade-closed2.mp3') }}");
                    audio.play().catch(error => {
                        console.error("Playback failed:", error);
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 4000);
                }
            });

            document.addEventListener('pusherNotificationEvent', function(event) {
                if(event.detail.action === 'initialize-complete') {
                    const audio = new Audio("{{ asset('media/trade-ready.mp3') }}");
                    audio.play().catch(error => {
                        console.error("Playback failed:", error);
                    });

                    const pairForm = document.getElementById('trade-item-status-'+ event.detail.arguments.queue_db_id);
                    const pairFormWrap = pairForm.querySelector('.pair-form-wrap');
                    const route = '{{ route("trade.start") }}';

                    pairForm.setAttribute('action', route);

                    getTemplate('dashboard.trade.play.components.initiate-trade-btn', {
                        'pairedItemData': {
                            "queue_db_id": event.detail.arguments.queue_db_id
                        }
                    }, pairFormWrap);

                    const pairFooterWrap = document.querySelector('[data-queueItemId="'+ event.detail.arguments.queue_db_id +'"] .remove-pair');
                    pairFooterWrap.classList.remove('hidden');

                    const pairWrapper = document.querySelector('[data-queueitemid="'+ event.detail.arguments.queue_db_id +'"]');
                    pairWrapper.parentElement.querySelector('.pair-form-wrap').classList.remove('hidden');

                    const queueItemWrap = document.querySelector('.status-handler[data-itemid="'+ event.detail.arguments.itemId +'"]');
                    queueItemWrap.innerHTML = '';
                }
            });

            document.addEventListener('pusherNotificationEvent', function(event) {
                if (event.detail.action === 'trade-initialize-error') {
                    const audio = new Audio("{{ asset('media/trade-error.mp3') }}");
                    let playCount = 0;
                    const maxPlays = 3;

                    if (event.detail.arguments.sound) {
                        const playAudio = () => {
                            if (playCount < maxPlays) {
                                audio.play().then(() => {
                                    playCount++;
                                }).catch(error => {
                                    console.error("Playback failed:", error);
                                });
                            }
                        };

                        playAudio();
                        audio.addEventListener('ended', playAudio);
                    }

                    const pairForm = document.getElementById('trade-item-status-'+ event.detail.arguments.queue_db_id);
                    const pairFormWrap = pairForm.querySelector('.pair-form-wrap');
                    const pairHeader = document.querySelector('h2[data-queueitemid="'+ event.detail.arguments.queue_db_id +'"] .remove-pair');

                    const route = '{{ route("trade.re-initialize") }}';

                    pairForm.setAttribute('action', route);
                    pairHeader.classList.remove('hidden');

                    console.log(event.detail);

                    const pairWrapper = document.querySelector('[data-queueitemid="'+ event.detail.arguments.queue_db_id +'"]');
                    pairWrapper.parentElement.querySelector('.pair-form-wrap').classList.add('hidden');

                    const statusHandler = document.querySelector('.status-handler[data-itemid="'+ event.detail.arguments.itemId +'"]');
                    const msgHtml = '<span class="bg-red-600 font-normal ml-2 px-2 py-1 rounded text-sm">'+ event.detail.arguments.message +'</span>';

                    statusHandler.innerHTML = msgHtml;

                    if (event.detail.arguments.errorCode === 'missing_uipath') {
                        getTemplate('dashboard.trade.play.components.re-initiate-trade-btn', {
                            'pairedItemData': {
                                "queue_db_id": event.detail.arguments.queue_db_id
                            }
                        }, pairFormWrap);
                    }
                }
            });

            document.addEventListener("DOMContentLoaded", function() {
                let inputs = document.querySelectorAll('input[autocomplete="off"]');

                inputs.forEach(function(input) {
                    input.setAttribute("readonly", true); // Disable typing initially
                    input.onfocus = function() {
                        this.removeAttribute("readonly"); // Enable typing when clicked
                    };
                });
            });

        </script>
    </body>
</html>
