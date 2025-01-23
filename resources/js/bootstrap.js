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

    if (data.action === 'trade-closed') {

    }

    if (data.action === 'no-pairable-accounts') {

    }
});

const loaderEvent = new CustomEvent('openLoader');
document.dispatchEvent(loaderEvent);
