<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-04 16:33:39
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\controller\v1\Naire.php
 */

namespace app\api\controller\v1;

use app\api\model\Naire as NaireModel;
use app\api\model\Question as QuestionModel;
use app\lib\exception\ComException;
use Exception;
use think\Db;
use think\facade\Request;
use app\api\model\Options;
use app\api\service\Token;


class Naire
{

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
		QuestionModel::where('id','>','19')->delete();
		Options::where('id','>','35')->delete();
	}

	/**
	 * n_id获取
	 */
	public function getNaire($id)
	{
		$result = NaireModel::with('question.option')->where('n_id', '=', $id)->find();
		return json($result);
	}

	public function create()
	{
		$option = [
			0 => [
				'o_value' => 'o1'
			],
			1 => [
				'o_value' => 'o2'
			],
			2 => [
				'o_value' => 'o3'
			],
			3 => [
				'o_value' => 'o4'
			],
		];
		$params = [
			'naire' => [
				'n_title' => 'test',
			],
			'question' => [
				0 => [
					'q_content' => '1',
					'q_type' => '单选',
					'option' => $option
				],
				2 => [
					'q_content' => '2',
					'q_type' => '单选',
					'option' => $option
				],
				3 => [
					'q_content' => '3',
					'q_type' => '单选',
					'option' => $option
				],
				4 => [
					'q_content' => '4',
					'q_type' => '单选',
					'option' => $option
				],
			],
		];

		// $params = Request::post();
		Db::startTrans();
		try {
			$id = Token::getNowToken('id');
			$params['naire']['user_id'] = $id;
			$Naire = NaireModel::create($params['naire']);
			$nid = $Naire->id;
			$qusetions = $params['question'];
			foreach ($qusetions as &$item) {
				$item['n_id'] = $nid;
			}
			$qusetion = new QuestionModel();
			// $qusetion = $qusetion::create($qusetions);
			foreach ($qusetions as $i => $item) {
				$obj = QuestionModel::create($item);
				$option = $obj->option()->saveAll($item['option']);
			}
			Db::commit();
			return writeJson(201, '', '新建成功');
		} catch (Exception $e) {
			Db::rollback();
			throw new ComException(['msg' => '插入失败']);
		}
	}

	public function update(Request $request)
	{
		$params = input('');
		$NaireModel = new NaireModel();
		$NaireModel->save($params, ['n_id' => $params['n_id']]);
		return '更新成功';
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
