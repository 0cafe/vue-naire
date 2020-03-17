<?php
/*
 * @Author: your name
 * @Date: 2020-03-02 17:22:06
 * @LastEditTime: 2020-03-17 10:40:17
 * @LastEditors: your name
 * @Description: In User Settings Edit
 * @FilePath: \questionnaire\config\cache.php
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

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    // 缓存配置为复合类型
    'type'  =>  'complex',
 
    'default'	=>	[
        'type'	=>	'file',
        // 全局缓存有效期（0为永久有效）
        'expire'=>  0,
        // 缓存前缀
        'prefix'=>  '',
        // 缓存目录
        'path'  =>  '',
    ],
 
    // 需要安装依赖composer require predis/predis
    'redis'	=>	[
        'type'	=>	'redis',
        'host'	=>	'127.0.0.1',
        'port' => 6379,
        // 'password' => 'xxxxxxxx',
        // 全局缓存有效期（0为永久有效）
        //        'expire'=>  0,
        // 缓存前缀
        // 'prefix'=>  'think:',
        // 'timeout'=> 3600
    ],
    // 添加更多的缓存类型设置
];
