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

        <div id="loader-modal" v-if="loading">
            <div class="loader-modal-content">
                <div class="loader" v-if="loading">Loading...</div>
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

            this.getUser();
        },
        data() {
            return {
                // @TODO: Move to vuex
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
        },
        methods: {
            getUser() {
                axios.get('/api/v1/me')
                    .then((response) => {
                        this.$store.commit('user', response.data.data)
                    })
            },
        },
    }
</script>
