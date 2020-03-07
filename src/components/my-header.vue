<template>
  <div>
   <nav class="navbar myNavbar">
   <div class="content">
   <div class="navbar-header">
   <span class="navbar-brand myBrand">Investigation</span>
   </div>
   <ul class="nav navbar-nav myUl" v-show="username">
   <li><router-link class="myLink" to="/" exact>问卷菜单</router-link></li>
	 <li><router-link class="myLink" to="/add">问卷管理</router-link></li>
   </ul>
   <p class="navbar-text myText" v-if="!username">请先登录-</p>
   <p class="navbar-text myText" v-if="username">用户:{{username}}</p>
   <a href="#" class="navbar-text myText2"  @click="del()" v-if="username">注销</a>
   </div>



   </nav>
  </div>
</template>

<script>
  export default {
     computed: {
       username() {
         return this.$store.state.username
       }
     },
     methods: {
       del() {
         this.$store.commit('deleteToken','1')
         this.$router.replace('/login')
       }
     },
  }
</script>

<style scoped="scoped">

.navbar{
  height: 80px;
  border-bottom: 1px solid #1111;
}
.content{
  margin-top: 15px;
}
.myLink:hover{
  background: none;
  color:#1989fa ;
}
.myLink,.myLink:hover{
  color: #8cc4fc;
  font-size: 16px;
  height: 65px;
  text-decoration: none;

}
.router-active{
  color:#1989fa ;
  border-bottom: 1px solid #1989fa;
}
.myUl{
  margin-left: 30%;
}
li{
  margin-right:30px ;
}
.myBrand{
  font-size: 32px;
  font-weight: bold;
  color: #409eff;
}
.myText{
  color: #999;
}
.myText2{
  color: #999;
  text-decoration: none;
}
@media screen and (max-width: 700px){
  .myNavbar{
    display: none;
  }
}
</style>
