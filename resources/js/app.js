import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Import Echo and Pusher
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';
//
// // Configure Laravel Echo with Pusher
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
//
// // Listen for events on the 'external-requests' channel
// window.Echo.channel('innove-unit-request')
//     .listen('UnitsRequestReceived', (e) => {
//         console.log(e.message); // This is where you handle the incoming event data
//     });
