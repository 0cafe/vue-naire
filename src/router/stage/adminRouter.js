const adminRouter = [{
  path: '',
  redirect: '/home/user',
  name: '用户管理',
  icon: 'el-icon-user',
  component: () => import('@/views/home.vue'),
  meta: {
    requireAuth: true
  },
  children: [
    {
      path: 'user',
      name: '用户列表',
      icon: 'el-icon-user',
      component: () => import('@/views/userList.vue'),
      meta: {
        requireAuth: true,
      },
      auth:2
    },
    {
      path: 'edit',
      name: '修改密码',
      icon: 'el-icon-reading',
      auth:1,
      component: () => import('@/views/userEdit.vue'),
      meta: {
        requireAuth: true
      }
    },
  ]
}, ]

export default adminRouter
