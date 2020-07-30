<template>
  <div class="login" >
    <img :src="appBg" class="bg" v-if="appBg">
    <a-card class="login-card" :title="appName">
      <!-- 登录form -->
      <login-form
        ref="loginForm"
        @keydown.enter.native="$refs.login.onAction" v-show="this.tab"
      />
      <!-- 注册form -->
      <register-form
        ref="registerForm"
        @keydown.enter.native="$refs.register.onAction" v-show="!this.tab"
      />
      <!-- 登录 -->
      <loading-action
        ref="login"
        type="primary"
        class="w-100"
        :action="onLogin"
        disable-on-success="2000"
        v-show="this.tab"
      >
        <span>登录</span>
      </loading-action>
      <loading-action
        ref="register"
        class="w-100"
        :action="showRegister"
        disable-on-success="2000"
        style="margin-top:5px"
        v-show="this.tab"
      >
        <span>注册</span>
      </loading-action>

      <!-- 注册 -->
      <loading-action
        ref="register"
        class="w-100"
        type="primary"
        :action="onRegister"
        disable-on-success="2000"
        style="margin-top:5px"
        v-show="!this.tab"
      >
      <span>注册提交</span>
      </loading-action>

      <loading-action
        ref="register"
        class="w-100"
        :action="showRegister"
        disable-on-success="2000"
        style="margin-top:5px"
        v-show="!this.tab"
      >
      <span>返回登录</span>
      </loading-action>
    </a-card>
  </div>
</template>

<script>
import LoginForm from '@c/LoginForm'
import RegisterForm from '@c/RegisterForm'
import { mapGetters } from 'vuex'
import LoadingAction from '@c/LoadingAction'
import { SYSTEM_BASIC } from '@/libs/constants'
import { getUrl } from '@/libs/utils'

export default {
  name: 'Login',
  components: {
    LoadingAction,
    LoginForm,
    RegisterForm
  },
  data() {
    return {
      tab:true,
    }
  },
  computed: {
    appName() {
      return this.$store.getters.appName
    },
    ...mapGetters([
      'appName',
      'getConfig',
    ]),
    appBg() {
      return getUrl(this.getConfig(SYSTEM_BASIC.SLUG + '.' + SYSTEM_BASIC.APP_BG_SLUG));
    },
  },
  methods: {
    async onLogin() {
      await this.$refs.loginForm.onSubmit()
      // this.$router.push(this.$route.query.redirect || '/index')
    },
    async onRegister() {
      // console.log(this);
      await this.$refs.registerForm.onSubmit()
      this.showRegister();
      this.$router.push(this.$route.query.redirect || '/index')
    },
    async showRegister(){
      if(this.tab == true){
        this.tab = false;
      }else{
        this.tab = true;
      }
    },
    change(){
      this.tab = false
    }
  }
  ,created(){
    console.log(this.appBg)
  }
}
</script>

<style scoped lang="less">
.login {
  height: 100vh;
  display: flex;
}

.login-card {
  width: 300px;
  margin: 30vh auto auto auto;
   z-index:1;
}

.bg{
  width:100%;
    height:100%;  /**宽高100%是为了图片铺满屏幕 **/
    z-index:-1;
    position: absolute;
}
</style>
