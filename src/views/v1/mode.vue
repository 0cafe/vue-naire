<template>
  <div>
  <el-row class="container">
    <el-col :span="24" class="header">
      <el-col :span="10" class="logo" :class="collapsed?'logo-collapse-width':'logo-width'">
           naire
      </el-col>
      <el-col :span="10">
        <div class="tools" @click.prevent="collapse">
          <i class="fa fa-align-justify"></i>
        </div>
      </el-col>
      <el-col :span="4" class="userinfo">
        <el-dropdown trigger="hover">
          <span class="el-dropdown-link userinfo-inner"><img :src="this.sysUserAvatar" /> {{sysUserName}}</span>
          <el-dropdown-menu slot="dropdown">
            <!-- <el-dropdown-item>我的消息</el-dropdown-item>
            <el-dropdown-item>设置</el-dropdown-item> -->
            <el-dropdown-item divided @click.native="logout">退出登录</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </el-col>
    </el-col>
   </el-row>
   <el-row>
    <el-col :span="4" class="main">
      <aside :class="collapsed?'menu-collapsed':'menu-expanded'">
        <template v-for="(item,i) in $router.options.routes" v-if="!item.hidden">
          <el-menu router="true" default-active="$router.path" class="el-menu-vertical-demo">
            <el-submenu index="1">
              <template slot="title">
                <i class="el-icon-location"></i>
                <span>{{item.name}}</span>
              </template>
              <template v-if="item.children.length > 0" v-for="(children,index) in item.children">
                <el-menu-item :index="children.path">{{children.name}}</el-menu-item>
              </template>
            </el-submenu>
          </el-menu>
        </template>
      </aside>
    </el-col>
    <el-col :span="18" class="content-wrapper">
        <router-view></router-view>
    </el-col>
  </el-row>
  </div>
</template>

<script>
  export default {
    created() {}
  }
</script>

<style scoped lang="scss">
  @import'@/assets/styles/index.scss';

  .container {
    .header {
      width: 100%;
      height: 60px;
      line-height: 60px;
      background: $theme;
      color: #fff;
      .userinfo {
        text-align: right;
        padding-right: 35px;
        float: right;
        .userinfo-inner {
          cursor: pointer;
          color: #fff;
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
          color: #fff;
        }
      }

      .logo-width {
        width: 230px;
      }

      .logo-collapse-width {
        width: 60px
      }

      .tools {
        padding: 0px 23px;
        width: 14px;
        height: 60px;
        line-height: 60px;
        cursor: pointer;
      }
    }
    .main{

    }

  }
</style>
