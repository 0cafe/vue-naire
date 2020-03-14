<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-12 17:31:41
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\model\Naire.php
 */

namespace app\api\model;

class Naire extends BaseModel
{

   public function questions()
   {
      return $this->hasMany('Question', 'n_id', 'id');
   }

   public function option()
   {
      return $this->hasMany('Option', 'n_id', 'id');
   }
}
