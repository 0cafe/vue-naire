<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-13 11:33:15
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\controller\v2\Question.php
 */

namespace app\api\controller\v2;

use app\api\model\Question as QuestionModel;
use think\Request;

class Question
{
	public function getQuestions()
	{
		$result = QuestionModel::all();
		return json($result);
	}

	public function getQuestion($q_id)
	{
		$result = QuestionModel::all(['n_id' => $q_id]);  //获取问卷id为..的
		return json($result);
	}

	public function create(Request $request)
	{
		// $params = $request->post();
		// QuestionModel::create($params);
		// return '新建成功';
		// $params = $request->post();
		$params = input('');
		dump($params);
		$question = new QuestionModel($params);
		// $params->data([
		// 	'n_id'=>'1',
		// 	'q_isrequire'=>'1'
		// ]);
		$question->allowField(true)->save($params);
		return $question->q_id;
	}

	public function update(Request $request)
	{
		// $params = $request->put();
		$params = input('');
		$QuestionModel = new QuestionModel();
		$QuestionModel->save($params, ['id' => $params['id']]);
		return '更新成功';
	}

	/**
	 * 问题关联选项删除
	 */
	public function delete($id)
	{
		$qusetion = QuestionModel::get($id, 'option');
		$qusetion->together('option')->delete();
		return writeJson(201, '', '删除成功');
	}
}
