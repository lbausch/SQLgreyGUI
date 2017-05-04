<template>
    <navbar>
        <button class="navbar-toggler mobile-sidebar-toggler hidden-lg-up" type="button" @click="mobileSidebarToggle">
            &#9776;
        </button>
        <a class="navbar-brand" href="/"></a>
        <ul class="nav navbar-nav hidden-md-down">
            <li class="nav-item">
                <a class="nav-link navbar-toggler sidebar-toggler" href="#" @click="sidebarToggle">&#9776;</a>
            </li>
            <!--<li class="nav-item px-1">
                <a class="nav-link" href="#">Dashboard</a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" href="#">Users</a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" href="#">Settings</a>
            </li>-->
        </ul>
        <ul class="nav navbar-nav ml-auto" style="margin-right:20px;">
            <!--<li class="nav-item hidden-md-down">
                <a class="nav-link" href="#">
                    <i class="icon-bell"></i><span class="badge badge-pill badge-danger">5</span>
                </a>
            </li>
            <li class="nav-item hidden-md-down">
                <a class="nav-link" href="#"><i class="icon-list"></i></a>
            </li>
            <li class="nav-item hidden-md-down">
                <a class="nav-link" href="#"><i class="icon-location-pin"></i></a>
            </li>-->

            <dropdown size="nav" class="nav-item">
                <span slot="button">
                    <!--<img src="/images/avatar.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">-->
                    <i class="fa fa-user"></i>
                    <span class="hidden-md-down">
                        <span v-if="$store.state.user.username">
                            {{ $store.state.user.username }} ({{ $store.state.user.email }})
                        </span>
                        <span v-else><i class="fa fa-spin fa-spinner"></i></span>
                    </span>
                </span>
                <div slot="dropdown-menu" class="dropdown-menu dropdown-menu-right">
                    <!--<div class="dropdown-header text-center"><strong>Account</strong></div>

                    <a class="dropdown-item" href="#">
                        <i class="fa fa-bell-o"></i> Updates<span class="badge badge-info">42</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-envelope-o"></i> Messages<span class="badge badge-success">42</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-tasks"></i> Tasks<span class="badge badge-danger">42</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-comments"></i> Comments<span class="badge badge-warning">42</span>
                    </a>

                    <div class="dropdown-header text-center"><strong>Settings</strong></div>

                    <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Profile</a>
                    <a class="dropdown-item" href="#"><i class="fa fa-wrench"></i> Settings</a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-usd"></i> Payments<span class="badge badge-default">42</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-file"></i> Projects<span class="badge badge-primary">42</span>
                    </a>-->

                    <div class="dropdown-header text-center"><strong>Settings</strong></div>

                    <router-link :to="'/settings/account'" class="dropdown-item" exact>
                        <i class="fa fa-user"></i> Account
                    </router-link>
                    <router-link :to="'/settings/api'" class="dropdown-item" exact>
                        <i class="fa fa-exchange"></i> API
                    </router-link>

                    <div class="divider"></div>

                    <!--<a class="dropdown-item" href="#"><i class="fa fa-shield"></i> Lock Account</a>-->

                    <div class="dropdown-header text-center"><strong>Account</strong></div>

                    <a class="dropdown-item" href="#" @click.prevent="doLogout"><i class="fa fa-lock"></i> Logout</a>
                </div>
            </dropdown>
            <!--<li class="nav-item hidden-md-down">
                <a class="nav-link navbar-toggler aside-menu-toggler" href="#" @click="asideToggle">&#9776;</a>
            </li>-->
        </ul>
        <form id="logout-form" method="POST" action="/logout">
            <input type="hidden" name="_token" :value="this.$parent.csrfToken">
        </form>
    </navbar>
</template>

<script>
  import navbar from './Navbar'
  import { dropdown } from 'vue-strap'

  export default {
    name: 'header',
    components: {
      navbar,
      dropdown
    },
    methods: {
      click () {
        // do nothing
      },
      sidebarToggle (e) {
        e.preventDefault()
        document.body.classList.toggle('sidebar-hidden')
      },
      mobileSidebarToggle (e) {
        e.preventDefault()
        document.body.classList.toggle('sidebar-mobile-show')
      },
      asideToggle (e) {
        e.preventDefault()
        document.body.classList.toggle('aside-menu-hidden')
      },
      doLogout (e) {
        document.getElementById('logout-form').submit()
      }
    }
  }
</script>
