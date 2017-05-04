<template>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-info-circle"></i>Emails for these recipients will always be greylisted unless they are present in the opt-out list
        </div>
        <div class="card-block">
            <data-table ref="optInEmails" :columns="columns" :sorting="sorting" @itemsChecked="updateItemsChecked">
                <div slot="controls">
                    <email-controls :api="api" :itemsChecked="itemsChecked" @add="addItem" @refresh="fetchItems"
                                   @delete="deleteItems"/>
                </div>
            </data-table>
        </div>
    </div>
</template>

<script>
  import EmailControls from '../components/EmailControls'
  import DataTable from '../components/DataTable'

  export default {
    name: 'opt-in-emails',
    components: {
      EmailControls,
      DataTable
    },
    data () {
      return {
        api: {
          itemsEndpoint: 'api/v1/optin/emails',
          addItemEndpoint: 'api/v1/optin/emails/add',
          deleteItemsEndpoint: 'api/v1/optin/emails'
        },
        columns: {
          email: 'Email Address'
        },
        items: [],
        itemsChecked: [],
        sorting: {
          column: 'email',
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
          this.$refs.optInEmails.setItems(response.data.data)
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
