<template>
    <a-tabs @tab-click="onTabClick" type="card" @tab-remove="onTabRemove" :value="value" :closable="closeable"
             class="header-tabs">
        <a-tab-pane v-for="pane in namedPanes" :name="pane.name" :label="pane.label" :key="pane.name"/>
    </a-tabs>
</template>
<script>
    export default {
        name: 'RouteTabs',
        data() {
            return {
                value: null,
                namedPanes: {},
                routeNameHistory: [], // 用于删除标签时，找到上一次访问的页面
            };
        },
        props: {},
        computed: {
            closeable() {
                return _.size(this.namedPanes) > 1;
            },
        },
        watch: {
            '$route': {
                immediate: true,
                handler(to, from) {
                    const routeName = to.meta.tabName || to.name;

                    // 路由名称压入访问堆栈
                    this.routeNameHistory.push(routeName);

                    if (!_.has(this.namedPanes, routeName)) {
                        this.$set(this.namedPanes, routeName, {
                            name: routeName,
                            label: to.meta.title,
                        });
                    }

                    const pane = this.namedPanes[routeName];
                    // 更新tab的显示值
                    pane.label = to.meta.title;
                    // 处理URL变更
                    pane.fullPath = to.fullPath;
                    // value赋值
                    this.value = pane.name;
                },
            },
        },
        methods: {
            onTabClick(tab) {
                const pane = this.namedPanes[tab.name];
                this.value = pane.name;
                this.$router.push(pane.fullPath);
            },

            onTabRemove(paneName) {
                // 最后一个就不删除了吧，虽然已经控制了tab上面的删除图标只剩一个的时候不显示删除图标
                if (_.size(this.namedPanes) <= 1) {
                    return;
                }

                // 移除该Tab，并把所有历史访问都清除
                this.$delete(this.namedPanes, paneName);
                this.routeNameHistory = _.without(this.routeNameHistory, paneName);

                // 跳转URL
                const pane = this.namedPanes[_.last(this.routeNameHistory)];
                this.$router.replace(pane.fullPath);
            },
        },
    };
</script>
<style lang="scss" scoped>
.header-tabs {
    /deep/ .el-tabs__header {
        margin-bottom: 0;
    }
}
</style>