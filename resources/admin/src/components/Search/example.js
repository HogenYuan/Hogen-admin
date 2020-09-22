import helpers from '@/libs/helpers';

export default {
    phone: {
        label: '手机号码',
        type: 'text',
        attr: {maxlength: 11}
    },
    address_code: {
        label: '所在区域',
        type: 'area',
        attr: {level: 2}
    },
    supplier_type: {
        label: '石油公司',
        type: 'select',
        attr: {options: helpers.cons('supplier_type'), option_type: 'int'}
    },
    company_uuid: {
        label: '所属客户',
        type: 'select',
        attr: {option_type: 'int', option_remote: true, option_remote_method: 'fetchCompanies'}
    },
};