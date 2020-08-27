<?php

namespace Yihuaer\Yunxin\Achieve;

use Yihuaer\Yunxin\Exceptions\HttpException;
use Yihuaer\Yunxin\Exceptions\InvalidArgumentException;
use Yihuaer\Yunxin\Traits\HasHttpRequest;
use Yihuaer\Yunxin\Yunxin;

/**
 * 用户
 * Class User
 * @package Yihua\Yunxin\Achieve
 */
class User extends Yunxin
{
    use HasHttpRequest;

    /**
     * check
     * @param $params
     * @return array
     * @throws InvalidArgumentException
     */
    protected function checkParams($params)
    {
        //$params = array_filter($params);
        if (!isset($params['accid']) || empty($params['accid'])) {
            throw new InvalidArgumentException('Invalid accid value');
        }
        // 设置校对参数
        $this->checkSumBuilder();
        return $params;
    }

    /**
     * 创建云信ID 创建账户
     * @param array $params [$accid,$name,$props,$icon,$token]
     * @param $accid  [云信ID，最大长度32字节，必须保证一个APP内唯一（只允许字母、数字、半角下划线_、@、半角点以及半角-组成，不区分大小写，会统一小写处理）]
     * @param string $name [云信ID昵称，最大长度64字节，用来PUSH推送时显示的昵称]
     * @param string $props [json属性，第三方可选填，最大长度1024字节]
     * @param string $icon  [云信ID头像URL，第三方可选填，最大长度1024]
     * @param string $token [云信ID可以指定登录token值，最大长度128字节，并更新，如果未指定，会自动生成token，并在创建成功后返回]
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function createUserId(array $params)
    {
        $params = $this->checkParams($params);

        // 创建用户接口地址
        $url = 'https://api.netease.im/nimserver/user/create.action';
        // guzzle 处理
        //$data = $this->formDataBuilder($data);

        return $this->post($url,$params,$this->getHeaders());
    }


    /**
     * 更新账户
     * @param array $params [accid,name,props,token]
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function updateUserId(array $params)
    {
        $params = $this->checkParams($params);

        $url = 'https://api.netease.im/nimserver/user/update.action';

        return $this->post($url,$params,$this->getHeaders());
    }

    /**
     * 更新token 获取新token
     * @param array $params
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function updateUserToken(array $params)
    {
        $params = $this->checkParams($params);

        $url = 'https://api.netease.im/nimserver/user/refreshToken.action';

        return $this->post($url,$params,$this->getHeaders());
    }

    /**
     * 封禁云信ID
     * 第三方禁用某个云信ID的IM功能,封禁云信ID后，此ID将不能登陆云信imserver
     * @param array $params
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function blockUserId(array $params)
    {
        $params = $this->checkParams($params);

        $url = 'https://api.netease.im/nimserver/user/block.action';

        return $this->post($url,$params,$this->getHeaders());
    }

    /**
     * 解禁云信ID
     * @param array $params
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function unblockUserId(array $params)
    {
        $params = $this->checkParams($params);

        $url = 'https://api.netease.im/nimserver/user/unblock.action';

        return $this->post($url,$params,$this->getHeaders());
    }

    /**
     * @param array $params
     * @param  $accid       [云信ID，最大长度32字节，必须保证一个APP内唯一（只允许字母、数字、半角下划线_、@、半角点以及半角-组成，不区分大小写，会统一小写处理）]
     * @param  $name        [云信ID昵称，最大长度64字节，用来PUSH推送时显示的昵称]
     * @param  $icon        [用户icon，最大长度256字节]
     * @param  $sign        [用户签名，最大长度256字节]
     * @param  $email       [用户email，最大长度64字节]
     * @param  $birth       [用户生日，最大长度16字节]
     * @param  $mobile      [用户mobile，最大长度32字节]
     * @param  $ex          [用户名片扩展字段，最大长度1024字节，用户可自行扩展，建议封装成JSON字符串]
     * @param  $gender      [用户性别，0表示未知，1表示男，2女表示女，其它会报参数错误]
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function updateUinfo(array $params)
    {

        $params = $this->checkParams($params);

        $url = 'https://api.netease.im/nimserver/user/updateUinfo.action';

        return $this->post($url,$params,$this->getHeaders());
    }

    /**
     * 获取用户名片 可批量
     * @param array $accids  [用户帐号（例如：JSONArray对应的accid串，如："zhangsan"，如果解析出错，会报414）（一次查询最多为200）]
     * @return mixed
     */
    public function getUinfos(array $accids)
    {
        $accids = $this->checkParams($accids);

        $url = 'https://api.netease.im/nimserver/user/getUinfos.action';

        $params = array(
            'accids' => json_encode($accids['accid'])
        );

        return $this->post($url,$params,$this->getHeaders());
    }
}