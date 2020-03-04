<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-03 10:25:09
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\model\BaseModel.php
 */

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{    //会在读取和写入时 自动转化数据类型
  public $autoWriteTimestamp = true;
  protected $type = [
    'n_id'    =>  'integer',
    'o_id'    =>  'integer',
    'q_id'    =>  'integer',
    'u_id'    =>  'integer',
    'n_status' => 'integer'
  ];
}
