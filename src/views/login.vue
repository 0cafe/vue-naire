<template>
  <!-- <div class="box">
    账号 :<input type="text" size="small" placeholder="请输入账号" v-model="userData.a_username" class="form-control" />
     密码 : <input type="password" size="small" placeholder="请输入密码" v-model="userData.a_password" class="form-control"/>
     <button class="btn btn-primary" @click="submitForm()">登录</button>
  </div> -->
  <el-form :model="userData" label-position="left" label-width="0px" class=" login-container">
  	<h3 class="title">系统登录</h3>
  	<el-form-item prop="account">
  		<el-input type="text" v-model="userData.a_username" auto-complete="off" placeholder="账号"></el-input>
  	</el-form-item>
  	<el-form-item prop="checkPass">
  		<el-input type="password" v-model="userData.a_password" auto-complete="off" placeholder="密码"></el-input>
  	</el-form-item>
  	<el-checkbox v-model="checked" checked class="remember">记住密码</el-checkbox>
  	<el-form-item style="width:100%;">
  		<el-button type="primary" style="width:100%;" @click.native.prevent="submitForm()">登录</el-button>
  		<!--<el-button @click.native.prevent="handleReset2">重置</el-button>-->
  	</el-form-item>
  </el-form>
</template>

<script>
  import {post} from '@/axios/api.js'
  import {errorToast,successToast} from '@/common/toast'
  export default{
    data(){
      return{
      userData:{
        a_username:'',
        a_password:''
      }
     }
    },
    methods: {
      async submitForm() {
        await post('/login',this.userData)
        .then(res=>{
          if(res.error_code === 0){
            this.$store.commit('getToken',res.result)
            successToast('登录成功')
            this.$router.replace('/')
          }else{
            errorToast(res.msg)
          }
        })
      }
    },
  }
</script>

<style lang="scss" scoped="scoped">
  .login-container{
  	-webkit-border-radius: 5px;
  	border-radius: 5px;
  	-moz-border-radius: 5px;
  	background-clip: padding-box;
  	margin: 180px auto;
  	width: 350px;
  	padding: 35px 35px 15px 35px;
  	background: #fff;
  	border: 1px solid #eaeaea;
  	box-shadow: 0 0 25px #cac6c6;
  }
  	.title {
  		margin: 0px auto 40px auto;
  		text-align: center;
  		color: #505458;
  	}

  	.remember {
  		margin: 0px 0px 35px 0px;
  	}

</style>
