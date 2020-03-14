<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:22:06
 * @LastEditTime: 2020-03-14 17:17:38
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

// v1版本
Route::group('v1', function () {
    Route::get('/question/:q_id', 'api/v1.Question/getQuestion');
    // Route::get('/Question','api/v1.Question/getQuestions');    
    Route::put('Question/:qid', 'api/v1.Question/update');
    Route::post('Question', 'api/v1.Question/create');
    Route::post('deleteQuestion/:qid', 'api/v1.Question/delete');

    Route::get('/options/:id', 'api/v1.Options/getOptions');
    // Route::get('/Options','api/v1.Options/getOptionss');    
    Route::post('deleteOption/:id', 'api/v1.Options/delete');
    Route::put('Options/:id', 'api/v1.Options/update');
    Route::post('Options', 'api/v1.Options/create');

    Route::get('naire/:id', 'api/v1.Naire/getNaire');
    // Route::get('/Naire','api/v1.Naire/getNaires');    
    Route::post('deleteNaire/:id', 'api/v1.Naire/delete');
    Route::post('updateNaire/', 'api/v1.Naire/update');
    Route::post('Naire', 'api/v1.Naire/create');

    Route::get('/result/:id', 'api/v1.Result/getResult');
    // Route::get('/Result','api/v1.Result/getResults');    
    Route::delete('/Result/:id', 'api/v1.Result/delete');
    Route::put('/Result/:id', 'api/v1.Result/update');
    Route::post('/Result', 'api/v1.Result/create');
})->middleware('Auth')->allowCrossDomain();

// v2 版本
Route::group('', function () {
    //二维码生成
    Route::get('qrcode', 'api/third.Qrcode/createQrcode');

    //注册
    Route::post('register', 'api/admin.Register/register');
    //登陆
    Route::post('login', 'api/admin.Login/Login');
    Route::get('valid', 'api/admin.Login/validToken');

    Route::group('naire', function () {
        // 按用户获取问卷列表
        Route::get('', 'api/v2.Naire/getNaireByUser')->middleware('Auth');
        //
        Route::get(':id', 'api/v2.Naire/getNaire')->middleware('Auth');
        //生成问卷
        Route::post('', 'api/v2.Naire/create')->middleware('Auth');
        //编辑问卷
        Route::put('edit', 'api/v2.Naire/update')->middleware('Auth');
        //修改状态
        Route::put(':id', 'api/v2.Naire/modifyStatus')->middleware('Auth');
        // 删除问卷
        Route::delete(':id', 'api/v2.Naire/delete')->middleware('Auth');
        //回答
        Route::post('/answer', 'api/v2.Naire/answer');
    });

    Route::delete('question/:id', 'api/v2.Question/delete')->middleware('Auth');
    Route::delete('option/:id', 'api/v2.Option/delete')->middleware('Auth');
})->allowCrossDomain();
