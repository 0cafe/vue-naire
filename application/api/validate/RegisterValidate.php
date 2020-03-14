<?php
/*
 * @Author: your name
 * @Date: 2020-03-11 14:31:22
 * @LastEditTime: 2020-03-14 17:08:14
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \quyugou\application\api\validate\app\Comment.php
 */

namespace app\api\validate;


class RegisterValidate extends BaseValidate
{
    protected $rule = [
        'a_username' => ['require', 'max:11', 'min:5', 'normal'],
        'a_password' => ['require', 'max:11', 'min:5', 'normal']
    ];

    protected $message = [
        'a_username.require' => '用户名不能为空',
        'a_username.max' => '用户名长度不超过10个字符',
        'a_username.min' => '用户名不小于5个字符',
        'a_password.require' => '密码不能为空',
        'a_password.max' => '密码长度不超过10个字符',
        'a_password.min' => '密码不小于5个字符',
    ];
}
