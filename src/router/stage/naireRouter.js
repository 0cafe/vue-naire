const naireRouter = [{
  path: '/home',
  redirect: '/home/about',
  name: '问卷管理',
  icon: 'el-icon-document',
  component: () => import('@/views/home.vue'),
  meta: {
    requireAuth: true
  },
  children: [{
      path: 'about',
      name: 'about',
      component: () => import('@/views/about.vue'),
      meta: {
        requireAuth: true
      },
      auth:1,
      hidden: true
    },
    {
      path: 'list',
      name: '问卷列表',
      icon: 'el-icon-reading',
      component: () => import('@/views/list.vue'),
      auth:1,
      meta: {
        requireAuth: true
      }
    },
    {
      path: 'create',
      name: '新建问卷',
      icon: 'el-icon-document-add',
      component: () => import('@/views/add.vue'),
      auth:1,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/edit/:id',
      name: '编辑问卷',
      hidden: true,
      auth:1,
      icon: 'el-icon-document-add',
      component: () => import('@/views/edit.vue'),
      meta: {
        requireAuth: true
      }
    }
  ]
}, ]

export default naireRouter
