<?php
/*
 * @Author: your name
 * @Date: 2020-03-17 09:47:07
 * @LastEditTime: 2020-03-17 09:59:44
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\controller\v2\User.php
 */

namespace app\api\controller\v2;
use app\api\model\User as UserModel;
use think\facade\Request;
use app\api\service\Token;
class User
{
    public function login()
    {
        $admin = new UserModel();
        $data = Request::post();
        //        if( !captcha_check($data['code']) ){
        //            return '验证码错误';
        //        }

        $adminData = $admin->get(['a_username' => $data['a_username']]);
        if (!$adminData) {
            return writeJson(200, '', '用户名不存在', 20000);
        }
        $data['a_password'] = setPwd($data['a_password']);      //common里的方法
        if ($data['a_password'] != $adminData['a_password']) {
            return writeJson(200, '', '密码错误', 20000);
        } else {
            if ($adminData['status'] === 0) {
                return writeJson(200, '', '账号异常', 43000);
            }
            //更新登录IP和时间
            $udata = [
                'last_login_ip' => request()->ip(),   //TP5封装好的获取IP方法
                'last_login_time' => time(),
            ];
            $admin->update($udata, ['id' => $adminData->id]);
            $auth = $adminData->auth;
            //session
            //在'admin_scope'作用域下给 'admin' 赋值 $adminData
            $token = (new Token())->getToken($data['a_username'], $adminData->id, $auth);
            return writeJson(
                201,
                [
                    'token' => $token,
                    'username' => $data['a_username'],
                    'auth' => $auth
                ],
                '登陆成功'
            );
        }
    }
}
