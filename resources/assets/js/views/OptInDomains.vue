<template>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-info-circle"></i>These domains are always greylisted unless they are present in the opt-out list
        </div>
        <div class="card-block">
            <data-table ref="optOutDomains" :columns="columns" :sorting="sorting" @itemsChecked="updateItemsChecked">
                <div slot="controls">
                    <domain-controls :api="api" :itemsChecked="itemsChecked" @add="addItem" @refresh="fetchItems"
                                     @delete="deleteItems"/>
                </div>
            </data-table>
        </div>
    </div>
</template>

<script>
  import DomainControls from '../components/DomainControls'
  import DataTable from '../components/DataTable'

  export default {
    name: 'opt-in-domains',
    components: {
      DomainControls,
      DataTable
    },
    data () {
      return {
        api: {
          itemsEndpoint: 'api/v1/optin/domains',
          addItemEndpoint: 'api/v1/optin/domains/add',
          deleteItemsEndpoint: 'api/v1/optin/domains'
        },
        columns: {
          domain: 'Domain'
        },
        items: [],
        itemsChecked: [],
        sorting: {
          column: 'domain',
          order: 'asc'
        }
      }
    },
    mounted () {
      this.prepareComponent()
    },
    methods: {
      prepareComponent () {
        this.fetchItems()

        this.$nextTick(() => {
          this.$events.$emit('loading', true)
        })
      },
      fetchItems () {
        this.$events.$emit('loading', true)

        axios.get(this.api.itemsEndpoint).then((response) => {
          this.$refs.optOutDomains.setItems(response.data.data)
        }).catch((error) => {
          //
        }).then((response) => {
          this.$events.$emit('loading', false)
        })
      },
      updateItemsChecked (items) {
        this.itemsChecked = items
      },
      addItem (item) {
        this.fetchItems()
      },
      deleteItems () {
        this.fetchItems()
      }
    }
  }
</script>
