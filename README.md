#集客腾讯云cos扩张包使用说明SDK
----

腾讯云[对象存储服务 COS](http://www.qcloud.com/wiki/COS%E4%BA%A7%E5%93%81%E4%BB%8B%E7%BB%8D) PHP SDK

 俊峰啊，如何安装？
----
 项目根目录composer.json配置require
 ```
    "require": {
          "gk-qcloudapi-sdk-php/cospackage": "~2.1",
        "qcloud/cos-sdk-v5": ">=1.0",
        "qcloud/vod-sdk-v5": "v1.2.1"
        }
        
      "repositories": { 
        "cospackage": {
            "type": "vcs",
            "url": "https://github.com/techjkweixin/gk-qcloudapi-sdk-php.git"
        }
    }
 ```

通过COMPOSER 命令获取项目
 ----
```     
 composer update
```

配置项目
 ----
#####使用的是lumen框架在 bootstrap下的app.php
```
 $app->register(Gkcosapi\Cospackage\CospackageServiceProvider::class);
 $app->configure('cospackage');

> 如果需要新增路由模块需要如下操作
> 注意：
> 1、需要在Http/controllers/创建Objectstore目录且复制扩展包DEMO目录中的VodapiController文件到该目录
> 2、扩展包DEMO目录中的cos.php复制到routes目录中
> 3、将下列代码一并写入bootstrap/app.php

$app->router->group([
    'prefix' => env('APP_VERSION') . '/api/cos',
    'namespace' => 'App\Http\Controllers\Objectstore',
], function ($router) {
    require __DIR__ . '/../routes/cos.php';
});
```
----
#####使用的是laravel框架在 config/app.php
```
'providers' => [
    ...
    Gkcosapi\Cospackage\CospackageServiceProvider::class,
    ... ] 
'aliases' => [
    ...
    'TencentIm' => Gkcosapi\Cospackage\Facade\Cospackage::class,
    ... ]
```
----
#####用发布命令将包配置复制到本地配置
 $ php artisan vendor:publish --provider="Eddie\Tencent\Provider\ImServiceProvider"
#####初始化扩展包
        composer dump-autoload

安装
----

```
composer require jerray/qcloud-cos-php-sdk
```

COS文件图片上传使用方法
--------


#####1、在业务层引用扩展包 
```
use Gkcosapi\Cospackage\Facades\Cospackage;
```
#####2调取扩展函数 进行cos文件上传工作
```
Cospackage::uploadFile($file->getPathname(), 'jpg');
```

#####3、操作函数介绍：
```
Cospackage::uploadFile($file->getPathname(), 'jpg');//cos文件上传工作

Cospackage::getResource($url)//获取文件资源

Cospackage::getUploadSign($fileType = "image", $method = "post")//获取cos签名

Cospackage::getUploadParam($key)//获取文件上传参数 key:定义的文件目录名称或mercharID(生成目录)
```
VOd上传使用方法
--------
#####1、同COS一样引入扩展包;
#####2、使用方法同理：
```
Cospackage::getSignKey();
```
#####3、操作函数介绍请参考扩展包demo目录中VodapiController.php
