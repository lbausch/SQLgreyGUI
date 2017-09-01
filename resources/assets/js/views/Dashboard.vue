<template>
    <div class="row">
        <div class="col-xs-6 col-lg-3">
            <b-card no-block footer-class="px-3 py-2">
                <div class="card-body p-1 clearfix">
                    <i class="fa fa-clock-o bg-primary p-3 font-2xl mr-3 float-left"></i>
                    <div class="h5 text-right mb-0 mt-2">
                        <span v-if="loading" class="fa fa-spin fa-spinner"></span>
                        <span v-else>{{ stats.greylist }}</span>
                    </div>
                    <div class="text-muted text-right text-uppercase font-weight-bold font-xs">Greylist</div>
                </div>
                <div slot="footer">
                    <router-link :to="'/greylist'" class="font-weight-bold font-xs btn-block text-muted" exact>
                        View Details <i class="fa fa-angle-right float-right font-lg"></i>
                    </router-link>
                </div>
            </b-card>
        </div>

        <div class="col-xs-6 col-lg-3">
            <b-card no-block footer-class="px-3 py-2">
                <div class="card-body p-1 clearfix">
                    <i class="fa fa-thumbs-up bg-warning p-3 font-2xl mr-3 float-left"></i>
                    <div class="h5 text-right mb-0 mt-2">
                        <span v-if="loading" class="fa fa-spin fa-spinner"></span>
                        <span v-else>{{ stats.awl_emails }} / {{ stats.awl_domains }}</span>
                    </div>
                    <div class="text-muted text-uppercase text-right font-weight-bold font-xs">Auto-Whitelist</div>
                </div>
                <div slot="footer">
                    <router-link :to="'/whitelist/emails'" class="font-weight-bold font-xs btn-block text-muted" exact>
                        View Emails <i class="fa fa-angle-right pull-right font-lg"></i>
                    </router-link>
                    <router-link :to="'/whitelist/domains'" class="font-weight-bold font-xs btn-block text-muted" exact>
                        View Domains <i class="fa fa-angle-right pull-right font-lg"></i>
                    </router-link>
                </div>
            </b-card>
        </div>

        <div class="col-xs-6 col-lg-3">
            <b-card no-block footer-class="px-3 py-2">
                <div class="card-body p-1 clearfix">
                    <i class="fa fa-minus-square bg-danger p-3 font-2xl mr-3 float-left"></i>
                    <div class="h5 text-right mb-0 mt-2">
                        <span v-if="loading" class="fa fa-spin fa-spinner"></span>
                        <span v-else>{{ stats.optout_emails }} / {{ stats.optout_domains }}</span>
                    </div>
                    <div class="text-muted text-uppercase text-right font-weight-bold font-xs">Opt-Out</div>
                </div>
                <div slot="footer">
                    <router-link :to="'/optout/emails'" class="font-weight-bold font-xs btn-block text-muted" exact>
                        View Emails <i class="fa fa-angle-right pull-right font-lg"></i>
                    </router-link>
                    <router-link :to="'/optout/domains'" class="font-weight-bold font-xs btn-block text-muted"
                                 exact>
                        View Domains <i class="fa fa-angle-right pull-right font-lg"></i>
                    </router-link>
                </div>
            </b-card>
        </div>

        <div class="col-xs-6 col-lg-3">
            <b-card no-block footer-class="px-3 py-2">
                <div class="card-body p-1 clearfix">
                    <i class="fa fa-plus-square bg-success p-3 font-2xl mr-3 float-left"></i>
                    <div class="h5 text-right mb-0 mt-2">
                        <span v-if="loading" class="fa fa-spin fa-spinner"></span>
                        <span v-else>{{ stats.optin_emails }} / {{ stats.optin_domains }}</span>
                    </div>
                    <div class="text-muted text-uppercase text-right font-weight-bold font-xs">Opt-In</div>
                </div>
                <div slot="footer">
                    <router-link :to="'/optin/emails'" class="font-weight-bold font-xs btn-block text-muted" exact>
                        View Emails <i class="fa fa-angle-right pull-right font-lg"></i>
                    </router-link>
                    <router-link :to="'/optin/domains'" class="font-weight-bold font-xs btn-block text-muted" exact>
                        View Domains <i class="fa fa-angle-right pull-right font-lg"></i>
                    </router-link>
                </div>
            </b-card>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'dashboard',
    components: {},
    data () {
      return {
        loading: true,
        pollTimer: null,
        stats: []
      }
    },
    mounted () {
      this.prepareComponent()

      this.pollTimer = setInterval(function () {
        this.getStats()
      }.bind(this), 30000)
    },
    beforeDestroy () {
      if (this.pollTimer) {
        clearInterval(this.pollTimer)
      }
    },
    methods: {
      prepareComponent () {
        this.getStats()
      },
      getStats () {
        this.loading = true

        axios.get('/api/v1/stats')
          .then((response) => {
            this.stats = response.data.data
            this.loading = false
          })
      }
    }
  }
</script>
