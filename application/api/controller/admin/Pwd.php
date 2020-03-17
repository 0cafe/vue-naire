<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-17 10:22:42
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\controller\admin\Login.php
 */

namespace app\api\controller\admin;

use think\facade\Request;
use app\api\service\Token;
use app\api\validate\RegisterValidate;
use app\api\model\Admin;

class Pwd
{
    public function changePwd()
    {
        $params = Request::put();
        $validate = new RegisterValidate();
        if (!$validate->check($params)) {
            return $validate->getError();
        };
        if ($params['a_password'] != $params['checkword']) {
            return '两次输入密码不一致';
        }
        $password = setPwd($params['a_password']);
        $id = Token::getNowToken('id');
        $result = (new Admin())->where('id', $id)->update(['a_password' => $password]);
        return writeJson(202, '', '修改成功');
    }
}
