<?php

namespace Yihuaer\Yunxin;

/**
 * Class Yunxin
 * @package Yihuaer\Yunxin
 */
class Yunxin
{
    /**
     * @var string
     */
    protected $appKey;

    /**
     * @var string
     */
    protected $appSecret;

    /**
     * 随机数
     * @var
     */
    protected $nonce;

    /**
     * 时间戳
     * @var
     */
    protected $curTime;

    /**
     * @var
     */
    protected $checkSum;

    const HEX_DIGITS = "0a1b2c3d4e5f6g7h8i9j";

    /**
     * Yunxin constructor.
     * @param string $appKey
     * @param string $appSecret
     */
    public function __construct(string $appKey,string $appSecret)
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
    }

    /**
     * API checksum校验生成
     */
    public function checkSumBuilder(){
        //此部分生成随机字符串
        $hex_digits = self::HEX_DIGITS;
        $this->nonce;
        //随机字符串最大128个字符，也可以小于该数
        for($i = 0;$i < 128;$i++){
            $this->Nonce .= $hex_digits[rand(0,15)];
        }
        $this->curTime = (string)(time());	//当前时间戳，以秒为单位

        $join_string = $this->appSecret.$this->nonce.$this->curTime;
        $this->checkSum = sha1($join_string);
    }

    /**
     * 生成form data参数
     * @param array $data
     * @return string
     */
    protected function formDataBuilder(array $data)
    {
        $postData = [];
        foreach ($data as $key=>$value){
            array_push($postData, $key.'='.urlencode($value));
        }
        return join('&', $postData);
    }
}