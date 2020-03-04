<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:22:06
 * @LastEditTime: 2020-03-04 16:07:24
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\route\route.php
 */
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::group('', function () {
    Route::post('login','api/admin.Login/Login');
    Route::get('valid','api/admin.Login/validToken');
    Route::group('naire', function () {
        Route::get('', 'api/v1.Naire/getNaireByUser');
        Route::get('t', 'api/v1.Naire/clear');
        Route::post('', 'api/v1.Naire/create');
        Route::delete(':id', 'api/v1.Naire/delete');
    });
})->allowCrossDomain();
