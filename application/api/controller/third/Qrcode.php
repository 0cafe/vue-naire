<?php
/*
 * @Author: your name
 * @Date: 2020-03-13 15:18:06
 * @LastEditTime: 2020-03-13 16:11:14
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\controller\third\Qrcode.php
 */

namespace app\api\controller\third;

use Endroid\QrCode\QrCode as QrcodeSDK;
use think\facade\Request;

class Qrcode
{
    public function createQrcode()
    {
        $params = Request::get();
        $url = $params['url'];
        $qrCode = new QrcodeSDK('http://baidu.com');
        $qrCode->setLabel('问卷填写');
        header('Content-Type: ' . $qrCode->getContentType());
        echo $qrCode->writeString();
        exit;
    }
}
