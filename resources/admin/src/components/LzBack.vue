<template>
    <a-button type="primary" @click="navigateBack">返回</a-button>
</template>
<script>
    export default {
        name: 'LzBack',
        data: () => ({}),
        props: {},
        computed: {},
        methods: {
            navigateBack() {
                let referer = localStorage.referer ? JSON.parse(localStorage.referer) : {};
                if (referer[this.$route.name]) {
                    this.$router.push(referer[this.$route.name]);
                    return;
                }
                this.$router.back();
            },
        },
    };
</script>
<style scoped>
</style>