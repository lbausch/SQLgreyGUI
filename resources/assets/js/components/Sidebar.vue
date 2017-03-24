<template>
    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav">
                <li class="nav-item">
                    <router-link :to="'/dashboard'" class="nav-link">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="'/greylist'" class="nav-link">
                        <i class="fa fa-clock-o"></i> Greylist
                    </router-link>
                </li>
                <router-link tag="li" class="nav-item nav-dropdown" :to="{ path: '/whitelist'}" disabled>
                    <div class="nav-link nav-dropdown-toggle" @click="handleClick">
                        <i class="fa fa-thumbs-up"></i>Auto-Whitelist
                    </div>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <router-link :to="'/whitelist/emails'" class="nav-link" exact>
                                <i class="fa fa-envelope"></i> Emails
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/whitelist/domains'" class="nav-link" exact>
                                <i class="fa fa-globe"></i> Domains
                            </router-link>
                        </li>
                    </ul>
                </router-link>
                <router-link tag="li" class="nav-item nav-dropdown" :to="{ path: '/optout'}" disabled>
                    <div class="nav-link nav-dropdown-toggle" @click="handleClick">
                        <i class="fa fa-minus-square"></i> Opt-Out
                    </div>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <router-link :to="'/optout/emails'" class="nav-link" exact>
                                <i class="fa fa-envelope"></i> Emails
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/optout/domains'" class="nav-link" exact>
                                <i class="fa fa-globe"></i> Domains
                            </router-link>
                        </li>
                    </ul>
                </router-link>
                <router-link tag="li" class="nav-item nav-dropdown" :to="{ path: '/optin'}" disabled>
                    <div class="nav-link nav-dropdown-toggle" @click="handleClick">
                        <i class="fa fa-plus-square"></i> Opt-In
                    </div>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <router-link :to="'/optin/emails'" class="nav-link" exact>
                                <i class="fa fa-envelope"></i> Emails
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/optin/domains'" class="nav-link" exact>
                                <i class="fa fa-globe"></i> Domains
                            </router-link>
                        </li>
                    </ul>
                </router-link>
                <router-link tag="li" class="nav-item nav-dropdown" :to="{ path: '/admin'}" disabled>
                    <div class="nav-link nav-dropdown-toggle" @click="handleClick">
                        <i class="fa fa-wrench"></i> Administration
                    </div>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <router-link :to="'/admin/users'" class="nav-link" exact>
                                <i class="fa fa-group"></i> Users
                            </router-link>
                        </li>
                    </ul>
                </router-link>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        name: 'sidebar',
        methods: {
            handleClick (e) {
                e.preventDefault()
                e.target.parentElement.classList.toggle('open')
            }
        }
    }
</script>

<style lang="css">
    .nav-link {
        cursor: pointer;
    }
</style>
