<?php

namespace Fakeronline\Chinapnr\Utils;

/**
 * Curl请求类  TODO:临时做法，只支持POST提交，后续有待改善
 */
class Curl{

    private $curl = null;
    private $timeOut = 10;

    public function __construct($url){
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $this->timeOut); //超时设置  单位:秒
        curl_setopt($this->curl, CURLOPT_URL, $url);

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);

        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false); //证书
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
    }

    public function setHeader(array $header){
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $header);
        return $this;
    }

    public function setData($data = null){
        if(is_array($data)){
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }else{
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        }
        return $this;
    }

    public function setTimeOut($second){
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $second); //超时设置  单位:秒
    }

    function get()
    {
        if(is_null($this->curl)){
            throw new InvalidArgumentException('实例丢失或未创建实例!');
        }

        return curl_exec($this->curl);
    }



}