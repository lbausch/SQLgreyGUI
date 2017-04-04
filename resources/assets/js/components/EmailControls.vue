<template>
    <div>
        <button class="btn btn-primary" @click.prevent="addModalVisible = true">
            <i class="fa fa-plus"></i> Add Email
        </button>
        <button class="btn btn-default" @click.prevent="refresh">
            <i class="fa fa-refresh"></i> Refresh
        </button>
        <button class="btn btn-danger" :disabled="itemsChecked.length === 0" @click="deleteItems">
            <i class="fa fa-trash"></i> Delete <span
                v-if="itemsChecked.length > 0">{{ itemsChecked.length}} {{ itemsChecked.length == 1 ? 'Record' : 'Records'
            }}</span>
        </button>

        <modal v-model="addModalVisible" title="Add Email Address">
            <alert type="danger" v-if="errors.hasGeneral()">
                {{ errors.firstGeneral() }}
            </alert>

            <form @submit.prevent="addItem">
                <div class="form-group" :class="{ 'has-danger': errors.has('email') }">
                    <label class="form-control-label">Email Address</label>
                    <div v-if="errors.has('email')" class="form-control-feedback">
                        {{ errors.first('email') }}
                    </div>
                    <input type="text" name="email" v-model="email" v-focus.lazy="addModalVisible" class="form-control"
                           placeholder="Email Address">
                </div>
                <button type="submit" class="hidden-xs-up"></button>
            </form>

            <div slot="modal-footer" class="modal-footer">
                <button type="button" class="btn btn-primary" @click.prevent="addItem">Add Email Address
                </button>
                <button type="button" class="btn btn-default" @click.prevent="addModalVisible = false">
                    Cancel
                </button>
            </div>
        </modal>
    </div>
</template>

<script>
  import alert from 'vue-strap/src/Alert'
  import modal from 'vue-strap/src/Modal'
  import ValidationErrors from '../utils/ValidationErrors'

  export default {
    name: 'email-controls',
    components: {
      alert,
      modal
    },
    props: [
      'api',
      'itemsChecked'
    ],
    data () {
      return {
        addModalVisible: false,
        email: '',
        errors: new ValidationErrors()
      }
    },
    mounted () {
    },
    methods: {
      refresh () {
        this.$emit('refresh')
      },
      addItem () {
        this.$events.$emit('loading', true)

        axios.post(this.api.addItemEndpoint, {
          email: this.email
        }).then((response) => {
          this.email = ''
          this.errors.clear()

          this.$events.$emit('loading', false)
          this.addModalVisible = false

          this.$emit('add', this.email)

          this.$alertSuccess('Email address has been added')
        }).catch((error) => {
          this.errors.set(error.response.data)

          this.$events.$emit('loading', false)
        })
      },
      deleteItems () {
        this.$events.$emit('loading', true)

        axios.post(this.api.deleteItemsEndpoint, {
          items: this.itemsChecked
        }).then((response) => {
          this.$events.$emit('loading', false)

          this.$emit('delete')
        }).catch((error) => {
          this.errors.set(error.response.data)

          this.$events.$emit('loading', false)
        })
      }
    }
  }
</script>
