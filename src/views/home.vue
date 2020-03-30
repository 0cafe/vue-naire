<template>
  <el-container>
    <el-aside width="200px">
      <div class="head">

      </div>
      <aside class="menu-expanded">

        <el-menu background-color="#192a5e" text-color="white" active-text-color="" router :default-active="$route.path"
          class="el-menu-vertical-demo">
          <el-menu-item index="/home/about">
            <i class="el-icon-info"></i>
            <span>vue-naire-system</span>
          </el-menu-item>
          <template v-for="(item,i) in $router.options.routes" v-if="!item.hidden">
            <el-submenu :index="item.path">
              <template slot="title">
                <i :class="item.icon"></i>
                <span>{{item.name}}</span>
              </template>
              <template v-for="(children,index) in item.children"
               v-if="item.children.length > 0
               && children.path!='about' && !children.hidden
               && children.auth <= auth"
               >
                <el-menu-item :index="`${item.path}/` + children.path">
                  <i :class="children.icon"></i>
                  {{children.name}}
                </el-menu-item>
              </template>
            </el-submenu>
          </template>
        </el-menu>

      </aside>
    </el-aside>
    <el-container>
      <el-header>
        <el-col :span="24" class="header">
          <el-col :span="10" class="logo" :class="'logo-width'">
            问卷后台
          </el-col>
          <el-col :span="10">
            <div class="tools" @click.prevent="collapse">
              <i class="fa fa-align-justify"></i>
            </div>
          </el-col>
          <el-col :span="4" class="userinfo">
            <el-dropdown trigger="hover">
              <span class="el-dropdown-link userinfo-inner"><img src="../assets/head.jpg" /> {{username}}</span>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item>我的消息</el-dropdown-item>
                <el-dropdown-item>设置</el-dropdown-item>
                <el-dropdown-item divided @click.native="logout">退出登录</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </el-col>
        </el-col>
      </el-header>

      <el-main :span="18">
        <div class="path">
          <div>
            <p>{{$router.currentRoute.matched[0].name}} / </p>{{$router.currentRoute.matched[1].name}}
          </div>
          <div class="back" v-if=" $route.path!='/home/about' && $route.path!='/home/list' " @click="back">返回</div>
        </div>
        <div class="view">
          <router-view></router-view>
        </div>
      </el-main>

      <!-- <el-footer>Footer</el-footer> -->
    </el-container>
  </el-container>

</template>

<script>
  export default {
    data() {
      return {
        parent: '',
        children: '',
        path: ''
      }
    },
    methods: {
      logout() {
        localStorage.removeItem('token')
        localStorage.removeItem('username')
        localStorage.removeItem('auth')
        this.$router.push('/login')
      },
      back() {
        this.$router.back()
      },
      close() {

      }
    },
    computed: {
      username() {
        return localStorage.username
      },
      auth() {
        return localStorage.auth
      }
      // routePath(){

      // }
    },
    created() {
      // console.log(this.$router)
      let routes = this.$router.options.routes

      this.path = this.$router.path
      // this.opends =
    }
  }
</script>

<style scoped lang="scss">
  .el-container {
    background-color: #f6f6f6;
  }

  .el-header {
    height: 60px;
    // background-color: #eef4f9;
    background-image: linear-gradient(to right,#a7bfe8,#eef4f9);

    .userinfo {
      line-height: 60px;
      text-align: right;
      padding-right: 35px;
      float: right;

      .userinfo-inner {

        cursor: pointer;
        color: #7794d1;

        img {
          width: 40px;
          height: 40px;
          border-radius: 20px;
          margin: 10px 0px 10px 10px;
          float: right;
        }
      }
    }

    .logo {
      //width:230px;
      height: 60px;
      font-size: 22px;
      padding-left: 20px;
      padding-right: 20px;
      border-color: rgba(238, 241, 146, 0.3);
      border-right-width: 1px;
      border-right-style: solid;

      img {
        width: 40px;
        float: left;
        margin: 10px 10px 10px 18px;
      }

      .txt {
        color: #7794d1;
      }
    }

    .logo-width {
      width: 230px;
      line-height: 60px;
      font-size: 28px;
      color: #FFFFFF;
    }

    .logo-collapse-width {
      width: 60px
    }
  }

  .el-aside {
    // background-color: #20a0ff;
    // border: .5px solid #1111;
    min-height: 100vh;
    background-color: #192a5e;
    // background-image: Liner-gradient;

    .head {
      height: 60px;
      width: 100%;
      background-color: #122150;
    }
  }

  .el-main {
    .path {
      display: flex;
      justify-content: space-between;
      width: 100%;
      height: 30px;
      line-height: 30px;
      color: #7794d1;

      .back {
        margin-right: 50px;
        cursor: pointer;
        font-size: 16px;
      }

      p {
        display: inline;
        color: #999;
      }
    }

    margin: 15px;
    background-color: #FFFFFF;
  }

  body>.el-container {}
</style>
