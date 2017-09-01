<template>
    <div>
        <div class="card">
            <div class="card-header"></div>
            <div class="card-block">
                <data-table ref="users" :columns="columns" :sorting="sorting" :columnEvents="columnEvents"
                            @itemsChecked="updateItemsChecked" @edit="editUser">
                    <div slot="controls">
                        <button class="btn btn-primary" @click="addUser">
                            <i class="fa fa-plus"></i> Add User
                        </button>
                        <button class="btn btn-default" @click="refresh">
                            <i class="fa fa-refresh"></i> Refresh
                        </button>
                        <button class="btn btn-danger" @click.prevent="deleteUsers"
                                :disabled="itemsChecked.length === 0">
                            <i class="fa fa-trash"></i> Delete <span v-if="itemsChecked.length > 0">
                            {{ itemsChecked.length}} {{ itemsChecked.length == 1 ? 'User' : 'Users' }}</span>
                        </button>
                    </div>
                </data-table>
            </div>
        </div>

        <b-modal v-model="modal.visible" :title="modal.title">
            <b-alert type="danger" v-if="errors.hasGeneral()">
                {{ errors.firstGeneral() }}
            </b-alert>

            <form @submit.prevent="submitUser">
                <div class="form-group" :class="{ 'has-danger': errors.has('username') }">
                    <label class="form-control-label">Username</label>
                    <input type="text" v-model="user.username" v-focus.lazy="modal.visible" class="form-control"
                           :class="{'is-invalid': errors.has('username')}" placeholder="Username">
                    <div v-if="errors.has('username')" class="invalid-feedback">
                        {{ errors.first('username') }}
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-danger': errors.has('email') }">
                    <label class="form-control-label">Email</label>
                    <input type="email" v-model="user.email" class="form-control"
                           :class="{'is-invalid': errors.has('email')}" placeholder="Email">
                    <div v-if="errors.has('email')" class="invalid-feedback">
                        {{ errors.first('email') }}
                    </div>
                </div>
                <div class="form-group" v-if="modal.mode === 'edit'">
                    <b-alert type="info">
                        <i class="fa fa-info-circle"></i>
                        If you don't want to change the password leave the corresponding fields empty
                    </b-alert>
                </div>
                <div class="form-group" :class="{ 'has-danger': errors.has('password') }">
                    <label class="form-control-label">Password</label>
                    <input type="password" v-model="user.password" class="form-control"
                           :class="{'is-invalid': errors.has('password')}" placeholder="Password">
                    <div v-if="errors.has('password')" class="invalid-feedback">
                        {{ errors.first('password') }}
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-danger': errors.has('password_confirmation') }">
                    <label class="form-control-label">Confirm Password</label>
                    <input type="password" v-model="user.password_confirmation" class="form-control"
                           :class="{'is-invalid': errors.has('password_confirmation')}" placeholder="Confirm Password">
                    <div v-if="errors.has('password_confirmation')" class="invalid-feedback">
                        {{ errors.first('password_confirmation') }}
                    </div>
                </div>
                <div class="form-check" :class="{ 'has-danger': errors.has('enabled') }">
                    <label class="form-check-label">
                        <input class="form-check-input" :class="{'is-invalid': errors.has('enabled')}"
                               type="checkbox" v-model="user.enabled" value="yes"> Enabled
                    </label>
                    <div v-if="errors.has('enabled')" class="invalid-feedback">
                        {{ errors.first('enabled') }}
                    </div>
                </div>

                <button type="submit" class="d-none"></button>
            </form>

            <div slot="modal-footer">
                <button class="btn btn-primary" @click.prevent="submitUser">{{ modal.submitButtonText }}</button>
                <button class="btn btn-default" @click.prevent="modal.visible = false">Cancel</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
  import DataTable from '../components/DataTable'
  import ValidationErrors from '../utils/ValidationErrors'

  export default {
    name: 'users',
    components: {
      DataTable
    },
    data () {
      return {
        columns: {
          id: 'ID',
          username: 'Username',
          email: 'Email',
          enabled: 'Enabled',
          created_at: 'Created At',
          updated_at: 'Updated At'
        },
        columnEvents: {
          username: 'edit'
        },
        sorting: {
          column: 'id',
          order: 'asc'
        },
        user: {
          username: '',
          email: '',
          enabled: true,
          password: '',
          password_confirmation: ''
        },
        errors: new ValidationErrors(),
        modal: {
          mode: null,
          api: '',
          method: '',
          title: '',
          submitButtonText: '',
          successMessage: '',
          visible: false
        },
        itemsChecked: []
      }
    },
    mounted () {
      this.prepareComponent()
    },
    methods: {
      prepareComponent () {
        this.fetchUsers()

        this.$nextTick(() => {
          this.$events.$emit('loading', true)
        })
      },
      fetchUsers () {
        this.$events.$emit('loading', true)

        axios.get('/api/v1/users').then((response) => {
          this.$refs.users.setItems(response.data.data)
        }).catch((error) => {

        }).then((response) => {
          this.$events.$emit('loading', false)
        })
      },
      refresh () {
        this.fetchUsers()
      },
      updateItemsChecked (items) {
        this.itemsChecked = items
      },
      clearUser () {
        this.user.username = ''
        this.user.email = ''
        this.user.enabled = true
        this.user.password = ''
        this.user.password_confirmation = ''
      },
      addUser () {
        this.modal.mode = 'add'
        this.modal.api = '/api/v1/user'
        this.modal.method = 'post'
        this.modal.title = 'Add User'
        this.modal.submitButtonText = 'Add User'
        this.modal.successMessage = 'User has been added'
        this.modal.visible = true
      },
      editUser (user) {
        this.modal.mode = 'edit'
        this.modal.api = '/api/v1/user/' + user.id
        this.modal.method = 'put'
        this.modal.title = 'Edit User'
        this.modal.submitButtonText = 'Update User'
        this.modal.successMessage = 'User has been updated'

        // Set User data
        this.user.username = user.username
        this.user.email = user.email
        this.user.enabled = user.enabled

        this.modal.visible = true
      },
      submitUser () {
        this.$events.$emit('loading', true)

        axios.request({
          method: this.modal.method,
          url: this.modal.api,
          data: this.user
        }).then((response) => {
          this.modal.visible = false
          this.$alertSuccess(this.modal.successMessage)
          this.fetchUsers()
          this.clearUser()
        }).catch((error) => {
          this.errors.set(error.response.data)
          this.$events.$emit('loading', false)
        }).then((response) => {
          //
        })
      },
      deleteUsers () {
        this.$events.$emit('loading', true)

        axios.post('/api/v1/users/delete', {
          userids: this.itemsChecked
        }).then((response) => {
          this.fetchUsers()
        }).catch((error) => {
          console.log(error)
          this.$events.$emit('loading', false)
        }).then((response) => {
          //
        })
      }
    }
  }
</script>
