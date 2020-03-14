<?php
/*
 * @Author: your name
 * @Date: 2020-03-07 16:35:36
 * @LastEditTime: 2020-03-13 11:27:57
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\controller\v1\Options.php
 */

namespace app\api\controller\v2;

use app\api\model\Options as OptionsModel;
use think\Request;

class Option{

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
	    return writeJson(201,'','删除成功');
	}
	
}