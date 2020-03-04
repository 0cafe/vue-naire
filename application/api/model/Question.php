<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-03 11:43:38
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\model\Question.php
 */

namespace app\api\model;

class Question extends BaseModel
{
    public function naire()
    {
        return $this->belongsTo('Naire', 'n_id', 'id');
    }

    public function option()
    {
        return $this->hasMany('Options', 'q_id', 'id');
    }
}
