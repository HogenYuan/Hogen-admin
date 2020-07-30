<template>
  <div class="register">
    <a-card class="register-card" :title="appName">
      <login-form
        ref="form"
        @keydown.enter.native="$refs.register.onAction"
      />
      <loading-action
        ref="register"
        type="primary"
        class="w-100"
        :action="onRegister"
        disable-on-success="2000"
        style="margin-top:5px"
      >
      <span>注册</span>
      </loading-action>
    </a-card>
  </div>
</template>

<script>
import RegisterForm from '@c/RegisterForm'
import LoadingAction from '@c/LoadingAction'

export default {
  name: 'Register',
  components: {
    LoadingAction,
    RegisterForm,
  },
  computed: {
    appName() {
      return this.$store.getters.appName
    },
  },
  methods: {
    async onRegister() {
      await this.$refs.form.onSubmit()
      this.$router.push(this.$route.query.redirect || '/index')
    },
  },
}
</script>

<style scoped lang="less">
.register {
  height: 100vh;
  display: flex;
}

.register-card {
  width: 300px;
  margin: 30vh auto auto auto;
}
</style>
