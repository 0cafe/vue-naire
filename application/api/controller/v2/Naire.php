<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-13 14:37:20
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\controller\v1\Naire.php
 */

namespace app\api\controller\v2;

use app\api\model\Naire as NaireModel;
use app\api\model\Question as QuestionModel;
use app\lib\exception\ComException;
use Exception;
use think\Db;
use think\facade\Request;
use app\api\model\Options;
use app\api\service\Token;
use app\api\model\Result as ResultModel;

class Naire
{
	/**
	 * 回答问卷
	 */
	public function answer()
	{
		$result = new ResultModel();
		$params = Request::post();
		$result = $result->allowField(true)->saveAll($params);  //过滤非表单字段value 不然会插入失败	
		// if(!$result || empty($result)){
		// 	throw new ComException([
		// 		'code' => 500,
		// 		'error_code' => 30000,
		// 		'msg' => '内部错误'
		// 	]);
		// }    
		return writeJson(201, '', '提交成功');
	}

	/**
	 * 按用户获取列表
	 */
	public function getNaireByUser()
	{
		$id = Token::getNowToken('id');
		$result = NaireModel::where('user_id', $id)->select();
		return json($result);
	}

	public function clear()
	{
		QuestionModel::where('id', '>', '19')->delete();
		Options::where('id', '>', '35')->delete();
	}

	/**
	 * n_id获取
	 */
	public function getNaire($id)
	{
		$result = NaireModel::with('questions.option')->where('id', '=', $id)->find();
		return json($result);
	}

	/**
	 * 新建问卷
	 */
	public function create()
	{
		$params = Request::post();
		Db::startTrans();
		try {
			$id = Token::getNowToken('id');
			$params['user_id'] = $id;
			$tdata = [
				'n_title' => $params['n_title'],
				'n_status' => $params['n_status'],
				'user_id' => $id
			];
			// $Naire = (new NaireModel())->allowField(true)->save($params);		
			$Naire = NaireModel::create($tdata);
			$nid = $Naire->id;
			$qusetions = $params['questions'];
			foreach ($qusetions as &$item) {
				$item['n_id'] = $nid;
				foreach ($item['option'] as &$i) {
					$i['n_id'] = $nid;
				}
			}
			$qusetion = new QuestionModel();
			// $qusetion = $qusetion::create($qusetions);
			foreach ($qusetions as $key => $q) {
				$obj = QuestionModel::create($q);
				$option = $obj->option()->saveAll($q['option']);
			}
			Db::commit();
			return writeJson(201, '', '新建成功');
		} catch (Exception $e) {
			Db::rollback();
			throw new ComException(['msg' => '插入失败' . $e]);
		}
	}

	/**
	 * 更新问卷
	 */
	public function update()
	{
		$params = Request::put();
		Db::startTrans();
		try {
			$id = Token::getNowToken('id');
			if ($id != $params['user_id']) {
				throw new ComException(['msg' => 'id不匹配']);
			}
			$tdata = [
				'id' => $params['id'],
				'n_title' => $params['n_title'],
				'n_status' => $params['n_status'],
				'user_id' => $id
			];
			// $Naire = (new NaireModel())->allowField(true)->save($params);		
			$Naire = NaireModel::update($tdata);
			$nid = $params['id'];
			$qusetions = $params['questions'];
			foreach ($qusetions as &$item) {
				$item['n_id'] = $nid;
				foreach ($item['option'] as &$i) {
					$i['n_id'] = $nid;
				}
			}
			$qusetion = new QuestionModel();
			$optionModel = new Options();
			foreach ($qusetions as $key => $q) {
				if (!array_key_exists('id', $q)) {
					// 新增
					$obj = QuestionModel::create($q);
					$option = $obj->option()->saveAll($q['option']);
				} else {
					// 更新	
					$obj = QuestionModel::update($q, ['id' => $q['id']]);
					foreach ($q['option'] as $o) {
						$o['q_id'] = $q['id'];
						if (array_key_exists('id', $o)) { //更新选项														
							$r = Options::update($o, ['id' => $o['id']]);
						} else {
							$r = $optionModel->save($o);
						}
					}
				}
			}
			Db::commit();
			return writeJson(201, '', '更新成功');
		} catch (Exception $e) {
			Db::rollback();
			throw new Exception($e);
		}
	}


	/**
	 * 改变问卷状态
	 */
	public function modifyStatus($id)
	{
		$Naire = NaireModel::get($id);
		if (!$Naire) {
			throw new ComException([
				'code' => 404,
				'errorCode' => 10001,
				'msg' => '没查询到相关问卷'
			]);
		}
		$Naire->n_status = !$Naire->n_status;
		$Naire->save();
		return writeJson(201, [], '状态已经修改');
	}

	/**
	 * 关联问卷数据删除
	 */
	public function delete($id)
	{

		Db::startTrans();
		try {
			NaireModel::destroy($id);
			$data = QuestionModel::where('n_id', $id)->field('id')->select();
			foreach ($data as $item) {
				$qusetion = QuestionModel::get($item['id'], 'option');
				$qusetion->together('option')->delete();
			}
			Db::commit();
			return writeJson(201, '', '删除成功');
		} catch (Exception $e) {
			Db::rollBack();
			throw new Exception($e);
		}
	}
}
