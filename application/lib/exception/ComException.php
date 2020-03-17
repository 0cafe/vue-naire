<?php
/*
 * @Author: your name
 * @Date: 2020-03-03 09:45:24
 * @LastEditTime: 2020-03-16 10:40:22
 * @LastEditors: your name
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\lib\exception\ComException.php
 */

namespace app\lib\exception;

class ComException extends BaseException
{
    public $code = 500;
    public $message = '内部错误';
    public $errorCode = 50000;
}
