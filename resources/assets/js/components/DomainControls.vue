<template>
    <div>
        <button class="btn btn-primary" @click.prevent="addModalVisible = true">
            <i class="fa fa-plus"></i> Add Domain
        </button>
        <button class="btn btn-default" @click.prevent="refresh">
            <i class="fa fa-refresh"></i> Refresh
        </button>
        <button class="btn btn-danger" :disabled="itemsChecked.length === 0" @click="deleteItems">
            <i class="fa fa-trash"></i> Delete <span
                v-if="itemsChecked.length > 0">{{ itemsChecked.length}} {{ itemsChecked.length == 1 ? 'Record' : 'Records'
            }}</span>
        </button>

        <b-modal v-model="addModalVisible" title="Add Email Address">
            <b-alert type="danger" v-if="errors.hasGeneral()">
                {{ errors.firstGeneral() }}
            </b-alert>

            <form @submit.prevent="addItem">
                <div class="form-group" :class="{ 'has-danger': errors.has('domain') }">
                    <label class="form-control-label">Domain</label>
                    <input type="text" name="email" v-model="domain" v-focus.lazy="addModalVisible" class="form-control"
                           :class="{'is-invalid': errors.has('domain')}" placeholder="Domain">
                    <div v-if="errors.has('domain')" class="invalid-feedback">
                        {{ errors.first('domain') }}
                    </div>
                </div>
                <button type="submit" class="d-none"></button>
            </form>

            <div slot="modal-footer">
                <button type="button" class="btn btn-primary" @click.prevent="addItem">Add Domain</button>
                <button type="button" class="btn btn-default" @click.prevent="addModalVisible = false">
                    Cancel
                </button>
            </div>
        </b-modal>
    </div>
</template>

<script>
  import ValidationErrors from '../utils/ValidationErrors'

  export default {
    name: 'domain-controls',
    components: {},
    props: [
      'api',
      'itemsChecked'
    ],
    data () {
      return {
        addModalVisible: false,
        domain: '',
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
          domain: this.domain
        }).then((response) => {
          this.domain = ''
          this.errors.clear()

          this.$events.$emit('loading', false)
          this.addModalVisible = false

          this.$emit('add', this.email)

          this.$alertSuccess('Domain has been added')
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
