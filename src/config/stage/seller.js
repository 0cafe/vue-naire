const sellerRouter = {
  route: null,
  name: null,
  title: '商家管理',
  type: 'folder', // 类型: folder, tab, view
  icon: 'iconfont icon-tushuguanli',
  filePath: 'views/seller/', // 文件路径
  order: null,
  inNav: true,
  permission: ['超级管理员独有权限'],
  children: [
    {
      title: '添加商家',
      type: 'view',
      name: 'sellerAdd',
      route: '/seller/add',
      filePath: 'views/seller/SellerAdd.vue',
      inNav: true,
      icon: 'iconfont icon-tushuguanli',
    },
    {
      title: '商家列表',
      type: 'view',
      name: 'sellerAdd',
      route: '/seller/list',
      filePath: 'views/seller/SellerList.vue',
      inNav: true,
      icon: 'iconfont icon-tushuguanli',
    },
  ],
}

export default sellerRouter
