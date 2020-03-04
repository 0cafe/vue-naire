<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:22:06
 * @LastEditTime: 2020-03-02 17:31:11
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\common.php
 */
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function setPwd($data){
    return md5($data.'_#sing_ty');
}

/**
 * 统一返回格式
 * @param $code
 * @param $errorCode
 * @param $data
 * @param $msg
 * @return \think\response\Json
 */
function writeJson($code, $data, $msg = 'ok', $errorCode = 0)  
{
    $data = [
        'error_code' => $errorCode,
        'result' => $data,
        'msg' => $msg
    ];
    return json($data, $code);
}