const categoryRouter = {
  route: null,
  name: null,
  title: '分类管理',
  type: 'folder', // 类型: folder, tab, view
  icon: 'iconfont icon-tushuguanli',
  filePath: 'views/category/', // 文件路径
  order: null,
  inNav: true,
  permission: ['超级管理员独有权限'],
  children: [
    {
      title: '添加分类',
      type: 'view',
      name: 'categoryAdd',
      route: '/category/add',
      filePath: 'views/category/categoryAdd.vue',
      inNav: true,
      icon: 'iconfont icon-tushuguanli',
    },
    {
      title: '分类列表',
      type: 'view',
      name: 'categoryAdd',
      route: '/category/list',
      filePath: 'views/category/categoryList.vue',
      inNav: true,
      icon: 'iconfont icon-tushuguanli',
    },
  ],
}

export default categoryRouter
