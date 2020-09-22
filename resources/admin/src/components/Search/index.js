import example from './example';

const smaple = {
    label: '字段名',
    type: '字段类型（text | textarea | autocompleteText | select | dateRange | dateTimeRange | date | area）',

    attr: {
        value: '默认绑定v-model',
        // 当type为 text时，value数据格式为 value:'',
        // 当type为 dateRange 或者 dateTimeRange 时，value数据格式为 value: {start: '', end: ''},

        maxlength: 'type为text时，最大可输入长度',

        options: 'type为select时，option的列表',
        option_type: 'type为select时，option值的类型(int | string)',
        option_remote: 'type为select时，option值是否来源于远程',
        option_remote_method: 'type为select时，option值来源于远程时的调用方法',

        date_start: 'type为dateRange时，起始时间的字段名',
        date_end: 'type为dateRange时，结束时间的字段名',

        level: 'type为area，地址层级数',

        search_method: 'type为autocompleteText时，远程搜索的调用方法',
    },
};
export default {
    // 当不同js存在同名时，后面的会覆盖前面的
    example: example,
}