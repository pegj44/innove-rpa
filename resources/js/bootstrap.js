/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

let userToken = document.querySelector('meta[name="user-token"]').getAttribute('content');
let baseUrl = window.location.origin;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    authEndpoint: `${baseUrl}/pusher/broadcasting/auth`,
    auth: {
        headers: {
            'Authorization': 'Bearer '+ userToken,
        }
    }
});

window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('Connected to Pusher successfully!');
});

window.Echo.connector.pusher.connection.bind('disconnected', () => {
    console.log('Disconnected from Pusher.');
});

window.Echo.connector.pusher.connection.bind('error', (err) => {
    console.error('Error with Pusher connection:', err);
});

window.Echo.private('unit.3').listen('UnitResponse', (data) => {
    console.log('Received data:', data);

    const customEvent = new CustomEvent('pusherNotificationEvent', {
        'eventTest': true,
        detail: data
    });
    document.dispatchEvent(customEvent);

    if (data.action === 'pair_accounts-failed') {

    }

    if (data.action === 'no-pairable-accounts') {

    }
});

// import Echo from 'laravel-echo';
//
// import Pusher from 'pusher-js';
// window.Pusher = Pusher;
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss']
// });
//
// window.Echo.private('unit.3').listen('UnitResponse', e => {
//     console.log('event fired');
//     console.log(e);
// });
//




/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     forceTLS: true
// });
//

// const Pusher = require('pusher');



// import Echo from 'laravel-echo';
//
// import Pusher from 'pusher';
// // window.Pusher = Pusher;
// //
// // window.Echo = new Echo({
// //     broadcaster: 'pusher',
// //     key: import.meta.env.VITE_PUSHER_APP_KEY,
// //     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
// //     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
// //     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
// //     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
// //     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
// //     enabledTransports: ['ws', 'wss'],
// // });
// //
// // window.Echo.private('unit.3').listen('UnitResponse', e => {
// //     console.log('event fired');
// //     console.log(e);
// // });
//
//
//
// let pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     authEndpoint: 'pusher-auth',
//     encrypted: true,
// });
//
// console.log(pusher);
// console.log(import.meta.env.VITE_PUSHER_APP_KEY);
// console.log(import.meta.env.VITE_PUSHER_APP_CLUSTER);

// let channelId = 3;
// let channel = pusher.subscribe('private-unit.'+ channelId);
//
// pusher.connection.bind('connected', function () {
//     console.log('Successfully connected to Pusher.');
// });
//
// pusher.connection.bind('error', function (err) {
//     console.error('Connection error:', err);
// });
