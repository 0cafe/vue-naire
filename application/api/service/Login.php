<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-17 11:38:59
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\service\Token.php
 */


namespace app\api\service;


use think\facade\Cache;
use app\api\model\Admin as AdminModel;
use app\api\service\Token;
use app\lib\auth\Status;
use app\lib\exception\AuthException;
use app\lib\exception\ComException;
use think\Exception;
use think\facade\Request;

class Login
{
    public static function checkStatus()
    {
        $id = Token::getNowToken('id');
        $status = AdminModel::get($id)->status;
        if ($status == Status::Forbid) {
            throw new AuthException([
                'msg' => '账号已被封禁',
            ]);
        }
        return true;
    }
}
