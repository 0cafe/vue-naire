// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import 'babel-polyfill'
import Vue from 'vue'
import axios from 'axios'
import App from './App'
import router from '@/router'
import api from './axios/api.js' // 导入api接口
import Vuex from 'vuex'
import store from './vuex/store.js'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import '@/assets/styles/index.scss'
import valitoken from '@/common/token.js'

Vue.config.productionTip = false
Vue.prototype.$api = api; // 将api挂载到vue的原型上复制代码

Vue.use(Vuex)
Vue.use(ElementUI);

//rem适配
function flex() {
  let htmlwidth = document.documentElement.clientWidth || document.body.clientWidth;
  console.log("屏幕宽度：" + htmlwidth)
  let htmlDom = document.getElementsByTagName('html')[0];
  htmlDom.style.fontSize = htmlwidth / 20 + 'px';
}
flex();
window.onresize = function() {
  flex();
}

valitoken()


if (localStorage.token && localStorage.username) {
  store.state.token = localStorage.token
  store.state.username = localStorage.username
}

//用router的钩子函数 设置访问权限
router.beforeEach((to, from, next) => {
  // 获取 JWT Token
  if (to.meta.requireAuth ){
    console.log('auh')
    // 判断该路由是否需要登录权限
    if (localStorage.getItem('token')) {
      // 通过获取当前的token是否存在
      console.log('?')
      next()
    } else {
      next({
        path: '/login',
        query: {
          redirect: to.fullPath
        }
        // 将跳转的路由path作为参数，登录成功后跳转到该路由
      })
    }
  } else {
    next()
  }
})


/* eslint-disable no-new */
const vm = new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

window.App = vm

export default vm
