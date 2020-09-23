<template>
    <a-upload
        ref="upload"
        :action="uploadUrl"
        name="files[]"
        :data="uploadData"
        :before-upload="onBeforeUpload"
        v-bind="$attrs"
    >
        <slot></slot>
        <slot name="trigger" slot="trigger"></slot>
        <slot name="tip" slot="tip"></slot>
    </a-upload>
</template>
<script>
    import Request from '@/axios/request'
    import commonURL from '@/api/url/common';
    import config from '@/libs/config';
    import helpers from '@/libs/helpers';

    export default {
        name: 'LzUpload',
        components: {},
        data() {
            return {
                uploadUrl: config.API_OSS_BASE_URI + '/api/files',
                uploadData: {
                    expiry_time: this.expireIn,
                },
            };
        },
        props: {
            expireIn: {
                type: Number,
                default: 60 * 24 * 30, // 默认有效期一个月
            },
        },
        watch: {},
        computed: {},
        methods: {
            onBeforeUpload(file) {
                // 获取文件上传token
                return Request.post(helpers.convertURL(commonURL.file_token), {}, {useLoading: false}).then(response => {
                    const accessToken = response.data.access_token;

                    if (!accessToken) {
                        return Promise.reject(new Error('上传初始化失败'));
                    }

                    this.uploadData['access_token'] = accessToken;
                });
            },

            clearFiles() {
                this.$refs.upload.clearFiles();
            },

            abort() {
                this.$refs.upload.abort();
            },

            submit() {
                this.$refs.upload.submit();
            },
        },
    };
</script>
<style>
</style>