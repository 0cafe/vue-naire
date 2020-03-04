<?php

namespace app\api\controller\v1;

use app\api\model\Options as OptionsModel;
use think\Request;

class Options extends Base{
    protected $beforeActionList = [
        'checkAuth'  =>  ['only'=>'create,update,delete'],
    ];
    //
	public function getOptionss()
	{
		$result = OptionsModel::all();
		return json($result);
	}
	
	public function getOptions($id)
	{   	
		$result = OptionsModel::all(['n_id'=>$id]);
		return json($result);
	}
	
	public function create(Request $request)
	{   
		$params = input('');
	    $Options = new OptionsModel($params);
		
	    $Options->allowField(true)->save($params);
	    return '新建成功';
	}
	
	public function update(Request $request)
	{
	    $params = $request->put();
	    $OptionsModel = new OptionsModel();
	    $OptionsModel->save($params, ['id' => $params['id']]);
	    return '更新成功';
	}
	
	public function delete($id)
	{
	    OptionsModel::destroy($id);	    
	    return '删除成功';
	}
	
}