const orderRouter = {
	route: null,
	name: null,
	title: '订单管理',
	type: 'folder', // 类型: folder, tab, view
	icon: 'iconfont icon-tushuguanli',
	filePath: 'views/order/', // 文件路径
	order: null,
	inNav: true,
	permission: ['商家权限'],
	children: [{
			title: '订单列表',
			type: 'view',
			name: 'orderAdd',
			route: '/order/list',
			filePath: 'views/order/OrderList.vue',
			inNav: true,
			icon: 'iconfont icon-tushuguanli',
		},
		{
			title: '金额统计',
			type: 'view',
			name: 'orderCount',
			route: '/order/count',
			filePath: 'views/order/orderCount.vue',
			inNav: true,
			icon: 'iconfont icon-tushuguanli',
		}
	],
}

export default orderRouter
