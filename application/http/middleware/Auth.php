<?php
/*
 * @Author: your name
 * @Date: 2020-03-03 09:36:05
 * @LastEditTime: 2020-03-14 17:20:20
 * @LastEditors: your name
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\http\middleware\Auth.php
 */


namespace app\http\middleware;

use app\lib\exception\AuthException;
use think\facade\Cache;
use think\facade\Request;
use app\api\service\Token;
class Auth
{
    public function handle($request, \Closure $next)
    {
        $token = Token::valToken();
        if(!$token){
            throw new AuthException();
        }
        // $token = Request::header('token');
        // if (!$token) {
        //     throw new AuthException(
        //         ['msg' => '请携带令牌']);
        // }
        // $c_token = Cache::get($token);
        // if (!$c_token) {
        //     throw new AuthException();
        // }
        return $next($request);
    }
}
