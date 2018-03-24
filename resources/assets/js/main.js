import Vue from 'vue'
import App from './App'
import BootstrapVue from 'bootstrap-vue'
import VueEvents from 'vue-events'
import router from './router'
import Vuex from 'vuex'
import VueSweetAlert from 'vue-sweetalert'
import Alert from './utils/Alert'
import { focus } from 'vue-focus'

window._ = require('lodash')
window.axios = require('axios')

window.axios.defaults.headers.common = {
  'Accept': 'application/json',
  'X-CSRF-TOKEN': window.Laravel.csrfToken,
  'X-Requested-With': 'XMLHttpRequest'
}

Vue.directive('focus', focus)

Vue.use(BootstrapVue)
Vue.use(VueEvents)
Vue.use(Vuex)
Vue.use(VueSweetAlert)
Vue.use(Alert)

const store = new Vuex.Store({
  state: {
    user: {}
  },
  getters: {
    // user: state => {
    //     return state.user
    // }
  },
  mutations: {
    user (state, user) {
      state.user = user
    }
  }
})

/* eslint-disable no-new, no-unused-vars */
let vue = new Vue({
  el: '#app',
  router,
  store,
  directives: {focus: focus},
  template: '<App/>',
  components: {App}
})
