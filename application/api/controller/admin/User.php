<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-17 11:19:38
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\controller\admin\Login.php
 */

namespace app\api\controller\admin;

use app\api\model\Admin;
use think\facade\Cache;
use think\facade\Request;

class User
{
    public function getUsers()
    {
        $admin =( new Admin())->field('a_password',true)->select();   //加true 反向排除
        return $admin;
    }

    public function modifyUserStatus($id)
    {
        $admin = Admin::get($id);
        $admin->status = !$admin->status;
        $admin->save();
        
        return writeJson(202, [], '状态修改成功');
    }
}
