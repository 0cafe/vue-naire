const userRouter = {
  route: null,
  name: null,
  title: '用户管理',
  type: 'folder', // 类型: folder, tab, view
  icon: 'iconfont icon-tushuguanli',
  filePath: 'views/user/', // 文件路径
  order: null,
  inNav: true,
  permission: ['超级管理员独有权限'],
  children: [
    {
      title: '用户列表',
      type: 'view',
      name: 'userAdd',
      route: '/user/list',
      filePath: 'views/user/UserList.vue',
      inNav: true,
      icon: 'iconfont icon-tushuguanli',
	  permission: ['管理员']
    },
  ],
}

export default userRouter
