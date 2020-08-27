<?php

namespace Yihuaer\Yunxin;

use Yihuaer\Yunxin\Exceptions\InvalidArgumentException;

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
    public function __construct(array $config)
    {
        if (!isset($config['app_key'])) {
            throw new InvalidArgumentException('Invalid app_key value');
        }
        if (!isset($config['app_secret'])) {
            throw new InvalidArgumentException('Invalid app_secret value');
        }

        $this->appKey = $config['app_key'];
        $this->appSecret = $config['app_secret'];
    }

    /**
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'AppKey' => $this->appKey,
            'Nonce' => $this->nonce,
            'CurTime' => $this->curTime,
            'CheckSum' => $this->checkSum,
            'Content-Type' => 'application/x-www-form-urlencoded;charset=utf-8'
        ];
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
            $this->nonce .= $hex_digits[rand(0,15)];
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