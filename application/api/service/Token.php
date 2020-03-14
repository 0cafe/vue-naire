<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-12 17:03:51
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\service\Token.php
 */


namespace app\api\service;


use think\facade\Cache;
use app\api\model\Admin as AdminModel;
use app\lib\exception\ComException;
use think\Exception;
use think\facade\Request;

class Token
{
    //  随机生成指定长度的字符串 可以放在common里
    public static function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for (
            $i = 0;
            $i < $length;
            $i++
        ) {
            $str .= $strPol[rand(0, $max)];
        }
        return $str;
    }

    //生成令牌方法
    public static function generateToken()
    {
        $randChar = self::getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt = config('setting.salt');
        return md5($randChar . $timestamp . $tokenSalt); // 随机数 + 时间 + 盐 -> md5加密
    }

    // 将令牌存入缓存
    public function saveToken($id, $username)
    {
        $value = [
            'id' => $id,
            'username' => $username
        ];
        //        $value = json_encode($value);   //存进缓存前 先存成字符串
        $token = self::generateToken();
        $_cache = Cache($token, $value, 7200); //(令牌作为键，id为值，有效时间）
        return $token;                         //这里返回token !!!!!!!!!!!!!!!!!!
    }

    public static function getNowToken($key)       //获取缓存里的token数据
    {
        $token = self::getHeader();
        if (!$token) {
            throw new ComException([
                'code' => 403,
                'msg' => '令牌不存在',
                'error_code' => 10000
            ]);
        }
        $vars = Cache::get($token);
        if (!$vars) {
            throw new ComException([
                'code' => 403,
                'msg' => '令牌不存在',
                'error_code' => 10000
            ]);
        } else {
            return $vars[$key];
        }
    }


    public function getToken($username)
    {
        $admin = new AdminModel();
        $admin = $admin::where('a_username', '=', $username)->find();
        $id = $admin->id;
        $token = $this->saveToken($id, $username);
        return $token;
    }

    /**
     * 验证token
     */
    public static function valToken()
    {
        $ao = request()->header('authorization');
        $token = explode(' ', $ao)[1];
        if (!$token) {
            return false;
        }
        $vars = Cache::get($token);
        if (!$vars) {
            return false;
        }
        return true;
    }

    public static function getHeader()
    {
        $ao = request()->header('authorization');
        $token = explode(' ', $ao)[1];
        return $token;
    }
}
