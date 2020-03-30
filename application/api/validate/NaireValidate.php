<?php
/*
 * @Author: your name
 * @Date: 2020-03-11 14:31:22
 * @LastEditTime: 2020-03-26 17:22:11
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \quyugou\application\api\validate\app\Comment.php
 */

namespace app\api\validate;


class NaireValidate extends BaseValidate
{
    protected $rule = [
        'n_title' => ['require', 'max:30', 'min:5', 'normal'],
    ];

    protected $message = [
        'n_title.require' => '问卷标题不能为空',
        'n_title.max' => '问卷标题长度不超过30个字符',
        'n_title.min' => '问卷标题不小于5个字符',
    ];
}
