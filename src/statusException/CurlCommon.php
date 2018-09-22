<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10 18:37
 */

namespace Gkcosapi\Cospackage\statusException;


class CurlCommon
{
    /**
     * api接口 添加多记录，判断是一条或多条
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 data string/array  当前提交的数据
     * @param2 title string  参数字段名前缀
     */
    public static function commonList($data, $title)
    {
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                $privateParams[$title . '.' . $key] = $value;
            }
        } else {
            $privateParams = [
                $title . '.0' => $data
            ];
        }
        return $privateParams;
    }

    /**
     * api接口 内部请求VOD 调用签名
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 data string/array  当前提交的数据
     * @param2 title string  参数字段名前缀
     */
    public static function getsign($url, $secret_key, $ReqParaArray, $HttpMethod)
    {
        $SigTxt = $HttpMethod . $url . '?';
        $isFirst = true;
        foreach ($ReqParaArray as $key => $value) {
            if (!$isFirst) {
                $SigTxt = $SigTxt . "&";
            }
            $isFirst = false;
            /*拼接签名原文时，如果参数名称中携带_，需要替换成.*/
            if (strpos($key, '_')) {
                $key = str_replace('_', '.', $key);
            }
            $SigTxt = $SigTxt . $key . "=" . $value;
        }
        // 计算签名
        $Signature = base64_encode(hash_hmac('sha1', $SigTxt, $secret_key, true));
        return $Signature;
    }

    /**
     * api接口 外部请求VOD 调用签名
     * @return Object
     * @author lwj <381244953@qq.com>
     * @param1 data string/array  当前提交的数据
     * @param2 title string  参数字段名前缀
     */
    public static function sign($secretId, $secretKey)
    {
        // 确定签名的当前时间和失效时间
        $current = time();
        $expired = $current + 86400;  // 签名有效期：1天

        // 向参数列表填入参数
        $arg_list = array(
            "secretId" => $secretId,
            "currentTimeStamp" => $current,
            "expireTime" => $expired,
            "random" => rand());
        // 计算签名
        $orignal = http_build_query($arg_list);
        $signature = base64_encode(hash_hmac('SHA1', $orignal, $secretKey, true) . $orignal);

        return $signature;
    }

    /**
     * curl请求
     * @param $url
     * @param string $method
     * @param array $header
     * @param array $body
     * @return mixed
     */
    public static function requestWithHeader($url, $method = 'POST', $header = array(), $body = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        switch ($method) {
            case "GET" :
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
            case "POST" :
                curl_setopt($ch, CURLOPT_POST, true);
                break;
            case "PUT" :
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                break;
            case "DELETE" :
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'SSTS Browser/1.0');
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        if (isset($body{3}) > 0) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        if (count($header) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $ret = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($ret, true);
        return $data;
    }

    /**
     * 事务异常错误日志输出
     * @param string $content
     */
    public static function logUnusualError(\Exception $exception)
    {
        Log::error('**************************');
        Log::error(print_r($exception->getFile(), true));
        Log::error(print_r($exception->getLine(), true));
        Log::error(print_r($exception->getMessage(), true));
        Log::error('**************************');
    }

}
