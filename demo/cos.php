<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/22
 * Time: 14:26
 */

// 路由信息添加在routes目录下的 路由规则文件中
// 如果要定义新的路由规则 需要在bootstrap/app.php 添加一条$app->router->group

// 获取sign
$router->get('getsign', ['as' => 'get-sign', 'uses' => 'CosapiController@getsign']);
// 前端上传VOD 获取sign
$router->get('getSignKey', ['as' => 'get-sign', 'uses' => 'CosapiController@getSignKey']);
// 屏幕截取
$router->get('screen', ['as' => 'get-sign', 'uses' => 'CosapiController@screen']);
// 上传VOD
$router->get('uploadVod', ['as' => 'get-sign', 'uses' => 'CosapiController@uploadVod']);
// VOD任务列表
$router->get('getTaskList', ['as' => 'get-sign', 'uses' => 'CosapiController@getTaskList']);
// VOD任务详情
$router->get('getTaskInfo', ['as' => 'get-sign', 'uses' => 'CosapiController@getTaskInfo']);
// VOD视频详情
$router->get('getVideoInfo', ['as' => 'get-sign', 'uses' => 'CosapiController@getVideoInfo']);
// VOD拉去任务
$router->get('pullEvent', ['as' => 'get-sign', 'uses' => 'CosapiController@pullEvent']);
// VOD添加标签
$router->get('createVodTags', ['as' => 'get-sign', 'uses' => 'CosapiController@createVodTags']);
// VOD删除标签
$router->get('deleteVodTags', ['as' => 'get-sign', 'uses' => 'CosapiController@createVodTags']);