<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 10:10
 */
return [
    'options' => [
        'app_id' => env('COS_APP_ID', '1255605079'),//	开发者访问 COS 服务时拥有的用户维度唯一资源标识，用以标识资源
        'secret_id' => env('COS_SECRET_ID', 'AKIDYv2tVrhnSs3yd253f17xXrwlnbAUtBBw'),//开发者拥有的项目身份识别 ID，用以身份认证
        'secret_key' => env('COS_SECRET_KEY', 'e3D8tRpyta6NO9fvvf8ey3tWt0rSovmN'),//开发者拥有的项目身份密钥
        'bucket' => env('COS_BUCKET', 'share-static'),//COS 中用于存储数据的容器
        'region' => env('COS_REGION', 'cn-sorth'),//域名中的地域信息。枚举值参见 可用地域 文档，如：ap-beijing, ap-hongkong, eu-frankfurt 等
    ] // API 配置项
];