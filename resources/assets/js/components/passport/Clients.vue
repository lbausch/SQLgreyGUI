<template>
    <div>
        <button @click="showCreateClientForm()" type="button" class="btn btn-primary">Create New Client</button>

        <br><br>

        <!-- Current Clients -->
        <p class="m-b-none" v-if="clients.length === 0">
            You have not created any OAuth clients.
        </p>

        <table class="table table-borderless m-b-none" v-if="clients.length > 0">
            <thead>
            <tr>
                <th>Client ID</th>
                <th>Name</th>
                <th>Secret</th>
                <th></th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="client in clients">
                <!-- ID -->
                <td style="vertical-align: middle;">
                    {{ client.id }}
                </td>

                <!-- Name -->
                <td style="vertical-align: middle;">
                    {{ client.name }}
                </td>

                <!-- Secret -->
                <td style="vertical-align: middle;">
                    <code>{{ client.secret }}</code>
                </td>

                <!-- Edit Button -->
                <td style="vertical-align: middle;">
                    <a class="action-link" @click="edit(client)">
                        Edit
                    </a>
                </td>

                <!-- Delete Button -->
                <td style="vertical-align: middle;">
                    <a class="action-link text-danger" @click="destroy(client)">
                        Delete
                    </a>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Create Client Modal -->
        <b-modal v-model="showCreateClientModal" title="Create Client" @ok="showCreateClientModal = false">
            <!-- Form Errors -->
            <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                <p><strong>Whoops!</strong> Something went wrong!</p>
                <br>
                <ul>
                    <li v-for="error in createForm.errors">
                        {{ error }}
                    </li>
                </ul>
            </div>

            <!-- Create Client Form -->
            <form class="form-horizontal" role="form">
                <!-- Name -->
                <div class="form-group">
                    <label class="control-label">Name</label>

                    <input id="create-client-name" v-focus.lazy="showCreateClientModal" type="text"
                           class="form-control"
                           @keyup.enter="store" v-model="createForm.name">

                    <span class="help-block">
                            Something your users will recognize and trust.
                        </span>
                </div>

                <!-- Redirect URL -->
                <div class="form-group">
                    <label class="control-label">Redirect URL</label>

                    <input type="text" class="form-control" name="redirect" @keyup.enter="store"
                           v-model="createForm.redirect">

                    <span class="help-block">
                            Your application's authorization callback URL.
                        </span>
                </div>
            </form>

            <!-- Modal Actions -->
            <div slot="modal-footer" class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"
                        @click="showCreateClientModal = false">Close
                </button>

                <button type="button" class="btn btn-primary" @click="store">
                    Create
                </button>
            </div>
        </b-modal>

        <!-- Edit Client Modal -->
        <b-modal v-model="showEditClientModal" title="Edit Client" @ok="showEditClientModal = false">
            <!-- Form Errors -->
            <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                <p><strong>Whoops!</strong> Something went wrong!</p>
                <br>
                <ul>
                    <li v-for="error in editForm.errors">
                        {{ error }}
                    </li>
                </ul>
            </div>

            <!-- Edit Client Form -->
            <form class="form-horizontal" role="form">
                <!-- Name -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Name</label>

                    <div class="col-md-7">
                        <input id="edit-client-name" type="text" class="form-control"
                               @keyup.enter="update" v-model="editForm.name">

                        <span class="help-block">
                            Something your users will recognize and trust.
                        </span>
                    </div>
                </div>

                <!-- Redirect URL -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Redirect URL</label>

                    <div class="col-md-7">
                        <input type="text" class="form-control" name="redirect"
                               @keyup.enter="update" v-model="editForm.redirect">

                        <span class="help-block">
                            Your application's authorization callback URL.
                        </span>
                    </div>
                </div>
            </form>

            <!-- Modal Actions -->
            <div slot="modal-footer" class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"
                        @click="showEditClientModal = false">Close
                </button>

                <button type="button" class="btn btn-primary" @click="update">
                    Save Changes
                </button>
            </div>
        </b-modal>
    </div>
</template>

<script>
  export default {
    /**
     * The component's data.
     */
    data () {
      return {
        showCreateClientModal: false,
        showEditClientModal: false,

        clients: [],

        createForm: {
          errors: [],
          name: '',
          redirect: ''
        },

        editForm: {
          errors: [],
          name: '',
          redirect: ''
        }
      }
    },
    components: {},

    /**
     * Prepare the component (Vue 2.x).
     */
    mounted () {
      this.prepareComponent()
    },

    methods: {
      /**
       * Prepare the component.
       */
      prepareComponent () {
        this.getClients()
      },

      /**
       * Get all of the OAuth clients for the user.
       */
      getClients () {
        axios.get('/oauth/clients')
          .then(response => {
            this.clients = response.data
          })
      },

      /**
       * Show the form for creating new clients.
       */
      showCreateClientForm () {
        this.showCreateClientModal = true
      },

      /**
       * Create a new OAuth client for the user.
       */
      store () {
        this.persistClient(
          'post', '/oauth/clients',
          this.createForm
        )
      },

      /**
       * Edit the given client.
       */
      edit (client) {
        this.editForm.id = client.id
        this.editForm.name = client.name
        this.editForm.redirect = client.redirect
      },

      /**
       * Update the client being edited.
       */
      update () {
        this.persistClient(
          'put', '/oauth/clients/' + this.editForm.id,
          this.editForm
        )
      },

      /**
       * Persist the client to storage using the given form.
       */
      persistClient (method, uri, form) {
        form.errors = []

        axios[method](uri, form)
          .then(response => {
            this.getClients()

            form.name = ''
            form.redirect = ''
            form.errors = []

            this.showCreateClientModal = false
            this.showEditClientModal = false
          })
          .catch(error => {
            if (typeof error.response.data === 'object') {
              form.errors = _.flatten(_.toArray(error.response.data))
            } else {
              form.errors = ['Something went wrong. Please try again.']
            }
          })
      },

      /**
       * Destroy the given client.
       */
      destroy (client) {
        axios.delete('/oauth/clients/' + client.id)
          .then(response => {
            this.getClients()
          })
      }
    }
  }
</script>
