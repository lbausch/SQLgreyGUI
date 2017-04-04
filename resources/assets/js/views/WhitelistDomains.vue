<template>
    <div>
        <div class="card">
            <div class="card-header">
                <i class="fa fa-info-circle"></i>List of auto-whitelisted domains
            </div>
            <div class="card-block">
                <data-table ref="whitelistDomains" :columns="columns" :sorting="sorting" @itemsChecked="updateItemsChecked">
                    <div slot="controls">
                        <button class="btn btn-primary" @click.prevent="showAddDomainModal">
                            <i class="fa fa-plus"></i> Add Domain
                        </button>
                        <button class="btn btn-default" @click.prevent="fetchItems">
                            <i class="fa fa-refresh"></i> Refresh
                        </button>
                        <button class="btn btn-danger" @click.prevent="deleteItems" :disabled="itemsChecked.length == 0">
                            <i class="fa fa-trash"></i> Delete <span v-if="itemsChecked.length > 0">
                            {{ itemsChecked.length}} {{ itemsChecked.length == 1 ? 'Record' : 'Records' }}</span>
                        </button>
                    </div>
                </data-table>
            </div>
        </div>

        <modal title="Add Domain" :value="addDomain.visible" @cancel="addDomain.visible = false"
               @keyup.esc="addDomain.visible = false">
            <alert type="danger" v-if="addDomain.errors.hasGeneral()">
                {{ addDomain.errors.firstGeneral() }}
            </alert>

            <form @submit.prevent="submitDomain">
                <div class="form-group" :class="{ 'has-danger': addDomain.errors.has('domain') }">
                    <label class="form-control-label">Domain</label>
                    <div v-if="addDomain.errors.has('domain')" class="form-control-feedback">
                        {{ addDomain.errors.first('domain') }}
                    </div>
                    <input type="text" v-model="addDomain.domain" v-focus.lazy="addDomain.visible"
                           class="form-control" placeholder="Domain">
                </div>
                <div class="form-group" :class="{ 'has-danger': addDomain.errors.has('source') }">
                    <label class="form-control-label">IP Address</label>
                    <div v-if="addDomain.errors.has('source')" class="form-control-feedback">
                        {{ addDomain.errors.first('source') }}
                    </div>
                    <input type="text" v-model="addDomain.source" class="form-control"
                           placeholder="Source (Class C or D)">
                </div>
                <button type="submit" class="hidden-xs-up"></button>
            </form>
            <div slot="modal-footer" class="modal-footer">
                <button type="submit" class="btn btn-primary" @click="submitDomain">
                    Add Domain
                </button>
                <button type="button" class="btn btn-default" @click="addDomain.visible = false">
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
    name: 'whitelist-domains',
    components: {
      modal,
      DataTable
    },
    data () {
      return {
        addDomain: {
          errors: new ValidationErrors(),
          visible: false,
          domain: '',
          source: ''
        },
        columns: {
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

        axios.get('/api/v1/whitelist/domains').then((response) => {
          this.$refs.whitelistDomains.setItems(response.data.data)
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

        axios.post('/api/v1/whitelist/domains', {
          items: this.itemsChecked
        }).then((response) => {
          this.fetchItems()
        }).catch((error) => {
          this.$events.$emit('loading', false)
        }).then((response) => {

        })
      },
      showAddDomainModal () {
        this.addDomain.visible = true
      },
      submitDomain () {
        this.$events.$emit('loading', true)

        axios.post('/api/v1/whitelist/domains/add', {
          domain: this.addDomain.domain,
          source: this.addDomain.source
        }).then((response) => {
          this.fetchItems()
          this.addDomain.visible = false
          this.addDomain.domain = ''
          this.addDomain.source = ''

          this.addDomain.errors.clear()
        }).catch((error) => {
          this.addDomain.errors.set(error.response.data)
          this.$events.$emit('loading', false)
        }).then((response) => {
          //
        })
      }
    }
  }
</script>
