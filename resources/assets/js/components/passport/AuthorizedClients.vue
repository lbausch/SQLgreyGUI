<template>
    <div>
        <div v-if="tokens.length > 0">
            <!-- Authorized Tokens -->
            <table class="table table-borderless m-b-none">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Scopes</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="token in tokens">
                    <!-- Client Name -->
                    <td style="vertical-align: middle;">
                        {{ token.client.name }}
                    </td>

                    <!-- Scopes -->
                    <td style="vertical-align: middle;">
                                    <span v-if="token.scopes.length > 0">
                                        {{ token.scopes.join(', ') }}
                                    </span>
                    </td>

                    <!-- Revoke Button -->
                    <td style="vertical-align: middle;">
                        <a class="action-link text-danger" @click="revoke(token)">
                            Revoke
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <p v-else>No authorized applications.</p>
    </div>
</template>

<script>
  export default {
    /**
     * The component's data.
     */
    data () {
      return {
        tokens: []
      }
    },

    /**
     * Prepare the component (Vue 2.x).
     */
    mounted () {
      this.prepareComponent()
    },

    methods: {
      /**
       * Prepare the component (Vue 2.x).
       */
      prepareComponent () {
        this.getTokens()
      },

      /**
       * Get all of the authorized tokens for the user.
       */
      getTokens () {
        axios.get('/oauth/tokens')
          .then((response) => {
            this.tokens = response.data
          })
      },

      /**
       * Revoke the given token.
       */
      revoke (token) {
        axios.delete('/oauth/tokens/' + token.id)
          .then((response) => {
            this.getTokens()
          })
      }
    }
  }
</script>
