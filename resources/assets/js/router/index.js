import Vue from 'vue'
import Router from 'vue-router'

// Containers
import Full from '../containers/Full'

// Views
import Dashboard from '../views/Dashboard'
import Greylist from '../views/Greylist'
import WhitelistEmails from '../views/WhitelistEmails'
import WhitelistDomains from '../views/WhitelistDomains'
import OptInEmails from '../views/OptInEmails'
import OptOutEmails from '../views/OptOutEmails'
import OptInDomains from '../views/OptInDomains'
import OptOutDomains from '../views/OptOutDomains'
import SettingsAccount from '../views/SettingsAccount'
import SettingsApi from '../views/SettingsApi'
import Users from '../views/Users'

Vue.use(Router)

export default new Router({
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
              component: WhitelistDomains
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
              component: OptOutEmails
            },
            {
              path: 'domains',
              name: 'Opt-Out Domains',
              component: OptOutDomains
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
              component: OptInEmails
            },
            {
              path: 'domains',
              name: 'Opt-In Domains',
              component: OptInDomains
            }
          ]
        },
        {
          path: 'admin',
          redirect: '/admin/users',
          name: 'Administration',
          component: {
            render (c) {
              return c('router-view')
            }
          },
          children: [
            {
              path: 'users',
              name: 'Users',
              component: Users
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
        }
      ]
    },
    // catch all redirect
    // https://github.com/vuejs/vue-router/blob/dev/examples/redirect/app.js#L53-L54
    {path: '*', redirect: '/'}
  ]
})
