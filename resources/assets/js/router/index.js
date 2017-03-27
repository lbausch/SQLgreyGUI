import Vue from 'vue'
import VueRouter from 'vue-router'

// Containers
import Full from '../containers/Full'

// Views
import Dashboard from '../views/Dashboard'
import Greylist from '../views/Greylist'
import WhitelistEmails from '../views/WhitelistEmails'
import SettingsAccount from '../views/SettingsAccount'
import SettingsApi from '../views/SettingsApi'

Vue.use(VueRouter)

export default new VueRouter({
  mode: 'hash',
  linkActiveClass: 'open active',
  scrollBehavior: () => ({y: 0}), // scrollBehavior (to, from, savedPosition)
  routes: [
    {
      path: '/',
      redirect: '/dashboard',
      name: 'Home',
      component: Full,
      beforeEnter: (to, from, next) => {
        if (!window.Laravel.authenticated) {
          return next(false)
        }

        next()
      },
      children: [
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard
        },
        {
          path: 'greylist',
          name: 'Greylist',
          component: Greylist
        },
        {
          path: 'whitelist',
          redirect: '/whitelist/emails',
          name: 'Whitelist',
          component: {
            render (c) {
              return c('router-view')
            }
          },
          children: [
            {
              path: 'emails',
              name: 'Auto-Whitelist Emails',
              component: WhitelistEmails
            },
            {
              path: 'domains',
              name: 'Auto-Whitelist Domains',
              component: Greylist
            }
          ]
        },
        {
          path: 'optout',
          redirect: '/optout/emails',
          name: 'Opt-Out',
          component: {
            render (c) {
              return c('router-view')
            }
          },
          children: [
            {
              path: 'emails',
              name: 'Opt-Out Emails',
              component: Greylist
            },
            {
              path: 'domains',
              name: 'Opt-Out Domains',
              component: Greylist
            }
          ]
        },
        {
          path: 'optin',
          redirect: '/optin/emails',
          name: 'Opt-In',
          component: {
            render (c) {
              return c('router-view')
            }
          },
          children: [
            {
              path: 'emails',
              name: 'Opt-In Emails',
              component: Greylist
            },
            {
              path: 'domains',
              name: 'Opt-In Domains',
              component: Greylist
            }
          ]
        },
        {
          path: 'settings',
          redirect: '/settings/account',
          name: 'Settings',
          component: {
            render (c) {
              return c('router-view')
            }
          },
          children: [
            {
              path: 'account',
              name: 'Account',
              component: SettingsAccount
            },
            {
              path: 'api',
              name: 'API',
              component: SettingsApi
            }
          ]
        },
      ]
    },
    // catch all redirect
    // https://github.com/vuejs/vue-router/blob/dev/examples/redirect/app.js#L53-L54
    {path: '*', redirect: '/'}
  ]
})
