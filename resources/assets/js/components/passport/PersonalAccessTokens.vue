<template>
    <div>
        <button @click="showCreateTokenForm()" type="button" class="btn btn-primary">Create New Token</button>

        <br><br>

        <!-- No Tokens Notice -->
        <p class="m-b-none" v-if="tokens.length === 0">
            You have not created any personal access tokens.
        </p>

        <!-- Personal Access Tokens -->
        <table class="table table-borderless m-b-none" v-if="tokens.length > 0">
            <thead>
            <tr>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="token in tokens">
                <!-- Client Name -->
                <td style="vertical-align: middle;">
                    {{ token.name }}
                </td>

                <!-- Delete Button -->
                <td style="vertical-align: middle;">
                    <a class="action-link text-danger" @click="revoke(token)">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Create Token Modal -->
        <modal v-model="showCreateTokenModal" title="Create Token" @ok="showCreateTokenModal = false">
            <!-- Form Errors -->
            <div class="alert alert-danger" v-if="form.errors.length > 0">
                <p><strong>Whoops!</strong> Something went wrong!</p>
                <br>
                <ul>
                    <li v-for="error in form.errors">
                        {{ error }}
                    </li>
                </ul>
            </div>

            <!-- Create Token Form -->
            <form class="form-horizontal" role="form" @submit.prevent="store">
                <!-- Name -->
                <div class="form-group">
                    <label class="control-label">Name</label>

                    <input v-focus.lazy="showCreateTokenModal" type="text" class="form-control" name="name"
                           v-model="form.name">
                </div>

                <!-- Scopes -->
                <div class="form-group" v-if="scopes.length > 0">
                    <label class="col-md-4 control-label">Scopes</label>

                    <div class="col-md-6">
                        <div v-for="scope in scopes">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" @click="toggleScope(scope.id)"
                                           :checked="scopeIsAssigned(scope.id)">
                                    {{ scope.id }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Modal Actions -->
            <div slot="modal-footer" class="modal-footer">
                <button type="button" class="btn btn-default" @click="showCreateTokenModal = false">Cancel</button>
                <button type="button" class="btn btn-primary" @click="store">Create Token</button>
            </div>
        </modal>


        <!-- Access Token Modal -->
        <modal v-model="showAccessTokenModal" title="Personal Access Token" @ok="showAccessTokenModal = false">
            <p>
                Here is your new personal access token. This is the only time it will be shown so don't lose
                it!
                You may now use this token to make API requests.
            </p>

            <pre><code>{{ accessToken }}</code></pre>

            <!-- Modal Actions -->
            <div slot="modal-footer" class="modal-footer">
                <button type="button" class="btn btn-default" @click="showAccessTokenModal = false">Close</button>
            </div>
        </modal>
    </div>
</template>

<script>
  import modal from 'vue-strap/src/Modal'

  export default {
    /**
     * The component's data.
     */
    data () {
      return {
        showCreateTokenModal: false,
        showAccessTokenModal: false,

        accessToken: null,

        tokens: [],
        scopes: [],

        form: {
          name: '',
          scopes: [],
          errors: []
        }
      }
    },

    /**
     * Prepare the component (Vue 2.x).
     */
    mounted () {
      this.prepareComponent()
    },

    components: {
      modal
    },

    methods: {
      /**
       * Prepare the component.
       */
      prepareComponent () {
        this.getTokens()
        this.getScopes()
      },

      /**
       * Get all of the personal access tokens for the user.
       */
      getTokens () {
        axios.get('/oauth/personal-access-tokens')
          .then((response) => {
            this.tokens = response.data
          })
      },

      /**
       * Get all of the available scopes.
       */
      getScopes () {
        axios.get('/oauth/scopes')
          .then((response) => {
            this.scopes = response.data
          })
      },

      /**
       * Show the form for creating new tokens.
       */
      showCreateTokenForm () {
        this.showCreateTokenModal = true
      },

      /**
       * Create a new personal access token.
       */
      store () {
        this.accessToken = null

        this.form.errors = []

        axios.post('/oauth/personal-access-tokens', this.form).then((response) => {
          this.showCreateTokenModal = false

          this.form.name = ''
          this.form.scopes = []
          this.form.errors = []

          this.tokens.push(response.data.token)

          this.showAccessToken(response.data.accessToken)
        }).catch(error => {
          if (typeof error.response.data === 'object') {
            this.form.errors = _.flatten(_.toArray(error.response.data))
          } else {
            this.form.errors = ['Something went wrong. Please try again.']
          }
        })
      },

      /**
       * Toggle the given scope in the list of assigned scopes.
       */
      toggleScope (scope) {
        if (this.scopeIsAssigned(scope)) {
          this.form.scopes = _.reject(this.form.scopes, s => s === scope)
        } else {
          this.form.scopes.push(scope)
        }
      },

      /**
       * Determine if the given scope has been assigned to the token.
       */
      scopeIsAssigned (scope) {
        return _.indexOf(this.form.scopes, scope) >= 0
      },

      /**
       * Show the given access token to the user.
       */
      showAccessToken (accessToken) {
        this.showCreateTokenModal = false

        this.accessToken = accessToken

        this.showAccessTokenModal = true
      },

      /**
       * Revoke the given token.
       */
      revoke (token) {
        axios.delete('/oauth/personal-access-tokens/' + token.id)
          .then((response) => {
            this.getTokens()
          })
      }
    }
  }
</script>
