<template>
  <el-form :model="userData" label-position="left" label-width="0px" class=" login-container">
  	<h3 class="title">系统登录</h3>
  	<el-form-item prop="account">
  		<el-input type="text" v-model="userData.a_username"  placeholder="账号"></el-input>
  	</el-form-item>
  	<el-form-item prop="checkPass">
  		<el-input type="password" v-model="userData.a_password"  placeholder="密码"></el-input>
  	</el-form-item>
  	<el-form-item>
  		<el-button type="primary" style="" @click.native.prevent="submitForm()">登录</el-button>
      <el-button type="primary" style="" @click.native.prevent="register()">注册</el-button>
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
      },
      register(){
        this.$router.push('/register')
      }
    },
  }
</script>

<style lang="scss" scoped="scoped">
  .login-container{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  	-webkit-border-radius: 5px;
  	border-radius: 5px;
  	-moz-border-radius: 5px;
  	background-clip: padding-box;
  	margin: 180px auto;
  	width:400px;
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
