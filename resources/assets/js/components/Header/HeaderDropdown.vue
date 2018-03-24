<template>
      <b-nav-item-dropdown right no-caret>
        <template slot="button-content">
          <!--<img src="static/img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">-->
          <i class="fa fa-user"></i>
          <span class="d-md-down-none" v-if="$store.state.user.username">{{ $store.state.user.username }} ({{ $store.state.user.email }})</span>
          <span class="d-md-down-none" v-else><i class="fa fa-spin fa-spinner"></i></span>
        </template>
        <!--<b-dropdown-header tag="div" class="text-center"><strong>Account</strong></b-dropdown-header>
        <b-dropdown-item><i class="fa fa-bell-o"></i> Updates<b-badge variant="info">{{itemsCount}}</b-badge></b-dropdown-item>
        <b-dropdown-item><i class="fa fa-envelope-o"></i> Messages<b-badge variant="success">{{itemsCount}}</b-badge></b-dropdown-item>
        <b-dropdown-item><i class="fa fa-tasks"></i> Tasks<b-badge variant="danger">{{itemsCount}}</b-badge></b-dropdown-item>
        <b-dropdown-item><i class="fa fa-comments"></i> Comments<b-badge variant="warning">{{itemsCount}}</b-badge></b-dropdown-item>
        <b-dropdown-header tag="div" class="text-center"><strong>Settings</strong></b-dropdown-header>
        <b-dropdown-item><i class="fa fa-user"></i> Profile</b-dropdown-item>
        <b-dropdown-item><i class="fa fa-wrench"></i> Settings</b-dropdown-item>
        <b-dropdown-item><i class="fa fa-usd"></i> Payments<b-badge variant="secondary">{{itemsCount}}</b-badge></b-dropdown-item>
        <b-dropdown-item><i class="fa fa-file"></i> Projects<b-badge variant="primary">{{itemsCount}}</b-badge></b-dropdown-item>
        <b-dropdown-divider></b-dropdown-divider>
        <b-dropdown-item><i class="fa fa-shield"></i> Lock Account</b-dropdown-item>
        <b-dropdown-item><i class="fa fa-lock"></i> Logout</b-dropdown-item>-->

        <b-dropdown-header tag="div" class="text-center"><strong>Settings</strong></b-dropdown-header>
        <router-link :to="'/settings/account'" class="dropdown-item" exact>
          <i class="fa fa-user"></i> Account
        </router-link>
        <router-link :to="'/settings/api'" class="dropdown-item" exact>
          <i class="fa fa-exchange"></i> API
        </router-link>
        <b-dropdown-divider></b-dropdown-divider>
        <a class="dropdown-item" href="#" @click.prevent="doLogout"><i class="fa fa-lock"></i> Logout</a>

      </b-nav-item-dropdown>
</template>
<script>
  export default {
    name: 'header-dropdown',
    data: () => {
      return { itemsCount: 42 }
    }
  }
</script>

