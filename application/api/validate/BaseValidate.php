<?php
/*
 * @Author: your name
 * @Date: 2020-03-13 17:08:12
 * @LastEditTime: 2020-03-27 15:19:27
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\validate\BaseValidate.php
 */


namespace app\api\validate;

use think\Validate;

class BaseValidate extends Validate
{
    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return $field . '必须是正整数';
    }

    protected function isNotEmpty($value, $rule = '', $data = '', $field = '')
    {
        if (empty($value)) {
            return $field . '不允许为空';
        } else {
            return true;
        }
    }

    //没有使用TP的正则验证，集中在一处方便以后修改
    //不推荐使用正则，因为复用性太差
    //手机号的验证规则
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // 不包括特殊符
    protected function normal($value)
    {
        $rule = '/\!|\$|\%|\*|\?|\||\~|\/|\@|\^|\&|\`|\=|\\\|\！|\<|\《|\>|\》|\(|\)|\（|\）|\s+/';
        $result = preg_match($rule, $value);
        return $result ? '不能含有非法字符' : true;
    }

    protected function noSpecial($value)
    {
        $rule = '^[\u4e00-\u9fa5_a-zA-Z0-9]+$';
        $result = preg_match($rule, $value);
    }
}
