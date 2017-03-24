import Vue from 'vue'
import App from './App'
import VueEvents from 'vue-events'
import VueRouter from './router'

window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

import {focus} from 'vue-focus'

Vue.directive('focus', focus)
Vue.use(VueEvents)

/* eslint-disable no-new */
let vue = new Vue({
    el: '#app',
    router: VueRouter,
    directives: {focus: focus},
    template: '<App/>',
    components: {App},
});
