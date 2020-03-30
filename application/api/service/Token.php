<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-20 17:30:10
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\service\Token.php
 */


namespace app\api\service;


use think\facade\Cache;
use app\api\model\Admin as AdminModel;
use app\lib\exception\AuthException;
use app\lib\exception\ComException;
use app\lib\auth\Status;
use Exception;

class Token
{
    //  随机生成指定长度的字符串 可以放在common里
    public static function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;
        for ($i = 0;$i < $length;$i++) {
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
    public function saveToken($id, $username, $auth)
    {
        $value = [
            'id' => $id,
            'username' => $username,
            'auth' => $auth
        ];
        //        $value = json_encode($value);   //存进缓存前 先存成字符串
        $token = self::generateToken();
        $_cache = Cache::store('redis')->set($token, $value, config('setting.token_time')); //(令牌作为键，id为值，有效时间）
        return $token;                         //这里返回token !!!!!!!!!!!!!!!!!!
    }

    //获取缓存里的token数据
    public static function getNowToken($key)      
    {
        $header = request()->header('authorization');
        $token = explode(' ', $header)[1];
        if (!$token) {
            throw new ComException([
                'code' => 403,
                'msg' => '请携带令牌',
                'error_code' => 10000
            ]);
        }
        $vars = Cache::store('redis')->get($token);
        if (!$vars) {
            throw new ComException([
                'code' => 403,
                'msg' => '令牌失效',
                'error_code' => 10000
            ]);
        } else {
            return $vars[$key];
        }
    }


    public function getToken($username, $id, $auth)
    {
        $token = $this->saveToken($id, $username, $auth);
        return $token;
    }

    /**
     * 验证token
     */
    public static function valToken()
    {
        $header = request()->header('authorization');
        try{
            $token = explode(' ', $header)[1];
        }catch(Exception $e){
            throw new AuthException();
        }
        if (!$token) {
            return false;
        }
        $vars = Cache::store('redis')->get($token);     
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


    /**
     * 验证权限
     * return auth
     */
    public static function valAuth()
    {
        $auth = self::getNowToken('auth');
        if (!$auth) {
            throw new AuthException();
        }
        return $auth;
    }
}
