<template>
    <div class="search-widget">
        <i class="display-tips" @click="searchVisible">
            <span v-if="isDisplay" class="el-icon-caret-top" title="隐藏搜索栏"></span>
            <span v-else class="el-icon-caret-bottom" title="显示搜索栏"></span>
        </i>
        <a-card class="box-card">
            <a-form :inline="true" label-width="100px" v-show="isDisplay" @submit.native.prevent="submitSearch">
                <search-form-item v-for="(field, index) in fields" :field="field" :index="index" :key="index"
                                  :fieldValues.sync="fieldValues"
                                  :autocomplete-text-search-method="autocompleteTextSearchMethod"
                                  :selectOptions="selectOptions"></search-form-item>
                <search-form-item v-for="(field, index, sortIndex) in hideFields" :field="field" :index="index"
                                  :key="index"
                                  :fieldValues.sync="fieldValues"
                                  :selectOptions="selectOptions"
                                  :autocomplete-text-search-method="autocompleteTextSearchMethod" v-show="isDisplayHide"
                                  :style="sortIndex === 0 ? 'margin-left:-5px':''"></search-form-item>
                <!-- 不知道为什么隐藏到显示时，位置有一点偏移，这里做 margin-left -5px 处理 -->
                <a-form-item class="el-form-button">
                    <a-button type="primary" @click="submitSearch">查询</a-button>
                    <a-button type="primary" @click="resetSearch">重置</a-button>
                    <a-tooltip effect="dark" content="显示或者隐藏更多的搜索条件" placement="top" v-if="hasHideField">
                        <a-button type="primary" @click="toggleHideSearch">
                            {{ isDisplayHide ? '隐藏' : '更多' }}
                        </a-button>
                    </a-tooltip>
                </a-form-item>
            </a-form>
        </a-card>
    </div>
</template>

<script>
    import helpers from '@/libs/helpers';
    import groupSearchFields from './index';
    import SearchFormItem from './SearchFormItem';

    export default {
        name: 'Search',
        components: {SearchFormItem},
        data: () => ({
            isDisplay: true,
            isDisplayHide: false,

            fieldValues: {},

            selectOptions: {},
        }),
        props: {
            searchFields: {
                type: Array,
                required: true,
            },
            hideSearchFields: {
                type: Array,
            },
        },
        computed: {
            fields() {
                return _.pick(this.allSearchFields, this.searchFields);
            },
            hideFields() {
                return _.pick(this.allSearchFields, this.hideSearchFields);
            },
            allFields() {
                return _.assign({}, this.fields, this.hideFields);
            },
            hasHideField() {
                return !_.isEmpty(this.hideFields);
            },
            allSearchFields() {
                let allSearchFields = {};
                _.forIn(groupSearchFields, (searchFields) => {
                    _.assignIn(allSearchFields, searchFields);
                });
                return allSearchFields;
            },
        },
        mounted() {
            this.init();
        },
        watch: {
            '$route'(to, from) {
                this.init();
            },
        },
        activated() {
        },
        methods: {
            init() {
                this.resetSearch();
                let query = this.$route.query;
                _.forIn(query, (value, key) => {
                    // 如没有在显示的搜索条件中获取到值，则在隐藏的搜索条件中获取值
                    let field = this.fields[key] || this.hideFields[key];
                    if (field && field.type === 'select' && field.attr.option_type === 'int') {
                        // 从路由中获取到是字符串，要转为整型才能匹配上
                        query[key] = parseInt(value);
                    }
                });

                this.fieldValues = helpers.searchArgBuild(this.fieldValues, query);

                this.fetchRemoteSelect();
            },
            fetchRemoteSelect() {
                _.forIn(this.allFields, (field, fieldName) => {
                    if (field.type !== 'select') {
                        return true;
                    }
                    if (this.selectOptions[fieldName] && this.selectOptions[fieldName].length) {
                        return true;
                    }

                    let addSelectOptions = {};
                    addSelectOptions[fieldName] = field.attr.options ? field.attr.options : [];
                    this.selectOptions = Object.assign({}, this.selectOptions, addSelectOptions);

                    // 如果select的option来源于远程搜索
                    if (field.attr.option_remote && _.isFunction(this.$parent[field.attr.option_remote_method])) {
                        this.$parent[field.attr.option_remote_method]().then((options) => {
                            addSelectOptions[fieldName] = options;
                            this.selectOptions = Object.assign({}, this.selectOptions, addSelectOptions);
                        });
                    }
                });
            },
            submitSearch() {
                let query = _.assign({}, this.fieldValues, {_: (new Date()).getTime()});
                // 如果有搜索回调的方法，则不用默认搜索方法
                if (this.$listeners.onSearch) {
                    this.$emit('onSearch', this.allFields, query);
                    return;
                }
                helpers.queryRoute(this.$router, 1, {query: query});
            },
            resetSearch() {
                let fieldValues = {};
                _.forEach(this.allFields, function (field, fieldName) {
                    if (field.type === 'dateRange' || field.type === 'dateTimeRange') {
                        fieldValues[field.attr.date_start] = _.get(field, 'attr.value.start', '');
                        fieldValues[field.attr.date_end] = _.get(field, 'attr.value.end', '');
                    } else {
                        fieldValues[fieldName] = _.get(field, 'attr.value', '');
                    }
                });
                this.fieldValues = fieldValues;
            },
            searchVisible() {
                this.isDisplay = !this.isDisplay;
            },
            toggleHideSearch() {
                this.isDisplayHide = !this.isDisplayHide;
            },
            autocompleteTextSearchMethod(fieldName, searchMethod, queryString, cb) {
                if (searchMethod && _.isFunction(this.$parent[searchMethod])) {
                    return this.$parent[searchMethod](fieldName, queryString, cb);
                }
                return cb([]);
            },
            // 供上层模板调用，获取搜索字段值
            getSearchFieldValues() {
                return this.fieldValues;
            },
        },

    };
</script>

<style scoped>

</style>