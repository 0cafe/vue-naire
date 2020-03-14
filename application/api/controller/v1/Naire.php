<?php
/*
 * @Author: your name
 * @Date: 2020-03-07 16:35:36
 * @LastEditTime: 2020-03-07 16:36:58
 * @LastEditors: your name
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\controller\v1\Naire.php
 */

namespace app\api\controller\v1;

use app\api\model\Naire as NaireModel;
use think\Request;

class Naire {
    
	public function getNaires()
	{
		$result = NaireModel::all();
		return json($result);
	}
	
	public function getNaire($id)
	{   	
		$result = NaireModel::get($id);
		return json($result);
	}
	
	public function create(Request $request)
	{		
	    $params = input('');
		$Naire = new NaireModel($params);
	    $Naire->save();
	    return $Naire->n_id;
	}
	
	public function update(Request $request)
	{
	    $params = input('');
	    $NaireModel = new NaireModel();
	    $NaireModel->save($params, ['n_id' => $params['n_id']]);
	    return '更新成功';
	}
	
	public function delete($id)
	{
	    NaireModel::destroy($id);	    
	    return '删除成功';
	}
	
}