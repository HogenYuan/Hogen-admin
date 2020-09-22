/**
 * 新版
 */
import axios from 'axios';
import config from './config';
// import {Message} from 'element-ui';
import constant from './constants';

export default {
    // 搜索参数建立，如 routeArg 有值 则覆盖 searchArg 的值
    searchArgBuild(searchArg, routeArg) {
        let func = _.partialRight(_.assignWith, (objValue, srcValue) => {
            return (srcValue === '') ? objValue : srcValue;
        });
        let query = func(searchArg, routeArg);
        delete (query.page);
        return query;
    },

    // 整理搜索参数
    buildQuery(page, queryObject) {
        page = _.toSafeInteger(page);
        let query = {};
        _.forEach(queryObject, function (value, key) {
            if (value !== '') {
                query[key] = value;
            }
        });
        delete (query.page);
        if (page !== 0) {
            query.page = page;
        }
        return query;
    },

    // 常量获取方法
    cons(path) {
        return _.get(constant, path);
    },

    // 整理搜索参数并写入浏览器历史记录
    queryRoute(router, page, routes) {
        let query = this.buildQuery(page, routes.query);
        router.push({query: query}, () => {
        }, () => {
        });
        return query;
    },
    // 全部错误处理方法
    // errorHandler(errorResponse) {
    //     let errorTarget = {};
    //     const errors = _.get(errorResponse, 'data.errors', {});
    //     let errorMsg = '';
    //     errorTarget = _.mapValues(errors, (value) => {
    //         errorMsg += value + '<br/>';
    //         return _.head(value);
    //     });
    //     if (errorMsg === '') {
    //         errorMsg = _.get(errorResponse, 'data.message', '请求失败');
    //     }
    //     Message.error({
    //         dangerouslyUseHTMLString: true,
    //         type: 'error',
    //         message: errorMsg,
    //         showClose: true,
    //     });
    //     return errorTarget;
    // },

    /**
     * 获取图片完整URL
     *
     * @param {string} code
     * @return {string}
     */
    getImageURL(code) {
        return config.API_OSS_BASE_URI + '/api/images/' + code;
    },

    /**
     * 获取文件完整URL
     *
     * @param {string} code
     * @return {string}
     */
    getFileURL(code) {
        return config.API_OSS_BASE_URI + '/api/files/' + code;
    },

    /**
     * 文件下载
     *
     * @param {string} code
     * @param {string|null} name
     */
    downloadFile(code, name = null) {
        const fileURL = config.API_OSS_BASE_URI + '/api/files/' + code;
        axios({
            method: 'GET',
            url: fileURL,
            responseType: 'blob',
        }).then(response => {
            const url = URL.createObjectURL(new Blob([response.data]));
            const fakeLink = document.createElement('a');
            fakeLink.href = url;
            fakeLink.setAttribute('download', name);
            document.body.appendChild(fakeLink);
            fakeLink.click();
        });
    },

    /**
     * 简单的随机Id，临时用于:key prop
     * @returns {string}
     */
    simpleRandomId() {
        return '_' + Math.random().toString(36).substr(2, 9);
    },

    /**
     * 生成树方法
     * @param data      原始数据
     * @param rootId    顶级ID值
     * @param idKey
     * @param parentKey
     * @param childrenName
     * @returns {Array}
     */
    tree(data, rootId = 0, idKey = 'id', parentKey = 'parent_id', childrenName = 'children') {
        let children = [];
        _.forIn(data, (item) => {
            if (item[parentKey] === rootId) {
                let filterData = _.filter(data, (filterItem) => {
                    return filterItem[parentKey] !== rootId;
                });
                item[childrenName] = this.tree(filterData, item[idKey], idKey, parentKey, childrenName);
                children.push(item);
            }
        });
        return children;
    },

    /**
     * 生成请求url
     * @param url
     * @param parameter
     * @returns {*}
     */
    convertURL(url, parameter = {}) {
        _.templateSettings.interpolate = /{([\s\S]+?)}/g;
        let compiled = _.template(url);
        url = compiled(_.mapValues(parameter, (value) => {
            return encodeURIComponent(value);
        }));
        return url;
    },

    /**
     * 选项搜索
     * @param options
     * @param query
     * @returns {*}
     */
    filterOption(options, query) {
        query = query.toLowerCase().split('');
        if (!query.length) {
            return options;
        }
        return _.filter(options, (option) => {
            let search = (option.spell + '' + option.name).toLowerCase().split('');
            if (_.difference(query, search).length === 0) {
                return true;
            }
        });
    },

    /**
     * 地区生成树
     * @param areaTree  树
     * @param areas     地区列表
     * @param areaKeys  映射表
     */
    areaTree(areaTree, areas, areaKeys) {
        const fillTree = (tree, area, level) => {
            const code = area[areaKeys[level].code];
            // 没有四级地址的
            if (level === 'town' && code === '') {
                return false;
            }
            let currentTree;
            // 没有三级地址，直接取当前的树，下级填充到上级的上级中
            if (code === '') {
                currentTree = tree;
            } else {
                currentTree = _.find(tree.children, {id: code});
                if (currentTree === undefined) {
                    currentTree = {
                        id: code,
                        name: area[areaKeys[level].name],
                        level: areaKeys[level].code,
                        children: [],
                    };
                    tree.children.push(currentTree);
                }
            }
            switch (level) {
                case 'province':
                    fillTree(currentTree, area, 'city');
                    break;
                case 'city':
                    fillTree(currentTree, area, 'district');
                    break;
                case 'district':
                    fillTree(currentTree, area, 'town');
                    break;
                case 'town':
                    break;
                default:
            }
        };

        _.forIn(areas, (area) => {
            fillTree(areaTree, area, 'province');
        });
    },
};
