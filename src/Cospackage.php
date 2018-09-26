<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10 9:47
 */

namespace Gkcosapi\Cospackage;

use Gkcosapi\Cospackage\statusException\StatusException;
use Gkcosapi\Cospackage\statusException\CurlCommon;
use Gkcosapi\Cospackage\CosService;

class Cospackage extends StatusException
{
    protected $secretId;
    protected $secretKey;
    protected $options;
    protected $cosService;

    public function __construct()
    {
        $this->options = config('cospackage.options');
        $this->secretId = $this->options['secret_id'];
        $this->secretKey = $this->options['secret_key'];
    }

    public function getService()
    {
        $this->cosService = new CosService();
        return $this->cosService;
    }

    /**
     * VOD 返回上传签名[前端上传业务使用]
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 _application string
     * @param2 _type string
     */
    public function getSignKey()
    {
        return CurlCommon::sign($this->secretId, $this->secretKey);
    }

    /**
     * VOD 拉去任务事件
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function pullEvent($action)
    {
        $privateParams = [];
        return $this->getService()->generateUrl($action, $privateParams, 'GET');
    }

    /**
     * VOD 查询任务事件列表
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function getTaskList()
    {
        return $this->getService()->generateUrl('GetTaskList', ['status' => 'PROCESSING'], 'GET');
    }

    /**
     * VOD 查询视频前100播放量
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function describePlayStatTopFiles($date,$host='')
    {
        return $this->getService()->generateUrl('DescribePlayStatTopFiles', ['date' => $date,'host'=>$host], 'GET');
    }

    /**
     * VOD 查询任务详情
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function getTaskInfo($vodTaskId)
    {
        if (empty($vodTaskId)) return false;

        return $this->getService()->generateUrl('GetTaskInfo', ['vodTaskId' => $vodTaskId], 'GET');
    }

    /**
     * VOD 新建视频标签
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function createVodTags($fileId, $tags)
    {
        $privateParams = CurlCommon::commonList($tags, 'tags');
        $privateParams['fileId'] = $fileId;
        return $this->getService()->generateUrl('CreateVodTags', $privateParams, 'GET');
    }

    /**
     * VOD 删除视频标签
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function deleteVodTags($fileId, $tags)
    {
        $privateParams = CurlCommon::commonList($tags, 'tags');
        $privateParams['fileId'] = $fileId;
        return $this->getService()->generateUrl('DeleteVodTags', $privateParams, 'GET');
    }

    /**
     * VOD 获取视频信息详情
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 fileId string  当前视频文件ID
     * @param2 _type string
     */
    public function getVideoInfo($fileId)
    {
        if (empty($fileId)) return false;
        return $this->getService()->generateUrl('GetVideoInfo', ['fileId' => $fileId], 'GET');;
    }

    /**
     * VOD 截取视频图片
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 fileId string  当前视频文件ID
     * @param2 _type string
     */
    public function screen($fileId, $timeOffset)
    {
        $fileId = request('fid',$fileId);
        $privateParams = CurlCommon::commonList($timeOffset, 'timeOffset');
        $privateParams['fileId'] = $fileId;
        $privateParams['definition'] = 10;
        return $this->getService()->generateUrl('CreateSnapshotByTimeOffset', $privateParams, 'GET');
    }

    /**
     * API 获取上传参数
     * @return \Illuminate\Http\JsonResponse
     * @author lwj <381244953@qq.com>
     * @since huangjinbing <373768442@qq.com>
     * @param1 _application string
     * @param2 _type string
     */
    public function getUploadParam($key)
    {
        // 检查必填参数
        $pathname = time() . rand(10000, 99999);

        // 获取上传文件夹
        $data['path'] = $key . date('/Y/m/d') . '/' . $pathname;

        // 返回存储桶，地区
        $data['bucket'] = env('COS_BUCKET') . '-' . env('COS_APP_ID');

        // 存储地区
        $regionmap = [
            'cn-east' => 'ap-shanghai',
            'cn-sorth' => 'ap-guangzhou',
            'cn-north' => 'ap-beijing-1',
            'cn-south-2' => 'ap-guangzhou-2',
            'cn-southwest' => 'ap-chengdu',
            'sg' => 'ap-singapore'
        ];
        $region = env('COS_REGION', 'cn-sorth');
        $data['region'] = $regionmap[$region];

        return $data;
    }

    /**
     * API 获取上传签名
     * @return \Illuminate\Http\JsonResponse
     * @author lwj <381244953@qq.com>
     * @since huangjinbing <373768442@qq.com>
     * @param1 _fileType string
     * @param2 _method string
     */
    public function getUploadSign($fileType = "image", $method = "post")
    {
        $cosService = new CosService();

        // 生成API签名
        if ($fileType == 'image') {
            $data['sign'] = $cosService->createImageSign($method);
        } else {
            $data['sign'] = $cosService->createVideoSign();
        }

        return $data;
    }

    /**
     * API 获取资源路径
     * @return array
     * @author lwj <381244953@qq.com>
     * @since huangjinbing <373768442@qq.com>
     * @param1 _url string
     */
    public function getResource($url)
    {
        $fileUrl = $url;
        // 获取文件的详细信息
        $imageInfo = CurlCommon::requestWithHeader($fileUrl . '?imageInfo', 'GET');
        if (!isset($imageInfo['size'])) return false;

        // 整合入库数据
        $pathInfo = pathinfo($fileUrl);
        $data = [
            'name' => $pathInfo['basename'] ?? '',
            'url' => $url,
            'file_type' => $imageInfo['format'] ?? '',
            'file_size' => $imageInfo['size'] ?? 0,
            'width' => $imageInfo['width'] ?? 0,
            'height' => $imageInfo['height'] ?? 0
        ];
        return $data;
    }

}
