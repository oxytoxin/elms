window._ = require('lodash');
window.$ = require('jquery');
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */


import Pusher from 'pusher-js'
import Echo from 'laravel-echo'

// window.Echo = new Echo({
//   broadcaster: 'pusher',
//   key: '66212e32c297e111355b',
//   cluster: 'ap1',
//   forceTLS: true,
//   authEndpoint: '/broadcasting/auth'
// });
window.Pusher = require('pusher-js');

if(process.env.MIX_APP_ENV == "local"){
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '66212e32c297e111355b',
        wsHost: window.location.hostname,
        wsPort: 6001,
        wssPort: 6001,
        encrypted: false,
        forceTLS: false,
        disableStats: true,
      });
}else{
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '66212e32c297e111355b',
        wsHost: window.location.hostname,
        wsPort: 443,
        wssPort: 443,
        encrypted: true,
        forceTLS: true,
        disableStats: true,
      });
}
