import Vue from 'vue'
import Router from 'vue-router'
import routes from './routes.js'

Vue.use(Router)

const router = new Router({
  routes,
	scrollBehavior: () => ({
	  y: 0,
	}),
	// base: process.env.BASE_URL,
  linkActiveClass: 'router-active'
})

export default router
