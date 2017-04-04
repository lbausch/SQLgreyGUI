<template>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-info-circle"></i>This senders have been greylisted recently
        </div>
        <div class="card-block">
            <data-table ref="greylist" :columns="columns" :sorting="sorting" @itemsChecked="updateItemsChecked">
                <div slot="controls">
                    <button class="btn btn-primary" @click.prevent="moveToWhitelist" :disabled="itemsChecked.length === 0">
                        <i class="fa fa-thumbs-up"></i> Move <span v-if="itemsChecked.length > 0">
                            {{ itemsChecked.length}} {{ itemsChecked.length == 1 ? 'Record' : 'Records' }}</span> To Whitelist
                    </button>
                    <button class="btn btn-default" @click.prevent="fetchItems">
                        <i class="fa fa-refresh"></i> Refresh
                    </button>
                    <button class="btn btn-danger" @click.prevent="deleteItems" :disabled="itemsChecked.length === 0">
                        <i class="fa fa-trash"></i> Delete <span v-if="itemsChecked.length > 0">
                            {{ itemsChecked.length}} {{ itemsChecked.length == 1 ? 'Record' : 'Records' }}</span>
                    </button>
                </div>
            </data-table>
        </div>
    </div>
</template>

<script>
  import DataTable from '../components/DataTable.vue'

  export default {
    name: 'greylist',
    components: {
      DataTable
    },
    data () {
      return {
        columns: {
          'sender_name': 'Sender Name',
          'sender_domain': 'Sender Domain',
          'src': 'IP Address',
          'rcpt': 'Recipient',
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

        axios.get('/api/v1/greylist').then((response) => {
          this.$refs.greylist.setItems(response.data.data)
        }).catch((error) => {
          // console.log(error)
        }).then((response) => {
          this.$events.$emit('loading', false)
        })
      },
      updateItemsChecked (items) {
        this.itemsChecked = items
      },
      moveToWhitelist () {
        this.$events.$emit('loading', true)

        axios.post('/api/v1/greylist/move', {
          items: this.itemsChecked
        }).then((response) => {
          this.fetchItems()
        }).catch((error) => {
          console.log(error)
          this.$events.$emit('loading', false)
        }).then((response) => {
          //
        })
      },
      deleteItems () {
        this.$events.$emit('loading', true)

        axios.post('/api/v1/greylist', {
          items: this.itemsChecked
        }).then((response) => {
          this.fetchItems()
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
