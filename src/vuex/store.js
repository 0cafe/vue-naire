import Vue from 'vue'
import Vuex from 'vuex'

// 头部分类

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    username: '',
    token: '',
    auth: ''
  },
  mutations: {
    getUsername(state, res) {
      state.username = res
      localStorage.setItem('username', res);
    },
    getToken(state, res) {
      var exp = new Date().getTime() + 7200000
      state.token = res.token
      state.username = res.username
      state.auth = res.auth
      localStorage.setItem('token', res.token);
      localStorage.setItem('username', res.username);
      localStorage.setItem('auth', res.auth);
    },
    deleteToken(state, res) {
      state.token = ''
      state.username = null
      state.auth = null
      localStorage.removeItem('token')
      localStorage.removeItem('username');
      localStorage.removeItem('auth');
    }
  }
})
