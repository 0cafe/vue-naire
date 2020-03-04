<?php


namespace app\http\middleware;

use app\lib\exception\AuthException;
use think\facade\Cache;
use think\facade\Request;

class Auth
{
    public function handle($request, \Closure $next)
    {
        $token = Request::header('token');
        if (!$token) {
            throw new AuthException(
                ['msg' => '请携带令牌']);
        }
        $c_token = Cache::get($token);
        if (!$c_token) {
            throw new AuthException();
        }
        return $next($request);
    }
}
