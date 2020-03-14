import naireRouter from './stage/naireRouter.js'
// const login = () => import('@/views/login.vue')
// const home = () => import('@/views/home.vue')

const routes = [
  {
    path: '/',
    name: 'index',
    meta: {
      requireAuth: true
    },
    hidden:true,
    redirect: '/home'
  },
  {
    path: '/login',
    name: 'login',
    hidden:true,
    component: () => import('@/views/login.vue')
  },
  {
    path:'/register',
    name:'登陆',
    hidden:true,
    component: () => import('@/views/register.vue')
  },
  {
    path:'/naire/:id',
    name:'问卷调查',
    hidden:true,
    component: () => import('@/views/naire.vue')
  },
  ...naireRouter,
  {
    path: '*',
    component: () => import('@/views/404'),
    name: '404',
    hidden: true
  }
]

export default routes
