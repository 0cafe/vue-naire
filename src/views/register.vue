<template>
  <!-- <div class="box">
    账号 :<input type="text" size="small" placeholder="请输入账号" v-model="userData.a_username" class="form-control" />
     密码 : <input type="password" size="small" placeholder="请输入密码" v-model="userData.a_password" class="form-control"/>
     <button class="btn btn-primary" @click="submitForm()">登录</button>
  </div> -->
  <el-form :model="userData" label-position="left" label-width="100px" class=" login-container">
  	<h3 class="title">注册</h3>
  	<el-form-item prop="account" label="用户名 :">
  		<el-input type="text" v-model="userData.a_username" placeholder="账号"></el-input>
  	</el-form-item>
  	<el-form-item prop="checkPass" label="密码 :">
  		<el-input type="password" v-model="userData.a_password"  placeholder="密码"></el-input>
  	</el-form-item>
    <el-form-item prop="checkPass"label="确认密码 :">
    	<el-input type="password" v-model="userData.password"  placeholder="密码"></el-input>
    </el-form-item>
  	<!-- <el-checkbox v-model="checked" checked class="remember">记住密码</el-checkbox> -->
  	<el-form-item >
  		<el-button type="primary"  @click.native.prevent="submitForm()">注册</el-button>
      <el-button type="primary"  @click.native.prevent="login()">去登陆</el-button>
  		<!--<el-button @click.native.prevent="handleReset2">重置</el-button>-->
  	</el-form-item>
  </el-form>
</template>

<script>
  import {post} from '@/axios/api.js'
  import {errorToast,successToast,warningToast} from '@/common/toast'
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
        await post('/register',this.userData)
        .then(res=>{
          if(!res.msg){
            errorToast(res)
            console.log(res)
          }else{
            successToast(res.msg)
            window.location = "/#/login"
          }
        })
      },
      login(){
        this.$router.push('/login')
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
  	width: 400px;
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
