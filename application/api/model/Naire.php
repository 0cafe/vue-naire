<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:24:20
 * @LastEditTime: 2020-03-16 15:36:49
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\application\api\model\Naire.php
 */

namespace app\api\model;

class Naire extends BaseModel
{


   /**
    * 分页获取
    * params传入count,start
    * query传入['key'=>$key] 
    */
   public static function nairePage($params,$query = [])
   {
      // 存放数组查询条件的数组
      // $query = [
      //    'status' => 1
      // ];
      // if(array_key_exists('order_no',$params)){
      //     $query[] = ['order_no', 'like', '%' . $params['order_no'] . '%'];
      // }
       // 应用条件查询
      $where = $query; 
      $orderList = self::where($where);
      $pagingData = $orderList
      ->order('create_time desc')
      ->paginate($params['count'], false, ['page' =>$params['page']]);    //第二个参数是开启简洁模式  ,不返回总记录数
      return $pagingData;
   }



   public function questions()
   {
      return $this->hasMany('Question', 'n_id', 'id');
   }

   public function option()
   {
      return $this->hasMany('Option', 'n_id', 'id');
   }
}
