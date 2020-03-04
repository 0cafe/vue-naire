<?php
namespace app\api\controller\v1;


use app\api\model\Result as ResultModel;
use think\Request;

class Result extends Base{
    protected $beforeActionList = [
        'checkAuth'  =>  ['except'=>'create'],     //除了''都调用前置
    ];

	public function getResults()
	{
		$result = ResultModel::all();
		return json($result);
	}
	
	public function getResult($id)
	{   	
		$result = ResultModel::all(['n_id'=>$id,]);  //all()获取多条数据
		return json($result);
	}
	
	public function create(Request $request)
	{   
		$user = new ResultModel;
	    $params = input('');
        $user->allowField(true)->saveAll($params);  //过滤非表单字段value 不然会插入失败	    
	    return '新建成功';
	}
	
	public function update(Request $request)
	{
	    $params = $request->put();
	    $ResultModel = new ResultModel();
	    $ResultModel->save($params, ['id' => $params['id']]);
	    return '更新成功';
	}
	
	public function delete($id)
	{
	    ResultModel::destroy($id);	    
	    return '删除成功';
	}
	
}