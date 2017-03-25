<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <button class="btn btn-success" @click.prevent="getItems">
                            <i class="fa fa-refresh"></i> refresh
                        </button>
                        <button class="btn btn-danger" @click.prevent="deleteItems"
                                :disabled="checkedItems.length == 0">
                            <i class="fa fa-trash"></i> delete <span
                                v-if="checkedItems.length > 0">{{ checkedItems.length
                            }} {{ checkedItems.length == 1 ? 'record' : 'records' }}</span>
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

                <form ref="tableForm">
                    <table class="table table-bordered table-striped table-sm table-hover table-responsive">
                        <thead>
                        <tr>
                            <th class="th-checkbox text-center">
                                <input type="checkbox" @click="checkAllItems" :checked="allItemsChecked">
                            </th>
                            <th v-for="(colName, colKey) in columns" @click.prevent="sortColumn(colKey)">
                                {{ colName }} <span class="pull-right">
                                <i class="fa fa-sort-asc" v-if="sorting.column == colKey && sorting.order == 'asc'"></i>
                                <i class="fa fa-sort-desc"
                                   v-if="sorting.column == colKey && sorting.order == 'desc'"></i>
                            </span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in filteredItems" :key="item.id" @click="itemClicked(item)"
                            :class="{ 'table-success': checkedItems.includes(item.id)}">
                            <td class="text-center">
                                <input type="checkbox" v-model="checkedItems" :value="item.id"
                                       @click="itemClicked(item)">
                            </td>
                            <td v-for="(colValue, colKey) in columns">{{ item[colKey] }}</td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'greylist',
        components: {},
        data() {
            return {
                columns: {
                    'sender_name': 'Sender Name',
                    'sender_domain': 'Sender Domain',
                    'src': 'IP Address',
                    'rcpt': 'Recipient',
                    'first_seen': 'First Seen',
                },
                allItemsChecked: false,
                checkedItems: [],
                items: [],
                filter: '',
                sorting: {
                    column: 'first_seen',
                    order: 'desc',
                }
            }
        },
        computed: {
            filteredItems: function () {
                if (!this.filter.length) {
                    return this.items;
                }

                return this.items.filter((item) => {
                    for (let column in this.columns) {
                        if (item[column].match(this.filter)) {
                            return true;
                        }
                    }
                })
            },
        },
        mounted() {
            this.prepareComponent();
        },
        methods: {
            prepareComponent() {
                this.getItems();

                // @TODO: Investigate why this only works with $nextTick()
                this.$nextTick(() => {
                    this.$events.$emit('loading', true);
                });

                this.$refs.filterInput.focus();
            },
            getItems() {
                this.$events.$emit('loading', true);

                axios.get('/api/v1/greylist')
                    .then((response) => {
                        this.items = response.data.data;

                        this.sortColumn(this.sorting.column, this.sorting.order);

                        this.$events.$emit('loading', false);
                    });
            },
            checkAllItems() {
                let checkboxIsChecked = this.allItemsChecked;

                this.checkedItems = [];

                if (!checkboxIsChecked) {
                    this.filteredItems.forEach((item) => {
                        if (!this.checkedItems.includes(item.id)) {
                            this.checkedItems.push(item.id);
                        }
                    });
                }

                this.allItemsChecked = !this.allItemsChecked;
            },
            itemClicked(item) {
                if (this.checkedItems.includes(item.id)) {
                    this.checkedItems.splice(this.checkedItems.indexOf(item.id), 1);

                } else {
                    this.checkedItems.push(item.id);
                }
            },
            sortColumn(column, order) {
                if (!order) {
                    if (this.sorting.column == column) {
                        order = this.sorting.order == 'asc' ? 'desc' : 'asc'
                    } else {
                        order = 'asc'
                    }
                }

                if (order == 'asc') {
                    this.items = _.sortBy(this.items, column);
                } else {
                    this.items = _.sortBy(this.items, column).reverse();
                }

                this.sorting.column = column;
                this.sorting.order = order;
            },
            deleteItems() {
                this.$events.$emit('loading', true);

                axios.post('/api/v1/greylist', {
                    items: this.checkedItems
                }).then((response) => {
                    this.getItems();
                }).catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
