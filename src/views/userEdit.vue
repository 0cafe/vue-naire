<template>
  <div class="container">
    <el-form ref="form" :model="form" label-width="80px">
      <el-form-item label="新密码">
        <el-input v-model="form.a_password" type="password" ></el-input>
      </el-form-item>
      <el-form-item label="确认密码">
        <el-input v-model="form.checkword" type="password"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="submit">确认</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
  import {
    errorToast,
    successToast
  } from '@/common/toast'
  import {
    put
  } from '../axios/api.js'
  export default {
    data() {
      return {
        form: {
          'a_username': 'ausername'
        }
      }
    },
    methods: {
      submit() {
        if(!this.form.a_password || !this.form.checkword){
          return errorToast('不能为空')
        }
        if (this.form.a_password != this.form.checkword) {
          return errorToast('两次输入不一致')
        }
        put('/pwd', this.form).then(res => {
          if (!res.msg) {
            return errorToast(res)
          } else {
            return successToast(res.msg)
          }
        })
      }
    }
  }
</script>

<style scoped="scoped">
  .container {
    margin-top: 30px;
    width: 100%;
    width: 500px;
  }
</style>
