<?php
/*
 * @Author: your name
 * @Date: 2020-03-03 09:36:05
 * @LastEditTime: 2020-03-16 11:34:35
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\http\middleware\Auth.php
 */


namespace app\http\middleware;

use app\lib\exception\AuthException;
use app\api\service\Token;

class AdminAuth
{
    public function handle($request, \Closure $next)
    {
        $auth = Token::getNowToken('auth');
        if (!$auth || $auth !== 2) {
            throw new AuthException(['msg'=>'无权限']);
        }
        return $next($request);
    }
}
