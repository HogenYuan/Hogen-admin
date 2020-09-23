<template>
    <div>
        <a-table :data="listData.data"
                  v-bind="$attrs"
                  @current-change="handleCurrentChange"
                  @selection-change="handleSelectionChange"
                  @row-dblclick="handleRowDblclick"
        >
            <a-table-column type="index" :index="listIndex" label="序号" width="50" v-if="index" fixed/>
            <slot></slot>
        </a-table>
        <a-pagination v-show="listData.page.totalCount" background layout="total, prev, pager, next, jumper"
                       :current-page="listData.page.currentPage" :page-size="listData.page.perPage"
                       :total="listData.page.totalCount" @current-change="onCurrentPageChange"></a-pagination>
    </div>
</template>
<script>
    export default {
        name: 'LzTable',
        data: () => ({}),
        props: {
            listData: {
                type: Object,
                default: () => ({
                    data: [],
                    page: {
                        currentPage: 1,
                        perPage: 20,
                        totalCount: 0,
                    },
                }),
            },
            // 是否需要序列号
            index: {
                type: Boolean,
                default: true,
            },
        },
        computed: {},
        methods: {
            onCurrentPageChange(page) {
                this.$emit('pageChange', page);
            },
            listIndex(index) {
                return index + this.listData.page.perPage * (this.listData.page.currentPage - 1) + 1;
            },
            handleCurrentChange(currentRow, oldCurrentRow) {
                this.$emit('rowChange', currentRow, oldCurrentRow);
            },
            handleSelectionChange(val){
                this.$emit('selectionChange', val);
            },
            handleRowDblclick(val) {
                this.$emit('rowDblclick', val);
            },
        },
    };
</script>
<style scoped>
</style>
