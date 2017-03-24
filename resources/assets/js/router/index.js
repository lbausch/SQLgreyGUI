import Vue from 'vue'
import VueRouter from 'vue-router'

// Containers
import Full from '../containers/Full'

// Views
import Dashboard from '../views/Dashboard'
import Greylist from '../views/Greylist'
import SettingsApi from '../views/SettingsApi'

/* import Charts from '../views/Charts'
 import Widgets from '../views/Widgets'

 // Views - Components
 import Buttons from '../views/components/Buttons'
 import SocialButtons from '../views/components/SocialButtons'
 import Cards from '../views/components/Cards'
 import Forms from '../views/components/Forms'
 import Modals from '../views/components/Modals'
 import Switches from '../views/components/Switches'
 import Tables from '../views/components/Tables'

 // Views - Icons
 import FontAwesome from '../views/icons/FontAwesome'
 import SimpleLineIcons from '../views/icons/SimpleLineIcons'

 // Views - Pages
 import Page404 from '../views/pages/Page404'
 import Page500 from '../views/pages/Page500'
 import Login from '../views/pages/Login'
 import Register from '../views/pages/Register'*/

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
                            component: Greylist
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
                    redirect: '/settings/api',
                    name: 'Settings',
                    component: {
                        render (c) {
                            return c('router-view')
                        }
                    },
                    children: [
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
