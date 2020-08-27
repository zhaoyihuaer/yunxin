<?php

namespace Yihua\Yunxin\Achieve;

use Yihuaer\Yunxin\Exceptions\HttpException;
use Yihuaer\Yunxin\Traits\HasHttpRequest;
use Yihuaer\Yunxin\Yunxin;

/**
 * Class User
 * @package Yihua\Yunxin\Achieve
 */
class User extends Yunxin
{
    use HasHttpRequest;

    /**
     * 创建云信ID
     * @param $accid  [云信ID，最大长度32字节，必须保证一个APP内唯一（只允许字母、数字、半角下划线_、@、半角点以及半角-组成，不区分大小写，会统一小写处理）]
     * @param string $name [云信ID昵称，最大长度64字节，用来PUSH推送时显示的昵称]
     * @param string $props [json属性，第三方可选填，最大长度1024字节]
     * @param string $icon  [云信ID头像URL，第三方可选填，最大长度1024]
     * @param string $token [云信ID可以指定登录token值，最大长度128字节，并更新，如果未指定，会自动生成token，并在创建成功后返回]
     * @return mixed
     * @throws HttpException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createUserId($accid, $name = '', $props = '{}', $icon = '', $token = ''){
        // 创建用户接口地址
        $url = 'https://api.netease.im/nimserver/user/create.action';

        $data = array_filter([
            'accid' => $accid,
            'name'  => $name,
            'props' => $props,
            'icon'  => $icon,
            'token' => $token
        ]);

        $data = $this->formDataBuilder($data);

        try {
            return $this->post($url,$data,[
                'AppKey' => $this->appKey,
                'Nonce' => $this->nonce,
                'CurTime' => $this->curTime,
                'CheckSum' => $this->checkSum,
                'Content-Type' => 'application/x-www-form-urlencoded;charset=utf-8'
            ]);
        } catch (\Exception $e) {

            throw new HttpException($e->getMessage(), $e->getCode(), $e);

        }

    }

}