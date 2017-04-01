<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <slot name="controls"></slot>
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
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-sm table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <th :colspan="Object.keys(columns).length">
                            Records: {{ items.length }} <span v-if="itemsFiltered.length != items.length">({{ itemsFiltered.length}} displayed)</span>
                        </th>
                    </tr>
                    <tr>
                        <th class="th-checkbox text-center">
                            <input type="checkbox" @click="checkAllItems" :checked="allItemsChecked">
                        </th>
                        <th v-for="(colName, colKey) in columns" @click.prevent="sortColumn(colKey)">
                            {{ colName }}
                    <span class="pull-right">
                        <i class="fa fa-sort-asc" v-if="mySorting.column == colKey && mySorting.order == 'asc'"></i>
                        <i class="fa fa-sort-desc" v-if="mySorting.column == colKey && mySorting.order == 'desc'"></i>
                    </span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in itemsFiltered" :key="item.id" @click="itemClicked(item)"
                        :class="{ 'table-success': itemsChecked.includes(item.id)}">
                        <td class="text-center">
                            <input type="checkbox" v-model="itemsChecked" :value="item.id" @click="itemClicked(item)">
                        </td>
                        <td v-for="(colValue, colKey) in columns">{{ item[colKey] }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'data-table',
    props: [
      'columns',
      'sorting'
    ],
    data () {
      return {
        allItemsChecked: false,
        items: [],
        itemsChecked: [],
        filter: '',
        mySorting: this.sorting
      }
    },
    computed: {
      itemsFiltered () {
        if (!this.filter.length) {
          return this.items
        }

        return this.items.filter((item) => {
          for (let column in this.columns) {
            if (item[column].match(this.filter)) {
              return true
            }
          }
        })
      }
    },
    mounted () {
      this.sortColumn(this.mySorting.column, this.mySorting.order)
    },
    methods: {
      setItems (items) {
        this.items = items
        this.setItemsChecked()
      },
      setItemsChecked(items) {
        if (!items) {
          this.itemsChecked = []
        } else {
          this.itemsChecked = items
        }

        this.$emit('itemsChecked', this.itemsChecked)
      },
      checkAllItems () {
        let checkboxIsChecked = this.allItemsChecked

        this.itemsChecked = []

        if (!checkboxIsChecked) {
          this.itemsFiltered.forEach((item) => {
            if (!this.itemsChecked.includes(item.id)) {
              this.itemsChecked.push(item.id)
            }
          })
        }

        this.allItemsChecked = !this.allItemsChecked;

        this.$emit('itemsChecked', this.itemsChecked)
      },
      itemClicked (item) {
        if (this.itemsChecked.includes(item.id)) {
          this.itemsChecked.splice(this.itemsChecked.indexOf(item.id), 1)
        } else {
          this.itemsChecked.push(item.id)
        }

        this.$emit('itemsChecked', this.itemsChecked)
      },
      sortColumn (column, order) {
        if (!order) {
          if (this.mySorting.column === column) {
            order = this.mySorting.order === 'asc' ? 'desc' : 'asc'
          } else {
            order = 'asc'
          }
        }

        if (order === 'asc') {
          this.items = _.sortBy(this.items, column)
        } else {
          this.items = _.sortBy(this.items, column).reverse()
        }

        this.mySorting.column = column
        this.mySorting.order = order
      }
    }
  }
</script>
