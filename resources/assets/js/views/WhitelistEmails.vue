<template>
    <div>
        <div class="card">
            <div class="card-header">
                <i class="fa fa-info-circle"></i>List of auto-whitelisted emails
            </div>
            <div class="card-block">
                <data-table ref="whitelistEmails" :columns="columns" :sorting="sorting" @itemsChecked="updateItemsChecked">
                    <div slot="controls">
                        <button class="btn btn-primary" @click.prevent="showAddEmailAddressModal">
                            <i class="fa fa-plus"></i> Add Email Address
                        </button>
                        <button class="btn btn-default" @click.prevent="fetchItems">
                            <i class="fa fa-refresh"></i> Refresh
                        </button>
                        <button class="btn btn-danger" @click.prevent="deleteItems" :disabled="itemsChecked.length == 0">
                            <i class="fa fa-trash"></i> Delete <span v-if="itemsChecked.length > 0">
                                {{ itemsChecked.length}} {{ itemsChecked.length == 1 ? 'record' : 'records' }}</span>
                        </button>
                    </div>
                </data-table>
            </div>
        </div>

        <modal title="Add Email Address" :value="addEmailAddress.visible" @cancel="addEmailAddress.visible = false"
               @keyup.esc="addEmailAddress.visible = false">
            <alert type="danger" v-if="addEmailAddress.errors.hasGeneral()">
                {{ addEmailAddress.errors.firstGeneral() }}
            </alert>

            <form @submit.prevent="submitEmailAddress">
                <div class="form-group" :class="{ 'has-danger': addEmailAddress.errors.has('email') }">
                    <label class="form-control-label">Email Address</label>
                    <div v-if="addEmailAddress.errors.has('email')" class="form-control-feedback">
                        {{ addEmailAddress.errors.first('email') }}
                    </div>
                    <input type="text" v-model="addEmailAddress.email" v-focus.lazy="addEmailAddress.visible"
                           class="form-control" placeholder="Email Address">
                </div>
                <div class="form-group" :class="{ 'has-danger': addEmailAddress.errors.has('source') }">
                    <label class="form-control-label">IP Address</label>
                    <div v-if="addEmailAddress.errors.has('source')" class="form-control-feedback">
                        {{ addEmailAddress.errors.first('source') }}
                    </div>
                    <input type="text" v-model="addEmailAddress.source" class="form-control"
                           placeholder="Source (Class C or D)">
                </div>
                <button type="submit" class="hidden-xs-up"></button>
            </form>
            <div slot="modal-footer" class="modal-footer">
                <button type="submit" class="btn btn-primary" @click="submitEmailAddress">
                    Add Email Address
                </button>
                <button type="button" class="btn btn-default" @click="addEmailAddress.visible = false">
                    Cancel
                </button>
            </div>
        </modal>
    </div>
</template>

<script>
  import modal from 'vue-strap/src/Modal'
  import DataTable from '../components/DataTable'
  import ValidationErrors from '../utils/ValidationErrors'

  export default {
    name: 'whitelist-emails',
    components: {
      modal,
      DataTable
    },
    data () {
      return {
        addEmailAddress: {
          errors: new ValidationErrors(),
          visible: false,
          email: '',
          source: ''
        },
        columns: {
          'sender_name': 'Sender Name',
          'sender_domain': 'Sender Domain',
          'src': 'IP Address',
          'first_seen': 'First Seen'
        },
        items: [],
        itemsChecked: [],
        sorting: {
          column: 'first_seen',
          order: 'desc'
        }
      }
    },
    mounted () {
      this.prepareComponent()
    },
    methods: {
      prepareComponent () {
        this.fetchItems()

        // @TODO: Investigate why this only works with $nextTick()
        this.$nextTick(() => {
          this.$events.$emit('loading', true)
        })
      },
      fetchItems () {
        this.$events.$emit('loading', true)

        axios.get('/api/v1/whitelist/emails').then((response) => {
          this.$refs.whitelistEmails.setItems(response.data.data)
        }).catch((erros) => {
        }).then((response) => {
          this.$events.$emit('loading', false)
        })
      },
      updateItemsChecked (items) {
        this.itemsChecked = items
      },
      deleteItems () {
        this.$events.$emit('loading', true)

        axios.post('/api/v1/whitelist/emails', {
          items: this.itemsChecked
        }).then((response) => {
          this.fetchItems()
        }).catch((error) => {
          console.log(error)
          this.$events.$emit('loading', false)
        }).then((response) => {

        })
      },
      showAddEmailAddressModal () {
        this.addEmailAddress.visible = true
      },
      submitEmailAddress () {
        this.$events.$emit('loading', true)

        axios.post('/api/v1/whitelist/emails/add', {
          email: this.addEmailAddress.email,
          source: this.addEmailAddress.source
        }).then((response) => {
          this.fetchItems()
          this.addEmailAddress.visible = false
          this.addEmailAddress.email = ''
          this.addEmailAddress.source = ''

          this.addEmailAddress.errors.clear()
        }).catch((error) => {
          this.addEmailAddress.errors.set(error.response.data)
          this.$events.$emit('loading', false)
        }).then((response) => {
          //
        })
      }
    }
  }
</script>
