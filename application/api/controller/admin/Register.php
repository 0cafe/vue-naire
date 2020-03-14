<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-14 09:50:36
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\controller\admin\Login.php
 */

namespace app\api\controller\admin;

use app\api\model\Admin;
use app\api\service\Token;
use app\api\validate\RegisterValidate;
use think\facade\Request;

class Register
{
    public function register()
    {
        $params = Request::post();
        $validate = new RegisterValidate();
        if (!$validate->check($params)) {
            return $validate->getError();
        }
        if ($params['a_password'] !== $params['password']) {
            return '两次输入的密码不一致';
        }
        $admin = new Admin();
        $adminData = $admin->where('a_username', $params['a_username'])->find();   //没查到返回null
        if ($adminData) {
            return '用户名已被注册';
        }
        $password = setPwd($params['a_password']);
        $data = [
            'a_username' => $params['a_username'],
            'a_password' => $password,
            'auth' => 1
        ];
        $admin->allowField(true)->save($data);
        return writeJson(201, '', '注册成功');
    }



    public function validToken()
    {
        $result = Token::valToken();
        return json(['token' => $result]);
    }
}
