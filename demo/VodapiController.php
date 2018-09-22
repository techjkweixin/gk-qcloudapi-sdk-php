<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/19
 * Time: 21:38
 */

namespace App\Http\Controllers\Objectstore;

use Gkcosapi\Cospackage\Facades\Cospackage;
use Illuminate\Http\Request;


class VodapiController
{
    /**
     * VOD 返回上传签名
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function getSignKey()
    {
        $res['data']['signature'] = Cospackage::getSignKey();
        return $res;
    }

    /**
     * VOD 获取视频信息
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function getVideoInfo()
    {
        $fileId = request('fid');
        return Cospackage::getVideoInfo($fileId);
    }

    /**
     * VOD 截取视频图片
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 fileId string 视频文件ID
     * @param2 timeOffset string/array  时间点数组
     */
    public function screen()
    {
        $fileId = request('fid');
        $timeOffset = request('time_offset');
        return Cospackage::screen($fileId, $timeOffset);

    }

    /**
     * VOD 查询每天前100播放量 记得带host表示本域名下
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 fileId string 视频文件ID
     * @param2 timeOffset string/array  时间点数组
     */
    public function describePlayStatTopFiles()
    {
        $date = request('date');
        $host = request('host');
        return Cospackage::describePlayStatTopFiles($date, $host);
    }

    /**
     * VOD 增加视频标签
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 fileId string 视频文件ID
     * @param2 timeOffset string/array  时间点数组
     */
    public function createVodTags()
    {
        $fileId = request('fid');
        $tags = request('tags');
        if (empty($tags)) return false;
        return Cospackage::createVodTags($fileId, $tags);
    }

    /**
     * VOD 删除视频标签
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 fileId string 视频文件ID
     * @param2 timeOffset string/array  时间点数组
     */
    public function deleteVodTags()
    {
        $fileId = request('fid');
        $tags = request('tags');
        if (empty($tags)) return false;
        return Cospackage::deleteVodTags($fileId, $tags);
    }

    /**
     * VOD 拉取得任务事件
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function pullEvent()
    {
        return Cospackage::pullEvent('PullEvent');
    }

    /**
     * VOD 查询任务详情
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function getTaskInfo()
    {
        $vodTaskId = request('vid');
        return Cospackage::getTaskInfo($vodTaskId);
    }

    /*
     * VOD 查询任务列表
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function getTaskList()
    {
        return Cospackage::getTaskList();
    }

    /*
     * cos 前端获取签名
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function getsign()
    {
        $res['Authorization']=Cospackage::getUploadSign();
        return $res;
    }

    /*
     * cos 前端获取签名
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function getUPloadfile()
    {
        $res['Authorization']=Cospackage::getUploadSign();
        return $res;
    }
    /*
     * cos 前端获取签名
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 Action string
     * @param2 _type string
     */
    public function getUploadParam()
    {
        $key = request('key');
        $res['Authorization']=Cospackage::getUploadParam($key);
        return $res;
    }

}