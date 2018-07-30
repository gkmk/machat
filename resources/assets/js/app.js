
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Snotify from 'vue-snotify'; // 1. Import Snotify

// 2. Use Snotify
// You can pass {config, options} as second argument. See the next example or setConfig in [API] section 
Vue.use(Snotify, { toast: { timeout: 5000 } })

Vue.use(require('vue-moment'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('chat-component', require('./components/ChatComponent.vue'));

const app = new Vue({
    el: '#app'
});
