<template>
    <div class="app">
        <AppHeader/>

        <div class="app-body">
            <Sidebar/>

            <main class="main">
                <breadcrumb :list="list"/>

                <div class="container-fluid">
                    <router-view></router-view>
                </div>
            </main>

            <AppAside/>
        </div>

        <AppFooter/>

        <div id="cssload-modal" v-if="loading">
            <div id="cssload-global">

                <div id="cssload-top" class="cssload-mask">
                    <div class="cssload-plane"></div>
                </div>
                <div id="cssload-middle" class="cssload-mask">
                    <div class="cssload-plane"></div>
                </div>

                <div id="cssload-bottom" class="cssload-mask">
                    <div class="cssload-plane"></div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import AppHeader from '../components/Header'
    import Sidebar from '../components/Sidebar'
    import AppAside from '../components/Aside'
    import AppFooter from '../components/Footer'
    import Breadcrumb from '../components/Breadcrumb'

    export default {
        name: 'full',
        components: {
            AppHeader,
            Sidebar,
            AppAside,
            AppFooter,
            Breadcrumb,
        },
        mounted() {
            this.$events.$on('loading', (status) => {
                if (status == true) {
                    this.loading = true;
                } else {
                    this.loading = false;
                }
            });
        },
        data() {
            return {
                authenticated: window.Laravel.authenticated,
                csrfToken: window.Laravel.csrfToken,
                loading: false,
            }
        },
        computed: {
            name () {
                return this.$route.name
            },
            list () {
                return this.$route.matched
            }
        }
    }
</script>
