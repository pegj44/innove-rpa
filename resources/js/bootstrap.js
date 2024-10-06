/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import { Tabs } from 'flowbite';
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

let userToken = document.querySelector('meta[name="user-token"]').getAttribute('content');
let accountId = document.querySelector('meta[name="account-id"]').getAttribute('content');
let baseUrl = window.location.origin;

window.Echo1 = new Echo({
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

window.Echo1.connector.pusher.connection.bind('connected', () => {
    console.log('Connected to Pusher successfully!');
});

window.Echo1.connector.pusher.connection.bind('disconnected', () => {
    console.log('Disconnected from Pusher.');
});

window.Echo1.connector.pusher.connection.bind('error', (err) => {
    console.error('Error with Pusher connection:', err);
});

window.Echo1.private('unit.'+ accountId).listen('UnitResponse', (data) => {

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


// const pusher = new Pusher({
//     appId: 'YOUR_APP_ID',
//     key: 'YOUR_APP_KEY',
//     secret: 'YOUR_APP_SECRET',
//     cluster: 'YOUR_APP_CLUSTER',
//     useTLS: true
// });


//
//
// window.Echo2 = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true,
//     authEndpoint: `${baseUrl}/pusher/broadcasting/unit-presence-auth`,
//     auth: {
//         headers: {
//             'Authorization': 'Bearer ' + userToken,
//         },
//     },
// });
//
//
// const pusherClient = window.Echo2.connector.pusher;
//
// // Access the channel by its name
// const channel = pusherClient.channel('private-unit.3.112.198.98.12');
//
// // Check if the channel is subscribed and connected
// const isActive = channel && channel.subscribed;
//
// console.log(`Is channel "private-unit.3.112.198.98.12" active?`, isActive);

// Subscribe to a private channel
// const channel = Echo2.private('unit.3.112.198.98.12');
//
// // Check connection status
// if (Echo2.connector.pusher.connection.state === 'connected') {
//     console.log('Echo is connected');
// } else {
//     console.log('Echo is not connected');
// }

// Listen for connection state changes
// Echo2.connector.pusher.connection.bind('state_change', (states) => {
//     console.log('Connection state changed from', states.previous, 'to', states.current);
//
//     if (states.current === 'connected') {
//         console.log('Echo is connected');
//     }
// });

// Define channel names for each app
// const channelNames = ['unit.3.112.198.98.12', 'unit.3.112.198.98.13', 'unit.3.112.198.98.14'];
//
// // Function to handle connection status updates
// function updateConnectionStatus(channelName, members) {
//     console.log(`Connected members in ${channelName}:`, members.count);
//
//     // Use this information to update your UI or perform other actions
// }
//
// // Subscribe to each presence channel
// channelNames.forEach((name) => {
//     console.log(`presence-${name}`);
//     window.Echo2.join(`presence-${name}`)
//         .here((members) => {
//             // Called when you initially subscribe to the channel
//             updateConnectionStatus(name, { count: members.length });
//         })
//         .joining((member) => {
//             // Called when a new member joins
//             console.log(`${member.id} has connected to ${name}`);
//             updateConnectionStatus(name, window.Echo2.join(`presence-${name}`).members);
//         })
//         .leaving((member) => {
//             // Called when a member leaves
//             console.log(`${member.id} has disconnected from ${name}`);
//             updateConnectionStatus(name, window.Echo2.join(`presence-${name}`).members);
//         });
// });
