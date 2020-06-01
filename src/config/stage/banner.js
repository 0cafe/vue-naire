const bannerRouter = {
	route: null,
	name: null,
	title: 'banner图管理',
	type: 'folder', // 类型: folder, tab, view
	icon: 'iconfont icon-tushuguanli',
	filePath: 'views/banner/', // 文件路径
	order: null,
	inNav: true,
	permission: ['超级管理员独有权限'],
	children: [{
			title: 'banner图列表',
			type: 'view',
			name: 'bannerAdd',
			route: '/banner/list',
			filePath: 'views/banner/bannerList.vue',
			inNav: true,
			icon: 'iconfont icon-tushuguanli',
		},
		{
			title: '添加banner图',
			type: 'view',
			name: 'bannerAdd',
			route: '/banner/add',
			filePath: 'views/banner/bannerAdd.vue',
			inNav: true,
			icon: 'iconfont icon-tushuguanli',
		},
	],
}

export default bannerRouter
