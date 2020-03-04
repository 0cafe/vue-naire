<?php

namespace app\lib\exception;

class ComException extends BaseException
{
    public $code = 500;
    public $message = '内部错误';
    public $errorCode = 10000;
}
