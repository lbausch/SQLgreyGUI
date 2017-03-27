<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-6 mb-1">
                    <button class="btn btn-default" @click.prevent="fetchItems">
                        <i class="fa fa-refresh"></i> Refresh
                    </button>
                    <button class="btn btn-danger" @click.prevent="deleteItems"
                            :disabled="itemsChecked.length == 0">
                        <i class="fa fa-trash"></i> Delete <span
                            v-if="itemsChecked.length > 0">
                        {{ itemsChecked.length}} {{ itemsChecked.length == 1 ? 'record' : 'records' }}</span>
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

            <data-table ref="greylist" :columns="columns" :sorting="sorting" :filter="filter"
                        @itemsChecked="updateItemsChecked"></data-table>
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
