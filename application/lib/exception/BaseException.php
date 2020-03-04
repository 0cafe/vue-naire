<?php
/*
 * @Author: your name
 * @Date: 2020-03-03 09:40:07
 * @LastEditTime: 2020-03-03 09:40:30
 * @LastEditors: your name
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\lib\exception\BaseException.php
 */

namespace app\lib\exception;

use think\Exception;

/**
 * Class BaseException
 * 自定义异常类的基类
 */
class BaseException extends Exception
{
    public $code = 400;
    public $message = 'invalid parameters';
    public $errorCode = 999;

    public $shouldToClient = true;

    /**
     * 构造函数，接收一个关联数组
     * @param array $params 关联数组只应包含code、msg和errorCode，且不应该是空值
     */
    public function __construct($params = [])
    {
        if (!is_array($params)) {
            return;
        }
        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }
        if (array_key_exists('msg', $params)) {
            $this->message = $params['msg'];
        }
        if (array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }
}
