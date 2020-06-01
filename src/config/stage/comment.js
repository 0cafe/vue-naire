const commentRouter = {
  route: null,
  name: null,
  title: '评论管理',
  type: 'folder', // 类型: folder, tab, view
  icon: 'iconfont icon-tushuguanli',
  filePath: 'views/comment/', // 文件路径
  order: null,
  inNav: true,
  permission: ['超级管理员独有权限'],
  children: [	
    {
      title: '评论列表',
      type: 'view',
      name: 'commentList',
      route: '/comment/list',
      filePath: 'views/comment/commentList.vue',
      inNav: true,
      icon: 'iconfont icon-tushuguanli',
    },
  ],
}

export default commentRouter
