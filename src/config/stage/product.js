const productRouter = {
  route: null,
  name: null,
  title: '商品管理',
  type: 'folder', // 类型: folder, tab, view
  icon: 'iconfont icon-tushuguanli',
  filePath: 'views/product/', // 文件路径
  order: null,
  inNav: true,
  permission: ['商家'],
  children: [
    {
      title: '添加商品',
      type: 'view',
      name: 'productAdd',
      route: '/product/add',
      filePath: 'views/product/productAdd.vue',
      inNav: true,
      icon: 'iconfont icon-tushuguanli',
    },
    {
      title: '商品列表',
      type: 'view',
      name: 'productAdd',
      route: '/product/list',
      filePath: 'views/product/productList.vue',
      inNav: true,
      icon: 'iconfont icon-tushuguanli',
    },
  ],
}

export default productRouter
