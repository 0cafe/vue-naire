<?php

namespace app\api\controller\v1;

use app\api\model\Wenjuan as WenjuanModel;
use think\Request;

class Wenjuan{



	public function getWenjuans()
	{
		$result = WenjuanModel::all();
		return $result;
	}
	
	public function getWenjuan($id)
	{
		$result = WenjuanModel::get($id);
		return $result;
	}
	
	public function create(Request $request)
	{
	    $params = $request->post();
	    WenjuanModel::create($params);
	    return '新建图书成功';
	}
	
	public function update(Request $request)
	{
	    $params = $request->put();
	    $WenjuanModel = new WenjuanModel();
	    $WenjuanModel->save($params, ['id' => $params['id']]);
	    return '更新图书成功';
	}
	
	public function delete($bid)
	{
	    WenjuanModel::destroy($bid);	    
	    return '删除图书成功';
	}
	
}


?>