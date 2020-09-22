<template>
    <a-form-item :label="field.label"
                 :class="(field.type === 'textarea' ? 'multiple-waybill-uuid' : '')" :key="index">
        <!--文本框-->
        <template v-if="field.type === 'text' || field.type === 'textarea'">
            <a-input v-if="!field.attr || !field.attr.value" v-model="fieldValues[index]" :type="field.type"
                     :placeholder="'请输入' + field.label + (field.type === 'textarea' ?'，多个换行输入':'')"
                     resize="none"
                     :maxlength="(field.type === 'textarea' ? 1024 : !field.attr || !field.attr.maxlength ? 32: field.attr.maxlength)"
            ></a-input>
            <a-input v-else v-model="fieldValues[field.attr.value]" :type="field.type"
                     :placeholder="'请输入' + field.label + (field.type === 'textarea' ?'，多个换行输入':'')"
                     resize="none"
                     :maxlength="(field.type === 'textarea' ? 1024 : !field.attr || !field.attr.maxlength ? 32: field.attr.maxlength)"
            ></a-input>
        </template>
        <!--选择框-->
        <template v-if="field.type === 'select'">
            <a-select v-model="fieldValues[index]" placeholder="请选择" clearable filterable>
                <a-option label="全部" value=""></a-option>
                <a-option v-for="item in selectOptions[index]"
                          :key="item.code"
                          :value="item.code"
                          :label="item.name">
                </a-option>
            </a-select>
        </template>
        <!--时间-->
        <template v-if="field.type === 'date'">
            <a-date-picker v-model="fieldValues[index]" type="date"
                           :placeholder="'请选择' + field.label"
            ></a-date-picker>
        </template>
        <!--时间起始-->
        <template v-if="field.type === 'dateRange' || field.type === 'dateTimeRange'">
            <lz-date-picker v-model="fieldValues[field.attr.date_start]"
                            :type="field.type === 'dateRange' ? 'date' : 'datetime'"
                            :placeholder="'请选择起始' + field.label"
                            style="width:160px;"></lz-date-picker>
            ~
            <lz-date-picker v-model="fieldValues[field.attr.date_end]"
                            :type="field.type === 'dateRange' ? 'date' : 'datetime'"
                            :placeholder="'请选择结束' + field.label"
                            style="width:160px;"></lz-date-picker>
        </template>
        <!--勾选框-->
        <template v-if="field.type === 'checkbox'">
            <a-checkbox v-model="fieldValues[index]" true-label="1" false-label="0"></a-checkbox>
        </template>
        <template v-if="field.type === 'autocompleteText'">
            <a-autocomplete v-model="fieldValues[index]" clearable
                            :placeholder="'请输入' + field.label"
                            :debounce="700"
                            :fetch-suggestions="autocompleteCallback"
            ></a-autocomplete>
        </template>

        <!--        <template v-if="field.type === 'area'">-->
        <!--            <area v-model="fieldValues[index]" :level="field.attr.level" clearable-->
        <!--                  select-any-level placeholder="请选择所在区域"></area>-->
        <!--        </template>-->

    </a-form-item>
</template>

<script>
    import LzDatePicker from '@c/LzDatePicker';

    export default {
        name: 'SearchFormItem',
        components: {LzDatePicker},
        data: () => ({}),
        props: {
            field: {
                type: Object,
            },
            index: {
                type: String,
            },
            fieldValues: {
                type: Object,
            },
            selectOptions: {
                type: Object,
            },
            autocompleteTextSearchMethod: {
                type: Function,
            },
        },
        computed: {},
        methods: {
            autocompleteCallback(queryString, cb) {
                return this.autocompleteTextSearchMethod(this.index, this.field.attr.search_method, queryString, cb);
            },
        },
    }
</script>

<style scoped>

</style>