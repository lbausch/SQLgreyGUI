<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <button class="btn btn-primary" @click.prevent="showAddEmailAddressModal">
                            <i class="fa fa-plus"></i> Add Email Address
                        </button>
                        <button class="btn btn-default" @click.prevent="fetchItems">
                            <i class="fa fa-refresh"></i> Refresh
                        </button>
                        <button class="btn btn-danger" @click.prevent="deleteItems"
                                :disabled="itemsChecked.length == 0">
                            <i class="fa fa-trash"></i> Delete <span
                                v-if="itemsChecked.length > 0">
                                    {{ itemsChecked.length}} {{ itemsChecked.length == 1 ? 'record' : 'records' }}
                            </span>
                        </button>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-1">
                            <div class="input-group-addon" v-if="filter.length == 0">
                                <i class="fa fa-search"></i>
                            </div>
                            <div class="input-group-addon" v-if="filter.length > 0" @click="filter = ''">
                                <i class="fa fa-eraser"></i>
                            </div>
                            <input type="text" class="form-control" placeholder="Search..." v-model="filter"
                                   ref="filterInput">
                        </div>
                    </div>
                </div>

                <data-table ref="whitelistEmails" :columns="columns" :sorting="sorting" :filter="filter"
                            @itemsChecked="updateItemsChecked"></data-table>
            </div>
        </div>


        <modal title="Add Email Address" :value="addEmailAddress.visible" @cancel="addEmailAddress.visible = false">
            <alert type="danger" v-if="addEmailAddress.errors.hasGeneral()">
                {{ addEmailAddress.errors.firstGeneral() }}
            </alert>

            <form @submit.prevent="submitEmailAddress">
                <div class="form-group" :class="{ 'has-danger': addEmailAddress.errors.has('email') }">
                    <label class="form-control-label">Email Address</label>
                    <span v-if="addEmailAddress.errors.has('email')" class="help-block">
                        {{ addEmailAddress.errors.first('email') }}
                    </span>
                    <input type="text" v-model="addEmailAddress.email" v-focus.lazy="addEmailAddress.visible"
                           ref="addEmailAddressInput" class="form-control" placeholder="Email Address">
                </div>
                <div class="form-group" :class="{ 'has-danger': addEmailAddress.errors.has('source') }">
                    <label class="form-control-label">Source</label>
                    <span v-if="addEmailAddress.errors.has('source')" class="help-block">
                        {{ addEmailAddress.errors.first('source') }}
                    </span>
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
  import alert from 'vue-strap/src/Alert'
  import modal from 'vue-strap/src/Modal'
  import DataTable from '../components/DataTable'
  import ValidationErrors from '../utils/ValidationErrors'

  export default {
    name: 'whitelist-emails',
    components: {
      alert,
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
        filter: '',
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

        this.$refs.filterInput.focus()
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
          this.addEmailAddress.email = null
          this.addEmailAddress.source = null

          this.addEmailAddress.errors.clear()

          // this.$alertSuccess('Email Address has been added')
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
