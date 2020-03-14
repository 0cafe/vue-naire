<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-05 11:02:25
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\controller\admin\Login.php
 */

namespace app\api\controller\admin;

use app\api\model\Admin;
use app\api\service\Token;
use \think\Validate;
use think\facade\Request;
class Login
{
    public function login()
    {
        $admin = new Admin();
        $data = Request::post();
        //        if( !captcha_check($data['code']) ){
        //            return '验证码错误';
        //        }

        $adminData = $admin->get(['a_username' => $data['a_username']]);
        if (!$adminData) {
            return writeJson(200,'','用户名不存在',20000);
        }
        $data['a_password'] = setPwd($data['a_password']);      //common里的方法
        if ($data['a_password'] != $adminData['a_password']) {
            return writeJson(200,'','密码错误',20000);
        } else {
            //更新登录IP和时间
            $udata = [
                'last_login_ip' => request()->ip(),   //TP5封装好的获取IP方法
                'last_login_time' => time(),
            ];
            $admin->update($udata, ['id' => $adminData->id]);
            //session
            //在'admin_scope'作用域下给 'admin' 赋值 $adminData
            $token = (new Token())->getToken($data['a_username']);
            return writeJson(
                201,
                [
                    'token' => $token,
                    'username' => $data['a_username'],
                ],
                '登陆成功'
            );
        }
    }

    public function validToken()
    {       
        $result = Token::valToken();
        return json(['token' => $result]);
    }
}
