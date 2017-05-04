<template>
    <div>
        <div class="card">
            <div class="card-header">Personal data</div>
            <div class="card-block">
                <form @submit="updatePersonalData">
                    <div class="form-group" :class="{ 'has-danger': errors.has('username') }">
                        <label>Name</label>
                        <div class="form-control-feedback" v-if="errors.has('username')">
                            {{ errors.first('username') }}
                        </div>
                        <input type="text" v-model="username" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group" :class="{ 'has-danger': errors.has('email') }">
                        <label>Email</label>
                        <div class="form-control-feedback" v-if="errors.has('email')">{{ errors.first('email') }}</div>
                        <input type="text" v-model="email" class="form-control" placeholder="Email">
                    </div>
                    <button type="submit" class="btn btn-default" :disabled="!username || !email"><i
                            class="fa fa-save"></i> Save
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Password </div>
            <div class="card-block">
                <form @submit="updatePassword">
                    <div class="form-group" :class="{ 'has-danger': errors.has('old_password') }">
                        <label>Current password</label>
                        <div class="form-control-feedback" v-if="errors.has('old_password')">
                            {{ errors.first('old_password') }}
                        </div>
                        <input type="password" v-model="password.old_password" class="form-control"
                               placeholder="Current password">
                    </div>
                    <div class="form-group" :class="{ 'has-danger': errors.has('password') }">
                        <label>New password</label>
                        <div class="form-control-feedback" v-if="errors.has('password')">
                            {{ errors.first('password') }}
                        </div>
                        <input type="password" v-model="password.password" class="form-control"
                               placeholder="New password">
                    </div>
                    <div class="form-group">
                        <label>Confirm new password</label>
                        <input type="password" v-model="password.password_confirmation" class="form-control"
                               placeholder="Confirm new password">
                    </div>
                    <button type="submit"
                            :disabled="!password.old_password || !password.password || !password.password_confirmation"
                            class="btn btn-default"><i class="fa fa-save"></i> Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
  import ValidationErrors from '../utils/ValidationErrors'

  export default {
    name: 'settings-account',
    components: {},
    mounted () {
    },
    data () {
      return {
        errors: new ValidationErrors(),
        personalData: {
          username: this.email,
          email: this.username
        },
        password: {
          old_password: null,
          password: null,
          password_confirmation: null
        }
      }
    },
    computed: {
      email: {
        get () {
          return this.personalData.email ? this.personalData.email : this.$store.state.user.email
        },
        set (value) {
          this.personalData.email = value
        }
      },
      username: {
        get () {
          return this.personalData.username ? this.personalData.username : this.$store.state.user.username
        },
        set (value) {
          this.personalData.username = value
        }
      },
    },
    methods: {
      updatePersonalData () {
        this.$events.$emit('loading', true)

        axios.patch('/api/v1/me', {
          username: this.username,
          email: this.email
        }).then((response) => {
          this.$store.commit('user', response.data.data)

          this.errors.clear()
          this.$alertSuccess('Personal data have been updated')
        }).catch((error) => {
          this.errors.set(error.response.data)
        }).then(() => {
          this.$events.$emit('loading', false)
        })
      },
      updatePassword () {
        this.$events.$emit('loading', true)

        axios.post('/api/v1/me/password', {
          old_password: this.password.old_password,
          password: this.password.password,
          password_confirmation: this.password.password_confirmation
        }).then((response) => {
          this.password.old_password = null
          this.password.password = null
          this.password.password_confirmation = null

          this.errors.clear()

          this.$alertSuccess('Password has been updated')
        }).catch((error) => {
          this.errors.set(error.response.data)
        }).then((response) => {
          this.$events.$emit('loading', false)
        })
      }
    }
  }
</script>
