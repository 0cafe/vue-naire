<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-25 14:59:52
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\model\Admin.php
 */

namespace app\api\model;

class Admin extends BaseModel
{
    // protected $dateFormat = 'Y-m-d-h';
    protected $type = [
        'last_login_time'  =>  'timestamp',
    ];
}
