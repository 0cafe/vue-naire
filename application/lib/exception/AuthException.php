<?php
/*
 * @Author: your name
 * @Date: 2020-03-03 09:50:16
 * @LastEditTime: 2020-03-03 09:52:39
 * @LastEditors: your name
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\lib\exception\AuthException.php
 */

namespace app\lib\exception;


class AuthException extends BaseException
{
    public $code = 403;
    public $message = '请先登录';
    public $errorCode = 10001;
}