<?php


namespace app\api\controller\v1;
use think\Cache;
use think\Controller;
use think\Exception;
use think\Request;


class Base extends Controller
{
    public function checkAuth()  //初始化方法 controller钟自带的方法 在里面填写逻辑代码 继承Common类的所有类都会执行_initialize
    {
        $token = Request::instance()->header('token'); //获取请求头中的token
        if (!$token) {
            throw new Exception('无权限');
        }
        $vars = Cache::get($token);
        if(!$vars){
            throw new Exception('令牌无效');
        }
    }
}