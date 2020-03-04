<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-03 15:02:28
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\model\Options.php
 */

namespace app\api\model;

class Options extends BaseModel
{
    public function question()
    {
        return $this->belongsTo('Question','q_id','id');
    }
}
