<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 16:38:25
 * @LastEditTime: 2020-03-02 16:44:26
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \naire\application\api\behavior\CORS.php
 */


namespace app\api\behavior;


use think\Response;

//  行为 需要在 tags.php里注册
class CORS
{
    public function appInit(&$params)
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: token,Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: POST,GET');
        if(request()->isOptions()){
            exit();
        }
    }
}