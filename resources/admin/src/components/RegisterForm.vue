<template>
  <lz-form
    :form.sync="form"
    :errors.sync="errors"
    in-dialog
    :footer="false"
  >
    <lz-form-item prop="username">
      <a-input
        ref="username"
        v-model="form.username"
        placeholder="帐号"
      >
        <svg-icon slot="prefix" icon-class="user"/>
      </a-input>
    </lz-form-item>
    <lz-form-item prop="name">

       <a-input
        ref="username"
        v-model="form.name"
        placeholder="昵称"
      >
        <svg-icon slot="prefix" icon-class="user"/>
      </a-input>
    </lz-form-item>
    <lz-form-item prop="password">
      <a-input
        type="password"
        v-model="form.password"
        placeholder="密码"
      >
        <svg-icon slot="prefix" icon-class="password"/>
      </a-input>
    </lz-form-item>
    <lz-form-item prop="repassword">
      <a-input
        type="password"
        v-model="form.repassword"
        placeholder="重复密码"
      >
        <svg-icon slot="prefix" icon-class="password"/>
      </a-input>
    </lz-form-item>
  </lz-form>
</template>

<script>
import { getMessage } from '@/libs/utils'
import LzForm from '@c/LzForm/index'
import LzFormItem from '@c/LzForm/LzFormItem'

export default {
  name: 'RegisterForm',
  components: {
    LzFormItem,
    LzForm,
  },
  data: () => ({
    form: {
      name:"",
      username: '',
      password: '',
      repassword:'',
    },
    errors: {},
  }),
  mounted() {
    this.$refs.username.focus()
  },
  methods: {
    async onSubmit() {
      if(this.form.password !== this.form.repassword){
        this.$message.error("两次输入密码不一致")
        return ;
      }
      await this.$store.dispatch('register', this)
      this.$message.success(getMessage('registeredIn'))
    },
  },
}
</script>
